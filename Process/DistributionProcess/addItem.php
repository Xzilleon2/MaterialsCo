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
        $addDistribution = 'INSERT INTO distribution (MATERIAL_ID, USER_ID, QUANTITY, LOCATION, REMARKS, DATE_RELEASED) VALUES (?, ?, ?, ?, ?, NOW())';
        $stmt = $conn->prepare($addDistribution);
        if (!$stmt) throw new Exception("Prepare failed for Distribution: " . $conn->error);
        $stmt->bind_param("iiiss", $materialId, $userId, $quantity, $location, $remarks);
        $stmt->execute();

        // Insert into Stocks Log
        $logQuery = 'INSERT INTO STOCKS_LOG (MATERIAL_ID, USER_ID, QUANTITY, TRANSACTION_TYPE, TIME_AND_DATE) VALUES (?, ?, ?, ?, NOW())';
        $logStmt = $conn->prepare($logQuery);
        if (!$logStmt) throw new Exception("Prepare failed for STOCKS_LOG: " . $conn->error);
        
        $userId = $_SESSION['USER_ID'];
        $transactionType = 'OUT';
        $logStmt->bind_param('iiis', $materialId, $userId, $quantity, $transactionType);
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