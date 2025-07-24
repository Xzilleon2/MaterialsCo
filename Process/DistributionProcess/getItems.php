<?php 
    include(__DIR__ . '/../../Inclusions/Connection.php');

    // Query to join distribution with inventory and get material name
    $getDistributionQuery = '
        SELECT d.*, i.MATERIAL_NAME 
        FROM distribution d
        JOIN inventory i ON d.MATERIAL_ID = i.MATERIAL_ID
        WHERE d.IS_ACTIVE = 1
    '; 

    $stmt = $conn->prepare($getDistributionQuery);
    $stmt->execute();
    $getDistribution = $stmt->get_result();
?>
