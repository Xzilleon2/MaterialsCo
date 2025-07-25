<?php 
session_start();
include(__DIR__ . '/../../Inclusions/Connection.php');

if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['deleteBtn'])) {

    // Get the Reservation ID
    $reservationId = (int)$_POST['reservationId'];

    try {
        // Begin transaction
        $conn->begin_transaction();

        // Soft delete the reservation (set IS_ACTIVE = 0)
        $deleteReservation = 'UPDATE reservation SET IS_ACTIVE = 0 WHERE RESERVATION_ID = ?';
        $stmt = $conn->prepare($deleteReservation);
        if (!$stmt) throw new Exception("Prepare failed for Reservation: " . $conn->error);

        $stmt->bind_param('i', $reservationId);
        $stmt->execute();

        // Commit transaction
        $conn->commit();

        $_SESSION['ReservationMessageSuccess'] = 'Reservation record successfully deleted.';
        header('Location: ../../Reservation.php');
        exit();

    } catch (Exception $e) {
        $conn->rollback();
        die("❌ Error occurred: " . $e->getMessage());
    }

} else {
    echo "<script>
            alert('Error in Request');
            window.location.href = '../../Reservation.php';
          </script>";
}
