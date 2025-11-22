<?php
include_once __DIR__ . "/Dbh.Class.php";

class Distributions extends Dbh {

    // Insert
    protected function addDistributionModel($materialId, $userId, $quantity, $location, $remarks, $reservationId) {

        $query = "INSERT INTO distribution 
                  (MATERIAL_ID, USER_ID, QUANTITY, LOCATION, REMARKS, DATE_RELEASED, RESERVATION_ID)
                  VALUES (?, ?, ?, ?, ?, NOW(), ?)";

        $stmt = $this->connection()->prepare($query);

        if (!$stmt->execute([$materialId, $userId, $quantity, $location, $remarks, $reservationId])) {
            $stmt = null;
            header("Location: ../Distributions.php?error=stmtFailed!");
            exit();
        }

        $stmt = null;
    }

    // Delete
    protected function deleteDistributionModel($distributionId) {

        $query = "UPDATE distribution SET IS_ACTIVE = 0 WHERE DISTRIBUTION_ID = ?";
        $stmt = $this->connection()->prepare($query);

        if (!$stmt->execute([$distributionId])) {
            $stmt = null;
            header("Location: ../Distributions.php?error=stmtFailed!");
            exit();
        }

        $stmt = null;
    }


    // Update
    protected function updateStatusModel($status, $approvedBy, $location, $date, $distributionId) {

        $query = "UPDATE distribution 
                  SET STATUS = ?, APPROVED_BY = ?, LOCATION = ?, DATE_RELEASED = ?
                  WHERE DISTRIBUTION_ID = ?";

        $stmt = $this->connection()->prepare($query);

        if (!$stmt->execute([$status, $approvedBy, $location, $date, $distributionId])) {
            $stmt = null;
            header("Location: ../Distributions.php?error=stmtFailed!");
            exit();
        }

        $stmt = null;
    }


    // Select
    protected function getAllDistributionsModel() {

        $query = "SELECT d.*, i.MATERIAL_NAME
                  FROM distribution d
                  JOIN inventory i ON d.MATERIAL_ID = i.MATERIAL_ID
                  WHERE d.IS_ACTIVE = 1
                  ORDER BY d.DISTRIBUTION_ID DESC";

        $stmt = $this->connection()->prepare($query);

        if (!$stmt->execute()) {
            $stmt = null;
            throw new Exception("Failed to fetch distributions.");
        }

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
