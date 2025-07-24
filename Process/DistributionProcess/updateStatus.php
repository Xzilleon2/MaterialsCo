<?php 
session_start();
include(__DIR__ . '/../../Inclusions/Connection.php');

if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['action'])) {

    // Sanitize and Fetch Inputs
    $distributionId = (int)$_POST['distributionId'];
    $approvedBy = filter_var(trim($_POST['approvedBy']), FILTER_SANITIZE_SPECIAL_CHARS);
    $status = ($_POST['action'] === 'approve') ? 'Approved' : 'Denied';
    $dateReleased = date("Y-m-d");

    // Validate Required Fields
    if (empty($approvedBy)) {
        $_SESSION['DistributionMessage'] = 'Approver name is required.';
        header('Location: ../../Distribution.php');
        exit();
    }

    if (!isset($_SESSION['USER_ID'])) {
        die("Error: USER_ID not found in session.");
    }

    try {
        // Begin transaction
        $conn->begin_transaction();

        // Update Distribution Table
        $updateQuery = 'UPDATE distribution SET STATUS = ?, APPROVED_BY = ?, DATE_RELEASED = ? WHERE DISTRIBUTION_ID = ?';
        $stmt = $conn->prepare($updateQuery);
        if (!$stmt) throw new Exception("Prepare failed: " . $conn->error);

        $stmt->bind_param('sssi', $status, $approvedBy, $dateReleased, $distributionId);
        $stmt->execute();

        // Commit transaction
        $conn->commit();

        $_SESSION['DistributionMessageSuccess'] = "Distribution successfully $status.";
        header('Location: ../../Distribution.php');
        exit();

    } catch (Exception $e) {
        $conn->rollback();
        die("❌ Error occurred: " . $e->getMessage());
    }

} else {
    echo "<script>
            alert('Invalid request.');
            window.location.href = '../../Distribution.php';
          </script>";
}
?>
