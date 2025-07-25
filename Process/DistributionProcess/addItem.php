<?php 
session_start();
include(__DIR__ . '/../../Inclusions/Connection.php');

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['addBtn'])) {

    // Sanitize Inputs
    $userId = $_SESSION['USER_ID'];
    $materialId = (int)$_POST['materialId'];
    $quantity = (int)$_POST['quantity'];
    $location = trim($_POST['location']);
    $remarks = trim($_POST['remarks']);

    // Validate Inputs
    if (empty($quantity)) {
        $_SESSION['InventoryMessage'] = 'Please enter a valid Quantity.';
        header('Location: ../../Distribution.php');
        exit();
    }

    if (!isset($_SESSION['USER_ID'])) {
        die("Error: USER_ID not found in session.");
    }

    try {
        $conn->begin_transaction();

        // Insert into Distribution table
        $reservationId = isset($_POST['reservationId']) ? (int)$_POST['reservationId'] : null;

        $addDistribution = 'INSERT INTO distribution (MATERIAL_ID, USER_ID, QUANTITY, LOCATION, REMARKS, DATE_RELEASED, RESERVATION_ID) 
                            VALUES (?, ?, ?, ?, ?, NOW(), ?)';
        $stmt = $conn->prepare($addDistribution);
        $stmt->bind_param("iiissi", $materialId, $userId, $quantity, $location, $remarks, $reservationId);
        $stmt->execute();

        
        //Get the last inserted distribution ID
        $distributionId = $stmt->insert_id;

        // Insert into Stocks Log
        $logQuery = 'INSERT INTO STOCKS_LOG (MATERIAL_ID, DISTRIBUTION_ID, USER_ID, QUANTITY, TRANSACTION_TYPE, TIME_AND_DATE) VALUES (?, ?, ?, ?, ?, NOW())';
        $logStmt = $conn->prepare($logQuery);
        if (!$logStmt) throw new Exception("Prepare failed for STOCKS_LOG: " . $conn->error);
        
        $userId = $_SESSION['USER_ID'];
        $transactionType = 'OUT';
        $logStmt->bind_param('iiiis', $materialId, $distributionId, $userId, $quantity, $transactionType);
        $logStmt->execute();

        $conn->commit();

        $_SESSION['InventoryMessageSuccess'] = 'Distribution successfully recorded.';
        header('Location: ../../Distribution.php');
        exit();

    } catch (Exception $e) {
        $conn->rollback();
        die("❌ Error occurred: " . $e->getMessage());
    }

} else {
    echo "<script>
            alert('Error in Request');
            window.location.href = '../Distribution.php';
          </script>";
}
?>