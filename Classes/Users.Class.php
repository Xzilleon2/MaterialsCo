<?php
include_once __DIR__ . "/Dbh.Class.php";

class Users extends Dbh {

    // Get user by email (for checking duplicates)
    protected function getUsers($email) {
        $query = "SELECT * FROM user WHERE EMAIL = ?";
        $stmt = $this->connection()->prepare($query);

        if (!$stmt->execute(array($email))) {
            $stmt = null;
            header("Location: ../index.php?error=stmtFailed!");
            exit();
        }

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Insert new user
    protected function insertUser($name, $age, $email, $passwordHash) {

        $query = "INSERT INTO user (NAME, AGE, EMAIL, PASSWORD) VALUES (?, ?, ?, ?)";
        $stmt = $this->connection()->prepare($query);

        if (!$stmt->execute(array($name, $age, $email, $passwordHash))) {
            $stmt = null;
            header("Location: ../index.php?error=stmtFailed!");
            exit();
        }

        $stmt = null;
    }
}
