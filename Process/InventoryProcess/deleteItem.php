<?php 
    session_start();
    include(__DIR__ . '/../../Inclusions/Connection.php');

    if($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['deleteBtn'])){

        // Get the Material ID
        $ID = $_POST['materialId'];
        
        try {

            // Begin transaction
            $conn->begin_transaction();

            // Insert into Inventory
            $deleteMaterial = 'UPDATE inventory SET IS_ACTIVE = 0 WHERE MATERIAL_ID = ?';
            $stmt = $conn->prepare($deleteMaterial);
            if (!$stmt) throw new Exception("Prepare failed for Inventory: " . $conn->error);

            $stmt->bind_param('i',  $ID);
            $stmt->execute();

            // Commit transaction
            $conn->commit();

            $_SESSION['InventoryMessageSuccess'] = 'Product successfully Deleted.';
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
