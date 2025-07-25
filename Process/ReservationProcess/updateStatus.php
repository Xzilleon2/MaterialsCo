<?php 
session_start();
include(__DIR__ . '/../../Inclusions/Connection.php');

if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['action'])) {

    $reservationId = (int)$_POST['reservationId'];
    $status = ($_POST['action'] === 'approve') ? 'Approved' : 'Denied';

    if (!isset($_SESSION['USER_ID'])) {
        die("❌ Error: USER_ID not found in session.");
    }

    try {
        $conn->begin_transaction();

        // Update reservation table
        $updateQuery = 'UPDATE reservation SET STATUS = ?, IS_ACTIVE = 0 WHERE RESERVATION_ID = ?';
        $stmt = $conn->prepare($updateQuery);
        if (!$stmt) throw new Exception("Prepare failed: " . $conn->error);
        $stmt->bind_param('si', $status, $reservationId);
        $stmt->execute();

        if ($status === 'Approved') {
            // Fetch reservation data
            $fetchQuery = 'SELECT MATERIAL_ID, USER_ID, QUANTITY, PURPOSE FROM reservation WHERE RESERVATION_ID = ?';
            $fetchStmt = $conn->prepare($fetchQuery);
            if (!$fetchStmt) throw new Exception("Prepare failed: " . $conn->error);
            $fetchStmt->bind_param('i', $reservationId);
            $fetchStmt->execute();
            $result = $fetchStmt->get_result();

            if ($result->num_rows === 0) throw new Exception("Reservation not found.");
            $reservation = $result->fetch_assoc();

            $materialId = $reservation['MATERIAL_ID'];
            $userId = $reservation['USER_ID'];
            $quantity = $reservation['QUANTITY'];
            $remarks = $reservation['PURPOSE'];
            $transactionType = 'OUT';

            // Insert into distribution (removed APPROVED_BY)
            $insertDist = $conn->prepare('
                INSERT INTO distribution (MATERIAL_ID, USER_ID, QUANTITY, LOCATION, REMARKS, DATE_RELEASED, STATUS, IS_ACTIVE, RESERVATION_ID) 
                VALUES (?, ?, ?, ?, ?, NOW(), "Approved", 1, ?)
            ');
            if (!$insertDist) throw new Exception("Prepare failed for distribution: " . $conn->error);
            $insertDist->bind_param('iiissi', $materialId, $userId, $quantity, $location, $remarks, $reservationId);
            $insertDist->execute();
            $distributionId = $insertDist->insert_id;

            // Insert into stocks_log
            $logQuery = '
                INSERT INTO stocks_log (MATERIAL_ID, DISTRIBUTION_ID, USER_ID, QUANTITY, TRANSACTION_TYPE, TIME_AND_DATE) 
                VALUES (?, ?, ?, ?, ?, NOW())
            ';
            $logStmt = $conn->prepare($logQuery);
            if (!$logStmt) throw new Exception("Prepare failed for stocks_log: " . $conn->error);
            $logStmt->bind_param('iiiis', $materialId, $distributionId, $userId, $quantity, $transactionType);
            $logStmt->execute();
        }

        $conn->commit();

        $_SESSION['ReservationMessageSuccess'] = "Reservation successfully $status.";
        header('Location: ../../Reservation.php');
        exit();

    } catch (Exception $e) {
        $conn->rollback();
        die("❌ Error occurred: " . $e->getMessage());
    }

} else {
    echo "<script>
            alert('Invalid request.');
            window.location.href = '../../Reservation.php';
          </script>";
}
?>
