<?php 

    $servername = 'localhost';
    $username = 'root';
    $password = '';
    $dbname = 'materialcodb';

    $conn = new mysqli($servername,$username,$password,$dbname);

    if($conn -> connect_error){
        die("Connection to DB Failed! " . $conn->connect_error);
    }

?>