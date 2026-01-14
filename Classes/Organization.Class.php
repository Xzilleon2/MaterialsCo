<?php
include_once __DIR__ . "/Dbh.Class.php";

class Organization extends Dbh {

    // Get user by email (for checking duplicates)
    protected function getOrganizations() {
        $query = "SELECT * FROM organizations";

        $stmt = $this->connection()->prepare($query);

        if (!$stmt->execute()) {
            return 0;
        }

        return $stmt->fetchALL(PDO::FETCH_ASSOC);
    }

    // Insert new Organization
    protected function insertOrganization($id, $name, $address, $type) {

        $query = "INSERT INTO organizations (USER_ID, NAME, ADDRESS, TYPE) VALUES (?, ?, ?, ?)";
        $stmt = $this->connection()->prepare($query);

        if (!$stmt->execute(array($id, $name, $address, $type))) {
            return false;
        }

        return true;
    }
}
