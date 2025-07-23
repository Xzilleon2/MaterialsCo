<?php 
    session_start();
    include('../Inclusions/Connection.php');

    //Register Process
    if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['signUp'])){

        //Sanitize the inputs
        $NAME = filter_var(trim($_POST['signupName'] ?? ''), FILTER_SANITIZE_SPECIAL_CHARS);
        $Email = filter_var(trim($_POST['signupEmail']), FILTER_SANITIZE_EMAIL);
        $Age = filter_var(trim($_POST['signupAge']), FILTER_SANITIZE_NUMBER_INT);
        $Password = filter_var(trim($_POST['signupPassword']));
        $ConfirmPassword = filter_var(trim($_POST['confirmPassword']));

        // Input validation
        if (empty($NAME)) {
            $_SESSION['LogmessageReg'] = 'Please enter a valid name.';
            header('Location: ../index.php');
            exit();
        }

        if (!filter_var($Email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['LogmessageReg'] = 'Invalid email format.';
            header('Location: ../index.php');
            exit();
        }

        if (!filter_var($Age, FILTER_VALIDATE_INT) || $Age <= 0) {
            $_SESSION['LogmessageReg'] = 'Invalid age.';
            header('Location: ../index.php');
            exit();
        }

        if (empty($Password)) {
            $_SESSION['LogmessageReg'] = 'Password cannot be empty.';
            header('Location: ../index.php');
            exit();
        }

        if ($Password !== $ConfirmPassword) {
            $_SESSION['LogmessageReg'] = 'Passwords do not match.';
            header('Location: ../index.php');
            exit();
        }

        //Hash the password
        $hashedPassword = password_hash($Password, PASSWORD_DEFAULT);

        try{

            //starting transaction
            $conn->begin_transaction();

            //Signup Query
            $RegisterQuery = 'INSERT INTO user(NAME, AGE, EMAIL, PASSWORD) VALUES(?,?,?,?)';
            $stmt = $conn->prepare($RegisterQuery);

            //Binding the parameters for the query
            $stmt->bind_param('siss', $NAME,$Age, $Email, $hashedPassword);
            $stmt->execute();

            //If no error, insert the data
            $conn->commit();
            $_SESSION['LogmessageRegSuccess'] = 'Registration Successful';

            header('Location: ../index.php');
            exit();

        } catch (Exception $e) {
            $conn->rollback(); // Always rollback on failure    
            die("An error occurred while processing your request.");
          
        }

    }
?>