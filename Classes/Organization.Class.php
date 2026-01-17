<?php
include_once __DIR__ . "/Dbh.Class.php";

class Organization extends Dbh {

    // Get all Organizations
    protected function getOrganizations() {
        $query = "SELECT * FROM organizations";

        $stmt = $this->connection()->prepare($query);

        if (!$stmt->execute()) {
            return 0;
        }

        return $stmt->fetchALL(PDO::FETCH_ASSOC);
    }

    // Get user from members
    protected function getMembers() {
        $query = "

            SELECT
                m.MEMBER_ID,
                m.USER_ID,
                u.NAME,
                m.ORGANIZATION_ID,
                m.REMARKS,
                m.DATE_JOINED,
                m.IS_ACTIVE
                FROM members m
            JOIN user u
            ON m.USER_ID = u.USER_ID

                  ";

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

    // Insert new Member
    protected function insertMember($userId, $organizationId, $remarks) {

        $query = "INSERT INTO members (USER_ID, ORGANIZATION_ID, REMARKS) VALUES (?, ?, ?)";
        $stmt = $this->connection()->prepare($query);

        if (!$stmt->execute(array($userId, $organizationId, $remarks))) {
            return false;
        }

        return true;
    }

    // Leave Organization
    protected function updateMember($userId, $remarks) {

        $query = "UPDATE members SET REMARKS = ?, IS_ACTIVE = 0 WHERE USER_ID = ?";
        $stmt = $this->connection()->prepare($query);

        if (!$stmt->execute(array($remarks, $userId))) {
            return false;
        }

        return true;
    }

    // Update Member Status
    protected function updateStatus($memberId, $status) {

        $query = "UPDATE members SET IS_ACTIVE = ? WHERE MEMBER_ID = ?";
        $stmt = $this->connection()->prepare($query);

        if (!$stmt->execute(array($status, $memberId))) {
            return false;
        }

        return true;
    }
}
