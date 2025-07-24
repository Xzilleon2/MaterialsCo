<?php 
session_start();
include(__DIR__ . '/../../Inclusions/Connection.php');

// Enable MySQLi error reporting
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['addBtn'])) {

    // Sanitize Inputs
    $Name = filter_var(trim($_POST['materialName']), FILTER_SANITIZE_SPECIAL_CHARS);
    $Quantity = $_POST['materialQuantity'];
    $Price = $_POST['materialPrice'];
    $SizeWeight = filter_var(trim($_POST['materialSizeWeight']), FILTER_SANITIZE_SPECIAL_CHARS);
    $Model = filter_var(trim($_POST['materialModel']), FILTER_SANITIZE_SPECIAL_CHARS);

    // Validate Inputs
    if (empty($Name)) {
        $_SESSION['InventoryMessage'] = 'Please enter a valid material name.';
        header('Location: ../../Inventory.php');
        exit();
    }

    if (empty($Quantity)) {
        $_SESSION['InventoryMessage'] = 'Please enter a valid Quantity.';
        header('Location: ../../Inventory.php');
        exit();
    }

    if (empty($Price)) {
        $_SESSION['InventoryMessage'] = 'Please enter a valid price.';
        header('Location: ../../Inventory.php');
        exit();
    }

    if (empty($SizeWeight)) {
        $_SESSION['InventoryMessage'] = 'Please enter a valid size/weight.';
        header('Location: ../../Inventory.php');
        exit();
    }

    if (!isset($_SESSION['USER_ID'])) {
        die("Error: USER_ID not found in session.");
    }

    try {
        // Begin transaction
        $conn->begin_transaction();

        // Insert into Inventory
        $addMaterial = 'INSERT INTO Inventory (MATERIAL_NAME, QUANTITY, PRICE, SIZE, MODEL, DATE_ADDED) VALUES (?, ?, ?, ?, ?, NOW())';
        $stmt = $conn->prepare($addMaterial);
        if (!$stmt) throw new Exception("Prepare failed for Inventory: " . $conn->error);

        $stmt->bind_param('siiss', $Name, $Quantity, $Price, $SizeWeight, $Model);
        $stmt->execute();

        $lastMaterialID = $conn->insert_id;

        // Insert into STOCKS_LOG
        $logQuery = 'INSERT INTO STOCKS_LOG (MATERIAL_ID, USER_ID, QUANTITY, TRANSACTION_TYPE, TIME_AND_DATE) VALUES (?, ?, ?, ?, NOW())';
        $logStmt = $conn->prepare($logQuery);
        if (!$logStmt) throw new Exception("Prepare failed for STOCKS_LOG: " . $conn->error);

        $logUserID = $_SESSION['USER_ID'];
        $transactionType = 'IN';
        $logStmt->bind_param('iiis', $lastMaterialID, $logUserID, $Quantity, $transactionType);
        $logStmt->execute();

        // Commit transaction
        $conn->commit();

        $_SESSION['InventoryMessageSuccess'] = 'Product successfully added.';
        header('Location: ../../Inventory.php');
        exit();

    } catch (Exception $e) {
        $conn->rollback();
        die("❌ Error occurred: " . $e->getMessage());
    }

} else {
    echo "<script>
            alert('Error in Request');
            window.location.href = '../Inventory.php';
          </script>";
}
?>
