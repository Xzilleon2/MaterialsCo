<?php 
    session_start();
    include(__DIR__ . '/../../Inclusions/Connection.php');

    if($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['updateBtn'])){

        // Sanitize Inputs
        $ID = $_POST['materialId'];
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
            $updateMaterial = 'UPDATE inventory SET MATERIAL_NAME = ?, QUANTITY = ?, PRICE = ?, SIZE = ?, MODEL = ? WHERE MATERIAL_ID = ?';
            $stmt = $conn->prepare($updateMaterial);
            if (!$stmt) throw new Exception("Prepare failed for Inventory: " . $conn->error);

            $stmt->bind_param('siissi', $Name, $Quantity, $Price, $SizeWeight, $Model, $ID);
            $stmt->execute();

            // Commit transaction
            $conn->commit();

            $_SESSION['InventoryMessageSuccess'] = 'Product successfully Updated.';
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
