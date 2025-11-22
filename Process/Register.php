<?php
session_start();

include __DIR__ . "/../Classes/UsersCntrl.Class.php";

if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['signUp'])) {

    // Sanitize input
    $name = filter_var(trim($_POST['signupName']), FILTER_SANITIZE_SPECIAL_CHARS);
    $email = filter_var(trim($_POST['signupEmail']), FILTER_SANITIZE_EMAIL);
    $age = filter_var(trim($_POST['signupAge']), FILTER_SANITIZE_NUMBER_INT);
    $password = trim($_POST['signupPassword']);
    $passwordRep = trim($_POST['confirmPassword']);

    // Controller
    $signup = new UsersCntrl($name, $email, $age, $password, $passwordRep);

    // Execute registration
    $signup->registerUser();

} else {
    header("Location: ../index.php?error=invalidAccess");
    exit();
}