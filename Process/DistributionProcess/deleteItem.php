<?php 
session_start();
include(__DIR__ . '/../../Inclusions/Connection.php');

if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['deleteBtn'])) {

    // Get the Distribution ID
    $distributionId = (int)$_POST['distributionId'];

    try {
        // Begin transaction
        $conn->begin_transaction();

        // Soft delete the distribution (set IS_ACTIVE = 0)
        $deleteDistribution = 'UPDATE distribution SET IS_ACTIVE = 0 WHERE DISTRIBUTION_ID = ?';
        $stmt = $conn->prepare($deleteDistribution);
        if (!$stmt) throw new Exception("Prepare failed for Distribution: " . $conn->error);

        $stmt->bind_param('i', $distributionId);
        $stmt->execute();

        // Commit transaction
        $conn->commit();

        $_SESSION['DistributionMessageSuccess'] = 'Distribution record successfully deleted.';
        header('Location: ../../Distribution.php');
        exit();

    } catch (Exception $e) {
        $conn->rollback();
        die("❌ Error occurred: " . $e->getMessage());
    }

} else {
    echo "<script>
            alert('Error in Request');
            window.location.href = '../../Distribution.php';
          </script>";
}
?>
