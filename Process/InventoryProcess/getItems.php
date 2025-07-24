<?php 
    session_start();
    include(__DIR__ . '/../../Inclusions/Connection.php');

    // Query
    $getMaterialsQuery = 'SELECT * FROM inventory'; 
    $stmt = $conn->prepare($getMaterialsQuery);
    $stmt->execute();
    $getMaterials = $stmt->get_result();
?>
