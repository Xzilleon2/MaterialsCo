<?php 
    include(__DIR__ . '/../../Inclusions/Connection.php');

    // Join reservation with inventory (for MATERIAL_NAME and SIZE)
    // and distribution (for REMARKS) using MATERIAL_ID
    $getReservationQuery = '
        SELECT 
            r.*, 
            i.MATERIAL_NAME, 
            i.SIZE, 
            d.REMARKS 
        FROM reservation r
        JOIN inventory i ON r.MATERIAL_ID = i.MATERIAL_ID
        LEFT JOIN distribution d 
            ON r.MATERIAL_ID = d.MATERIAL_ID AND r.RESERVATION_ID = d.RESERVATION_ID
        WHERE r.IS_ACTIVE = 1
    '; 

    $stmt = $conn->prepare($getReservationQuery);
    $stmt->execute();
    $getReservation = $stmt->get_result();
?>
