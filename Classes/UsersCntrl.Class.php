<?php
include_once __DIR__ . "/Users.Class.php";

class UsersCntrl extends Users {

    // Attributes
    private $name;
    private $email;
    private $age;
    private $password;
    private $passwordRep;

    // Constructor
    public function __construct($name = "", $email = "", $age = "", $password = "", $passwordRep = "") {
        $this->name = $name;
        $this->email = $email;
        $this->age = $age;
        $this->password = $password;
        $this->passwordRep = $passwordRep;
    }

    // Login
    public function loginUser() {

        // Invalid Email
        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['Logmessage'] = "Invalid email format.";
            header("Location: ../index.php");
            exit();
        }

        // Empty password
        if (empty($this->password)) {
            $_SESSION['Logmessage'] = "Password cannot be empty.";
            header("Location: ../index.php");
            exit();
        }

        // Look up user
        $user = $this->getUsers($this->email);

        if (!$user) {
            $_SESSION['Logmessage'] = "Email not found.";
            header("Location: ../index.php");
            exit();
        }

        // Wrong password
        if (!password_verify($this->password, $user['PASSWORD'])) {
            $_SESSION['Logmessage'] = "Incorrect password.";
            header("Location: ../index.php");
            exit();
        }

        // SUCCESS
        session_regenerate_id();

        $_SESSION['USER_ID'] = $user['USER_ID'];
        $_SESSION['NAME'] = $user['NAME'];
        $_SESSION['EMAIL'] = $user['EMAIL'];

        header("Location: ../Homepage.php");
        exit();
    }

    // Register
    public function registerUser() {

        if (empty($this->name)) {
            $_SESSION['LogmessageReg'] = "Please enter a valid name.";
            header("Location: ../index.php");
            exit();
        }

        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['LogmessageReg'] = "Invalid email format.";
            header("Location: ../index.php");
            exit();
        }

        if (!filter_var($this->age, FILTER_VALIDATE_INT) || $this->age <= 0) {
            $_SESSION['LogmessageReg'] = "Invalid age.";
            header("Location: ../index.php");
            exit();
        }

        if (empty($this->password)) {
            $_SESSION['LogmessageReg'] = "Password cannot be empty.";
            header("Location: ../index.php");
            exit();
        }

        if ($this->password !== $this->passwordRep) {
            $_SESSION['LogmessageReg'] = "Passwords do not match.";
            header("Location: ../index.php");
            exit();
        }

        if ($this->getUsers($this->email)) {
            $_SESSION['LogmessageReg'] = "Email already exists.";
            header("Location: ../index.php");
            exit();
        }

        $hash = password_hash($this->password, PASSWORD_DEFAULT);

        $this->insertUser($this->name, $this->age, $this->email, $hash);

        $_SESSION['LogmessageRegSuccess'] = "Registration Successful!";
        header("Location: ../index.php");
        exit();
    }
}
