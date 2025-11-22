<?php
session_start();
include "../config/conn.php"; // Include your database connection

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // Input validation
    if (empty($email) || empty($password)) {
        $_SESSION['status'] = "Please fill in all fields.";
        header("Location: login.php"); // Redirect back to login page
        exit();
    }

    // Check if user exists with the provided email
    $sql = "SELECT * FROM admins WHERE email = ?";
    $stmt = mysqli_prepare($conn, $sql);
    
    if (!$stmt) {
        die("Prepare failed: " . mysqli_error($conn)); // Debugging
    }

    mysqli_stmt_bind_param($stmt, "s", $email);
    if (!mysqli_stmt_execute($stmt)) {
        die("Execute failed: " . mysqli_error($conn)); // Debugging
    }

    $result = mysqli_stmt_get_result($stmt);

    if ($result && mysqli_num_rows($result) > 0) {
        // User exists, fetch the user details
        $user = mysqli_fetch_assoc($result);

        // Check if the user is banned
        if ($user['is_banned'] == 1) {
            $_SESSION['status'] = "You are banned. Please contact the admin.";
            header("Location: login.php");
            exit();
        }

        // Verify password
        if (password_verify($password, $user['password_hash'])) {
            // Password is correct, create session and redirect to the dashboard or home page
            $_SESSION['admin_id'] = $user['id'];
            $_SESSION['admin_name'] = $user['name'];
            $_SESSION['admin_email'] = $user['email'];

            // Redirect to the dashboard or any authorized page
            header("Location:index.php");
            exit();
        } else {
            $_SESSION['status'] = "Incorrect email or password.";
            header("Location: login.php");
            exit();
        }
    } else {
        $_SESSION['status'] = "No user found with this email address.";
        header("Location: login.php");
        exit();
    }
}
?>
