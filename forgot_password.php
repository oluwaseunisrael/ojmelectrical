<?php
session_start();
require 'vendor/autoload.php'; // Load PHPMailer
include "config/conn.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['forgot_password'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);

    // Check if the email exists
    $query = "SELECT * FROM customers WHERE email='$email'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        $token = bin2hex(random_bytes(50)); // Generate a secure token
        $expiry = date("Y-m-d H:i:s", strtotime("+1 minutes"));


        // Save the token and expiry in the database
        $update_query = "UPDATE customers SET reset_token='$token', token_expiry='$expiry' WHERE email='$email'";
        if (mysqli_query($conn, $update_query)) {
            // Send email using PHPMailer
            $reset_link = "http://localhost/ojmelectrical/reset_password.php?token=$token";  // Update for local URL
            $business_email = "ojmelectrical@gmail.com"; // Replace with your email

            try {
                $mail = new PHPMailer(true);

                // SMTP configuration
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'ojmelectrical@gmail.com'; // Replace with your email
                $mail->Password = 'tkng pech bbqr pcdu'; // Replace with your email password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                $mail->Port = 465;

                // Email configuration
                $mail->setFrom($business_email, 'OJM Electrical Company');
                $mail->addAddress($email); // Customer email
                $mail->isHTML(true);
                $mail->Subject = 'Password Reset Request';
                $mail->Body = "
                    <p>Dear User,</p>
                    <p>You requested a password reset. Please click the link below to reset your password:</p>
                    <a href='$reset_link'>Reset Password</a>
                    <p>This link will expire in 1 minutes.</p>
                    <p>Best regards,<br>OJM Electrical Company</p>
                ";

                $mail->send();
                $_SESSION['message'] = "Password reset link has been sent to your email.";
            } catch (Exception $e) {
                $_SESSION['message'] = "Email could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
        } else {
            $_SESSION['message'] = "Error generating reset link.";
        }
    } else {
        $_SESSION['message'] = "Email not found.";
    }

    header("Location: forgot_password.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h2 class="text-center mb-4">Forgot Password</h2>
            <?php if (isset($_SESSION['message'])): ?>
                <div class="alert alert-info text-center">
                    <?php 
                        echo $_SESSION['message'];
                        unset($_SESSION['message']);
                    ?>
                </div>
            <?php endif; ?>
            <form method="POST" action="" class="card p-4">
                <div class="mb-3">
                    <label for="email" class="form-label">Enter your email address</label>
                    <input type="email" id="email" name="email" class="form-control" required>
                </div>
                <button type="submit" name="forgot_password" class="btn btn-primary w-100">Submit</button>
            </form>
        </div>
    </div>
</div>
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

