<?php
session_start();
require 'vendor/autoload.php'; // Load PHPMailer
include "config/conn.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['register'])) {
    // Sanitize input values
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $confirm_password = mysqli_real_escape_string($conn, $_POST['confirmPassword']);

    // Validate password strength
    $password_pattern = '/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/';
    if (!preg_match($password_pattern, $password)) {
        $_SESSION['message'] = "Password must be at least 8 characters long and include a mixture of letters and numbers.";
        header("Location: login.php");
        exit;
    }

    // Check if password and confirm password match
    if ($password !== $confirm_password) {
        $_SESSION['message'] = "Passwords do not match!";
        header("Location: login.php");
        exit;
    }

    // Check if email already exists
    $sql_check = "SELECT * FROM customers WHERE email='$email'";
    $result_check = mysqli_query($conn, $sql_check);

    if (mysqli_num_rows($result_check) > 0) {
        $_SESSION['message'] = "Email already registered!";
        header("Location: login.php");
        exit;
    }

    // Generate a verification token
    $token = bin2hex(random_bytes(50));
    $expiry = date("Y-m-d H:i:s", strtotime("+1 minutes"));

    // Hash the password
    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    // Insert new customer into the database with token and inactive status
    $sql_insert = "INSERT INTO customers (name, email, password_hash, verification_token, token_expiry, status) 
                   VALUES ('$name', '$email', '$password_hash', '$token', '$expiry', 'inactive')";
    
    if (mysqli_query($conn, $sql_insert)) {
        // Send verification email
        $verification_link = "http://localhost/ojmelectrical/verify_email.php?token=$token";
        $business_email = "ojmelectrical@gmail.com";

        try {
            $mail = new PHPMailer(true);

            // SMTP configuration
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'ojmelectrical@gmail.com';
            $mail->Password = 'tkng pech bbqr pcdu'; // Replace with your email password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port = 465;

            // Email configuration
            $mail->setFrom($business_email, 'OJM Electrical Company');
            $mail->addAddress($email);
            $mail->isHTML(true);
            $mail->Subject = 'Verify Your Email';
            $mail->Body = "
                <p>Dear $name,</p>
                <p>Thank you for registering. Please click the link below to verify your email:</p>
                <a href='$verification_link'>Verify Email</a>
                <p>This link will expire in 15 minutes.</p>
                <p>Best regards,<br>OJM Electrical Company</p>
            ";

            $mail->send();
            $_SESSION['message'] = "Registration successful! Please verify your email.";
            header("Location: login.php");
        } catch (Exception $e) {
            $_SESSION['message'] = "Error: Email could not be sent. Mailer Error: {$mail->ErrorInfo}";
            header("Location: login.php");
        }
    } else {
        $_SESSION['message'] = "Error: " . mysqli_error($conn);
        header("Location: login.php");
    }
}
?>
