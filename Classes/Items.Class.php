<?php
include_once __DIR__ . '/Dbh.Class.php';

class Items extends Dbh{

    // Get All items from inventory table
    protected function getInventory() {
        $query = "SELECT * FROM inventory";
        $stmt = $this->connection()->prepare($query);

        if (!$stmt->execute(array())) {
            $stmt = null;
            header("Location: ../index.php?error=stmtFailed!");
            exit();
        }

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get All items from reservation table
    protected function getReservations() {
        $query = "SELECT * FROM reservations";
        $stmt = $this->connection()->prepare($query);

        if (!$stmt->execute(array())) {
            $stmt = null;
            header("Location: ../index.php?error=stmtFailed!");
            exit();
        }

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Insert new item to inventory
    protected function insertItem($materialName, $quantity, $price, $size, $model) {

        $query = "INSERT INTO inventory (MATERIAL_NAME, QUANTITY, PRICE, SIZE, MODEL) 
                VALUES (?, ?, ?, ?, ?)";
        
        $stmt = $this->connection()->prepare($query);

        if (!$stmt->execute([$materialName, $quantity, $price, $size, $model])) {
            $stmt = null;
            header("Location: ../index.php?error=stmtFailed");
            exit();
        }

        header("Location: ../../Inventory.php?error=none");
        exit();

        $stmt = null;
    }


}