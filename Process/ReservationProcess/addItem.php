<?php
session_start();
include(__DIR__ . '/../../Inclusions/Connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Get & sanitize input
        $materialId = (int) $_POST['material_id'];
        $userId = $_SESSION['USER_ID'] ?? null;
        $quantity = (int) $_POST['quantity'];
        $claimingDate = $_POST['claimDate'] ?? null;
        $purpose = trim($_POST['remarks'] ?? '');
        $requestor = trim($_POST['requestor'] ?? '');
        $reservationDate = date('Y-m-d');
        $status = 'PENDING';
        $isActive = 1;

        // Validate
        if (!$materialId || !$userId || !$quantity || !$claimingDate || !$requestor) {
            throw new Exception("Missing required fields.");
        }

        // Insert reservation
        $query = "INSERT INTO reservation 
            (MATERIAL_ID, USER_ID, QUANTITY, REQUESTOR, PURPOSE, RESERVATION_DATE, CLAIMING_DATE, STATUS, IS_ACTIVE)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($query);
        $stmt->bind_param("iiisssssi", 
            $materialId, $userId, $quantity, $requestor, $purpose, $reservationDate, $claimingDate, $status, $isActive
        );
        $stmt->execute();

        $_SESSION['InventoryMessageSuccess'] = 'Reservation successfully added.';
        header('Location: ../../Reservation.php');
        exit();

    } catch (Exception $e) {
        $_SESSION['InventoryMessage'] = "❌ Failed to add reservation: " . $e->getMessage();
        header('Location: ../../Reservation.php');
        exit();
    }
} else {
    echo "Invalid request.";
}
