<?php
session_start();
include "config/conn.php"; 

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Check if email exists in the database
    $sql_check = "SELECT * FROM customers WHERE email='$email'";
    $result_check = mysqli_query($conn, $sql_check);

    if ($result_check && mysqli_num_rows($result_check) > 0) {
        $user = mysqli_fetch_assoc($result_check);

        // Check if the user is banned
        if ($user['status'] === 'banned') {
            $_SESSION['message'] = "Your account has been banned. Please contact support.";
            header("Location: login.php");
            exit;
        }

        // Verify the password
        if (password_verify($password, $user['password_hash'])) {
            // Set session variables
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['isLoggedIn'] = true;

            $_SESSION['message'] = "Login successful!";
            header("Location: dashboard.php");
            exit;
        } else {
            $_SESSION['message'] = "Incorrect password!";
            header("Location: login.php");
            exit;
        }
    } else {
        $_SESSION['message'] = "Email not registered!";
        header("Location: login.php");
        exit;
    }
}
?>
