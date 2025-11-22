<?php
session_start();

// Includes
include __DIR__ . "/../Classes/UsersCntrl.Class.php";

// Check request
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['signIn'])) {

    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $password = trim($_POST['password']);

    // Controller
    $login = new UsersCntrl("",$email,"",$password,"");

    // Run login logic
    $login->loginUser();

} else {
    header("Location: ../index.php?error=invalidAccess");
    exit();
}