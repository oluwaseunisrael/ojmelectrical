<?php
session_start();
include "config/conn.php";
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // PHPMailer autoloader

// Set timezone
date_default_timezone_set('America/New_York'); // Adjust to your timezone

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reset_password'])) {
    $token = mysqli_real_escape_string($conn, $_POST['token']);
    $new_password = mysqli_real_escape_string($conn, $_POST['password']);
    $password_hash = password_hash($new_password, PASSWORD_BCRYPT);

    // Validate token and expiry first
    $query = "SELECT * FROM customers WHERE reset_token='$token' AND token_expiry > NOW()";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        $current_password_hash = $user['password_hash'];

        // Validate password length and complexity
        if (strlen($new_password) < 8 || !preg_match("/[a-zA-Z]/", $new_password) || !preg_match("/\d/", $new_password)) {
            $_SESSION['message'] = "Password must be at least 8 characters long and contain both letters and numbers.";
            header("Location: reset_password.php?token=$token");
            exit;
        }

        // Check if the new password is the same as the old password
        if (password_verify($new_password, $current_password_hash)) {
            $_SESSION['message'] = "New password cannot be the same as the old password.";
            header("Location: reset_password.php?token=$token");
            exit;
        }

        // Update password
        $update_query = "UPDATE customers SET password_hash='$password_hash', reset_token=NULL, token_expiry=NULL WHERE reset_token='$token'";
        if (mysqli_query($conn, $update_query)) {
            $_SESSION['message'] = "Password reset successfully. You can now log in.";
            header("Location: login.php");
            exit;
        } else {
            $_SESSION['message'] = "Error updating password.";
            header("Location: reset_password.php?token=$token");
            exit;
        }
    } else {
        // Token invalid or expired
        $query = "SELECT email FROM customers WHERE reset_token='$token'";
        $result = mysqli_query($conn, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            $user = mysqli_fetch_assoc($result);
            $email = $user['email'];

            // Generate a new token and expiry time (1 minute from now)
            $new_token = bin2hex(random_bytes(50));
            $expiry = date('Y-m-d H:i:s', strtotime('+1 minute'));

            // Save the new token and expiry in the database
            $update_query = "UPDATE customers SET reset_token='$new_token', token_expiry='$expiry' WHERE email='$email'";
            if (mysqli_query($conn, $update_query)) {
                // Send email using PHPMailer
                $reset_link = "http://localhost/ojmelectrical/reset_password.php?token=$new_token";
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
                        <p>This link will expire in 1 minute.</p>
                        <p>Best regards,<br>OJM Electrical Company</p>
                    ";

                    $mail->send();
                    $_SESSION['message'] = "A new password reset link has been sent to your email.";
                } catch (Exception $e) {
                    $_SESSION['message'] = "Email could not be sent. Mailer Error: {$mail->ErrorInfo}";
                }
            } else {
                $_SESSION['message'] = "Error generating new reset link.";
            }
        } else {
            $_SESSION['message'] = "Expired reset link. Please request a new one.";
        }
        header("Location: forgot_password.php");
        exit;
    }
}

// Token validation for GET requests
if (!isset($_GET['token']) || empty($_GET['token'])) {
    $_SESSION['message'] = "Invalid reset link.";
    header("Location: forgot_password.php");
    exit;
}

$token = $_GET['token'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h2 class="text-center mb-4">Reset Password</h2>
            <?php if (isset($_SESSION['message'])): ?>
                <div class="alert alert-info text-center">
                    <?php 
                        echo $_SESSION['message'];
                        unset($_SESSION['message']);
                    ?>
                </div>
            <?php endif; ?>
            <form method="POST" action="" class="card p-4">
                <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">
                <div class="mb-3">
                    <label for="password" class="form-label">Enter new password</label>
                    <input type="password" id="password" name="password" class="form-control" required>
                </div>
                <button type="submit" name="reset_password" class="btn btn-primary w-100">Reset Password</button>
            </form>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
