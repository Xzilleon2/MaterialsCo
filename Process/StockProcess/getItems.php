<?php 
    include(__DIR__ . '/../../Inclusions/Connection.php');

    // Query to join stocks_log with inventory and distribution, and compute total price
    $getStocksQuery = '
        SELECT 
            s.*, 
            i.MATERIAL_NAME, 
            i.PRICE,
            d.REMARKS,
            (s.QUANTITY * i.PRICE) AS TOTAL_PRICE
        FROM 
            stocks_log s
        JOIN 
            inventory i ON s.MATERIAL_ID = i.MATERIAL_ID
        LEFT JOIN 
            distribution d ON s.DISTRIBUTION_ID = d.DISTRIBUTION_ID
        ORDER BY 
            s.TIME_AND_DATE DESC
    '; 

    $stmt = $conn->prepare($getStocksQuery);
    $stmt->execute();
    $getStocks = $stmt->get_result();
?>
