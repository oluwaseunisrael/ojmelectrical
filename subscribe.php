<?php
include "config/conn.php";
// Validate the email input
if (isset($_POST['email'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(["success" => false, "message" => "Invalid email address."]);
        exit;
    }

    // Insert into the database
    $query = "INSERT INTO newsletter_subscriptions (email) VALUES ('$email')";

    if (mysqli_query($conn, $query)) {
        echo json_encode(["success" => true, "message" => "Thanks Subscription successful."]);
    } else {
        if (mysqli_errno($conn) == 1062) { // Duplicate entry error code
            echo json_encode(["success" => false, "message" => "This email is already subscribed."]);
        } else {
            echo json_encode(["success" => false, "message" => "Failed to subscribe. Please try again."]);
        }
    }
} else {
    echo json_encode(["success" => false, "message" => "Email is required."]);
}

// Close connection
mysqli_close($conn);
?>
