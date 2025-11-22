<?php
include_once __DIR__ . '/Dbh.Class.php';

class Items extends Dbh{

    // Get user by email (for checking duplicates)
    protected function getItems() {
        $query = "SELECT * FROM inventory";
        $stmt = $this->connection()->prepare($query);

        if (!$stmt->execute(array())) {
            $stmt = null;
            header("Location: ../index.php?error=stmtFailed!");
            exit();
        }

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Insert new user
    protected function insertItems() {

        $query = "INSERT INTO inventory (NAME, AGE, EMAIL, PASSWORD) VALUES (?, ?, ?, ?)";
        $stmt = $this->connection()->prepare($query);

        if (!$stmt->execute(array())) {
            $stmt = null;
            header("Location: ../index.php?error=stmtFailed!");
            exit();
        }

        $stmt = null;
    }

}