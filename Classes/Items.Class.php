<?php
include_once __DIR__ . '/Dbh.Class.php';

class Items extends Dbh {

    // Count low stock products
    protected function countLowStocks($userID){
        
        $lowStockLimit = 5;

        $query = "
            SELECT COUNT(*) AS low_stock_count
            FROM inventory
            WHERE USER_ID = ?
            AND QUANTITY <= ?
            AND IS_ACTIVE = 1
        ";

        $stmt = $this->connection()->prepare($query);

        if (!$stmt->execute([$userID, $lowStockLimit])) {
            return 0;
        }

        return (int) $stmt->fetch(PDO::FETCH_ASSOC)['low_stock_count'];
    }

    // Count out of stock products
    protected function countOutOfStocks($userID){
        
        $StockLimit = 0;

        $query = "
            SELECT COUNT(*) AS out_of_stock_count
            FROM inventory
            WHERE USER_ID = ?
            AND QUANTITY = ?
            AND IS_ACTIVE = 1
        ";

        $stmt = $this->connection()->prepare($query);

        if (!$stmt->execute([$userID, $StockLimit])) {
            return 0;
        }

        return (int) $stmt->fetch(PDO::FETCH_ASSOC)['out_of_stock_count'];
    }

    // Count pending products
    protected function countPending($userID){
        
        $query = "
            SELECT COUNT(*) AS pending_count
            FROM reservation
            WHERE USER_ID = ?
            AND STATUS = 'On Process'
        ";

        $stmt = $this->connection()->prepare($query);

        if (!$stmt->execute([$userID])) {
            return 0;
        }

        return (int) $stmt->fetch(PDO::FETCH_ASSOC)['pending_count'];
    }

    // Count reserved products
    protected function countReserved($userID){

        $query = "
            SELECT COUNT(*) AS reserved_count
            FROM reservation
            WHERE USER_ID = ?
            AND STATUS = 'Reserved'
        ";

        $stmt = $this->connection()->prepare($query);

        if (!$stmt->execute([$userID])) {
            return 0;
        }

        return (int) $stmt->fetch(PDO::FETCH_ASSOC)['reserved_count'];
    }

