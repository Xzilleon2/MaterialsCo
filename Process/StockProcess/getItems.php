<?php 
    include(__DIR__ . '/../../Inclusions/Connection.php');

    // Query to join stocks_log with inventory to get material name
    $getStocksQuery = '
        SELECT s.*, i.MATERIAL_NAME 
        FROM stocks_log s
        JOIN inventory i ON s.MATERIAL_ID = i.MATERIAL_ID
        ORDER BY s.TIME_AND_DATE DESC
    '; 

    $stmt = $conn->prepare($getStocksQuery);
    $stmt->execute();
    $getStocks = $stmt->get_result();
?>
