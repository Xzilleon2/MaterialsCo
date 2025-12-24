<?php
include_once __DIR__ . '/Dbh.Class.php';

class Items extends Dbh {

    // Get all items from inventory table
    protected function getInventory() {
        $query = "SELECT * FROM inventory";
        $stmt = $this->connection()->prepare($query);

        if (!$stmt->execute()) {
            return false;
        }

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get all items from reservation table
    protected function getReservations() {
        $query = "SELECT * FROM reservations";
        $stmt = $this->connection()->prepare($query);

        if (!$stmt->execute()) {
            return false;
        }

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Insert new item to inventory
    protected function insertItem($materialName, $quantity, $price, $size, $model) {

        $query = "
            INSERT INTO inventory (MATERIAL_NAME, QUANTITY, PRICE, SIZE, MODEL)
            VALUES (?, ?, ?, ?, ?)
        ";

        $stmt = $this->connection()->prepare($query);

        if (!$stmt->execute([$materialName, $quantity, $price, $size, $model])) {
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
}