    // Get all items from inventory table
    protected function getInventory($userID) {
        $query = "SELECT * FROM inventory WHERE USER_ID = ? && IS_ACTIVE = 1";
        $stmt = $this->connection()->prepare($query);

        if (!$stmt->execute([$userID])) {
            return false;
        }

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get all items from reservation table
    protected function getReservations($userID) {
        $query = "SELECT * FROM reservation WHERE USER_ID = ? && IS_ACTIVE = 1";
        $stmt = $this->connection()->prepare($query);

        if (!$stmt->execute([$userID])) {
            return false;
        }

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get all stocks from stocks table
    protected function getStocks($userID) {
        $query = "
                SELECT
                    s.STOCKS_ID,
                    s.MATERIAL_NAME,
                    s.USER_ID,
                    s.SOURCE_TABLE,
                    s.SOURCE_ID,
                    s.QUANTITY,
                    s.TRANSACTION_TYPE,
                    s.TIME_AND_DATE,
                    (s.QUANTITY * i.PRICE) AS TOTAL_PRICE
                FROM stocks_log s
                LEFT JOIN inventory i
                    ON s.MATERIAL_NAME = i.MATERIAL_NAME
                    AND i.IS_ACTIVE = 1
                WHERE s.USER_ID = ?
                ";
        $stmt = $this->connection()->prepare($query);

        if (!$stmt->execute([$userID])) {
            return false;
        }

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Insert new item to inventory
    protected function insertItem($userID, $materialName, $quantity, $price, $description) {

        $query = "
            INSERT INTO inventory (USER_ID, MATERIAL_NAME, QUANTITY, PRICE, DESCRIPTION)
            VALUES (?, ?, ?, ?, ?)
        ";

        $stmt = $this->connection()->prepare($query);

        if (!$stmt->execute([$userID, $materialName, $quantity, $price, $description])) {
            return false;
        }

        $sourceID = $this->connection()->lastInsertId();
        $type = "INSERTED ITEM";

        // Log stock addition
        $this->logStockChange($materialName, $userID, 'inventory', $sourceID, $quantity, $type);

        return true;
    }

    // Insert new reservation
    protected function insertReservation($materialID, $userID, $quantity, $requestor, $remarks, $claimDate) {

        $query = "
            INSERT INTO reservation (MATERIAL_ID, USER_ID, QUANTITY, REQUESTOR, PURPOSE, CLAIMING_DATE)
            VALUES (?, ?, ?, ?, ?, ?)
        ";

        $stmt = $this->connection()->prepare($query);

        if (!$stmt->execute([$materialID, $userID, $quantity, $requestor, $remarks, $claimDate])) {
            return false;
        }

        $sourceID = $this->connection()->lastInsertId();

        // Fetch the material name from inventory
        $stmt2 = $this->connection()->prepare("SELECT MATERIAL_NAME FROM inventory WHERE MATERIAL_ID = ?");

        if(!$stmt2->execute([$materialID])){
            return false;
        }
    
        $materialName = $stmt2->fetch(PDO::FETCH_ASSOC)['MATERIAL_NAME'] ?? 'Unknown';

        $type = "RESERVED ITEM";
        

        // Log stock reservation
        $this->logStockChange($materialName, $userID, 'reservation', $sourceID, $quantity, $type);

        return true;
    }

    // Update existing item in inventory
    protected function updateItemDB($materialName, $quantity, $price, $description, $ID) {

        $query = "
            UPDATE inventory
            SET MATERIAL_NAME = ?, QUANTITY = ?, PRICE = ?, DESCRIPTION = ?
            WHERE MATERIAL_ID = ?
        ";

        $stmt = $this->connection()->prepare($query);

        if (!$stmt->execute([$materialName, $quantity, $price, $description, $ID])) {
            return false;
        }

        return true;
    }

    // Update existing reservation
    protected function updateReservationDB($reservationID, $quantity, $requestor, $purpose, $claimingDate) {

        $query = "
            UPDATE reservation
            SET QUANTITY = ?, REQUESTOR = ?, PURPOSE = ?, CLAIMING_DATE = ?
            WHERE RESERVATION_ID = ?
        ";

        $stmt = $this->connection()->prepare($query);

        if (!$stmt->execute([$quantity, $requestor, $purpose, $claimingDate, $reservationID])) {
            return false;
        }

        return true;
    }

    // Update Reservation Status
    protected function updateReservationStatusDB($reservationID, $status) {

        // Update reservation status
        $query = "
            UPDATE reservation
            SET STATUS = ?
            WHERE RESERVATION_ID = ?
        ";
        $stmt = $this->connection()->prepare($query);

        if (!$stmt->execute([$status, $reservationID])) {
            return false;
        }

        // Fetch the stock log record for this reservation
        $stockRecord = $this->fetchStockData($reservationID);

        if ($stockRecord) {
            $materialName = $stockRecord['MATERIAL_NAME'];
            $quantity     = $stockRecord['QUANTITY'];
            $transaction  = $stockRecord['TRANSACTION_TYPE'];

            // Example: update the transaction type to reflect new status
            $this->logStockChange($materialName, $stockRecord['USER_ID'], 'reservation', $reservationID, $quantity, "STATUS UPDATED TO $status");
        }

        return true;
    }

        

    // Delete existing item in inventory
    protected function deleteItemDB($ID) {

        $query = "
            UPDATE inventory
            SET IS_ACTIVE = 0
            WHERE MATERIAL_ID = ?
        ";

        $stmt = $this->connection()->prepare($query);

        if (!$stmt->execute([$ID])) {
            return false;
        }

        return true;
    }

    // Delete existing reservation in inventory
    protected function deleteReservationDB($ID) {

        $query = "
            UPDATE reservation
            SET IS_ACTIVE = 0
            WHERE RESERVATION_ID = ?
        ";

        $stmt = $this->connection()->prepare($query);

        if (!$stmt->execute([$ID])) {
            return false;
        }

        return true;
    }

    // Private function to log stock changes
    private function logStockChange($materialName, $userID, $sourceTable, $sourceID, $quantity, $transactionType) {

        $query = "
            INSERT INTO stocks_log (MATERIAL_NAME, USER_ID, SOURCE_TABLE, SOURCE_ID, QUANTITY, TRANSACTION_TYPE)
            VALUES (?, ?, ?, ?, ?, ?)
        ";

        $stmt = $this->connection()->prepare($query);

        if (!$stmt->execute([$materialName, $userID, $sourceTable, $sourceID, $quantity, $transactionType])) {
            return false;
        }

        return true;
    }

    // Private function to fetch stock data by reservation ID
    private function fetchStockData($reservationID) {

        $query = "
            SELECT * FROM stocks_log
            WHERE SOURCE_ID = ? AND SOURCE_TABLE = 'reservation'
        ";

        $stmt = $this->connection()->prepare($query);

        if (!$stmt->execute([$reservationID])) {
            return false; // query failed
        }

        // Fetch the first matching record
        $stockData = $stmt->fetch(PDO::FETCH_ASSOC);

        return $stockData ?: null; // return null if no record found
    }

}
