<?php
include_once __DIR__ . '/Dbh.Class.php';

class Items extends Dbh {

    // Get all items from inventory table
    protected function getInventory($userID) {
        $query = "SELECT * FROM inventory WHERE USER_ID = ?";
        $stmt = $this->connection()->prepare($query);

        if (!$stmt->execute([$userID])) {
            return false;
        }

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get all items from reservation table
    protected function getReservations($userID) {
        $query = "SELECT * FROM reservation WHERE USER_ID = ?";
        $stmt = $this->connection()->prepare($query);

        if (!$stmt->execute([$userID])) {
            return false;
        }

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get all stocks from stocks table
    protected function getStocks($userID) {
        $query = "SELECT * FROM stocks_log WHERE USER_ID = ?";
        $stmt = $this->connection()->prepare($query);

        if (!$stmt->execute([$userID])) {
            return false;
        }

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Insert new item to inventory
    protected function insertItem($userID, $materialName, $quantity, $price, $size, $model) {

        $query = "
            INSERT INTO inventory (USER_ID, MATERIAL_NAME, QUANTITY, PRICE, SIZE, MODEL)
            VALUES (?, ?, ?, ?, ?, ?)
        ";

        $stmt = $this->connection()->prepare($query);

        if (!$stmt->execute([$userID, $materialName, $quantity, $price, $size, $model])) {
            return false;
        }

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

        return true;
    }

    // Update existing item in inventory
    protected function updateItemDB($materialName, $quantity, $price, $size, $model, $ID) {

        $query = "
            UPDATE inventory
            SET MATERIAL_NAME = ?, QUANTITY = ?, PRICE = ?, SIZE = ?, MODEL = ?
            WHERE MATERIAL_ID = ?
        ";

        $stmt = $this->connection()->prepare($query);

        if (!$stmt->execute([$materialName, $quantity, $price, $size, $model, $ID])) {
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

    // Delete existing item in inventory
    protected function deleteItemDB($ID) {

        $query = "
            DELETE FROM inventory
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
            DELETE FROM reservation
            WHERE RESERVATION_ID = ?
        ";

        $stmt = $this->connection()->prepare($query);

        if (!$stmt->execute([$ID])) {
            return false;
        }

        return true;
    }
}
