<?php 
session_start();
include('../Inclusions/Connection.php');


// Login Verification
if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['signIn'])) {

    // Sanitize inputs
    $Email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $Password = trim($_POST['password']);

    // Validate email format
    if (!filter_var($Email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['Logmessage'] = 'Invalid email format.';

        exit();
    }

    // Validate password not empty
    if (empty($Password)) {
        $_SESSION['Logmessage'] = 'Password cannot be empty.';

       header('Location: ../index.php');
       exit();
    }

    // Prepare the query
    $LoginQuery = 'SELECT * FROM user WHERE EMAIL = ?';
    $stmt = $conn->prepare($LoginQuery);

    if ($stmt === false) {
        die("Database Error: " . $conn->error);
    }

    try {
        $stmt->bind_param('s', $Email);
        $stmt->execute();
        $userTableResult = $stmt->get_result();

        if ($userTableResult->num_rows > 0) {
            $row = $userTableResult->fetch_assoc();

            // Verify password
            if (password_verify($Password, $row['PASSWORD'])) {

                // Secure session ID
                session_regenerate_id();

                // Save user data to session
                $_SESSION['USER_ID'] = $row['USER_ID'];
                $_SESSION['NAME'] = $row['NAME'];
                $_SESSION['EMAIL'] = $row['EMAIL'];

                header('Location: ../Homepage.php');
                exit();

            } else {
                // Password is incorrect but email exists
                $_SESSION['Logmessage'] = 'Incorrect password for this email.';

                header('Location: ../index.php');
               exit();
            }

        } else {
            // Email does not exist
            $_SESSION['Logmessage'] = 'This email is not registered.';

            header('Location: ../index.php');
            exit();
        }

    } catch (Exception $e) {
        die("An error occurred while processing your request.");
    }
} else {
        // Email does not exist
        $_SESSION['Logmessage'] = 'Please enter you email and password.';

        header('Location: ../index.php');
        exit();
}
?>
