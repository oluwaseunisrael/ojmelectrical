<?php
session_start();
include "config/conn.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

// Ensure the user is logged in
if (!isset($_SESSION['isLoggedIn']) || !$_SESSION['isLoggedIn']) {
    header("Location: login.php");
    exit;
}

// Form data
$service_id = $_POST['service'];  // This is the service ID from the form
$country = $_POST['country'];
$state_id = $_POST['state'];
$city_id = $_POST['city'];
$address = $_POST['address'];
$fullname = $_POST['fullname'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$job_start_date = $_POST['job-start'];
$service_desc = $_POST['service-desc'];
$readiness_to_hire = $_POST['readiness_to_hire'] ?? NULL;
$customer_email = $_SESSION['user_email'];

// File upload
$image = NULL;
$image_name = NULL;  // For storing the image name to be used in the email
if (isset($_FILES['service_image']) && $_FILES['service_image']['error'] == 0) {
    $allowed_file_types = ['image/jpeg', 'image/png', 'application/pdf'];
    $file_type = $_FILES['service_image']['type'];
    $file_size = $_FILES['service_image']['size'];
    
    if (in_array($file_type, $allowed_file_types) && $file_size <= 5 * 1024 * 1024) {
        $image_name = "uploads/" . basename($_FILES['service_image']['name']);
        if (!move_uploaded_file($_FILES['service_image']['tmp_name'], $image_name)) {
            $_SESSION['status'] = "Error uploading the image.";
            header("Location: booknow.php");
            exit;
        }
        $image = $image_name;  // Store image path to insert in DB
    } else {
        $_SESSION['status'] = "Invalid file type or file too large.";
        header("Location: booknow.php");
        exit;
    }
}

// Fetch the service name based on the selected service ID
$query = "SELECT title FROM services WHERE id = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i", $service_id);  // Assuming service_id is an integer
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $service_name);
mysqli_stmt_fetch($stmt);
mysqli_stmt_close($stmt);

// If no service name is found, redirect with an error
if (!$service_name) {
    $_SESSION['status'] = "Error: Service not found.";
    header("Location: booknow.php");
    exit;
}

// Insert service request into the database
$sql = "INSERT INTO service_request (country, state, city, address, service, fullname, email, phone, job_start_date, service_description, readiness_to_hire, service_image) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "ssssssssssss", $country, $state_id, $city_id, $address, $service_name, $fullname, $email, $phone, $job_start_date, $service_desc, $readiness_to_hire, $image);

if (mysqli_stmt_execute($stmt)) {
    // Send confirmation email
    $business_email = "ojmelectrical@gmail.com"; // Replace with your business email

    try {
        $mail = new PHPMailer(true);
        
        // SMTP configuration
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // Update with your SMTP server
        $mail->SMTPAuth = true;
        $mail->Username = 'ojmelectrical@gmail.com'; // Update with your SMTP username
        $mail->Password = 'tkng pech bbqr pcdu'; // Update with your SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port = 465;

        // Email to the customer
        $mail->setFrom($business_email, 'OJM Electrical Company'); 
        $mail->addAddress($customer_email, $fullname); 
        $mail->isHTML(true);
        $mail->Subject = 'Service Request Confirmation from OJM Electrical Company';
        
        // If an image is uploaded, attach it as an inline image
        if ($image) {
            $mail->AddEmbeddedImage($image, 'service_image', basename($image));
        }
        
        $mail->Body = "
            <p>Dear $fullname,</p>
            <p>Thank you for requesting our services. We have received your service request and will get back to you shortly. Below are the details of your request:</p>
            <ul>
                <li><strong>Service:</strong> $service_name</li>
                <li><strong>Address:</strong> $address</li>
                <li><strong>Start Date:</strong> $job_start_date</li>
                <li><strong>Phone:</strong> $phone</li>
                <li><strong>Description:</strong> $service_desc</li>
            </ul>
            <p>We appreciate your business!</p>
            <p>Best regards,<br>Your Business Team</p>
            <p><img src='cid:service_image' alt='Service Image' /></p>
        ";

        $mail->send();

        // Email to the business
        $mail->clearAddresses(); // Clear the previous recipient
        $mail->addAddress($business_email, 'OJM Electrical Company');
        $mail->Subject = 'New Service Request Received';
        $mail->Body = "
            <p>Hello,</p>
            <p>A new service request has been submitted. Here are the details:</p>
            <ul>
                <li><strong>Customer Name:</strong> $fullname</li>
                <li><strong>Email:</strong> $customer_email</li>
                <li><strong>Phone:</strong> $phone</li>
                <li><strong>Service:</strong> $service_name</li>
                <li><strong>Address:</strong> $address</li>
                <li><strong>Start Date:</strong> $job_start_date</li>
                <li><strong>Description:</strong> $service_desc</li>
            </ul>
            <p>Regards,<br>Your System</p>
        ";

        $mail->send();
        $_SESSION['status'] = "Service request submitted successfully and confirmation emails sent!";
    } catch (Exception $e) {
        $_SESSION['status'] = "Service request submitted, but email could not be sent. Error: {$mail->ErrorInfo}";
    }

    header("Location: dashboard.php");
    exit;
} else {
    $_SESSION['status'] = "Error: " . mysqli_error($conn);
    header("Location: service_request_form.php");
    exit;
}

mysqli_stmt_close($stmt);
?>
