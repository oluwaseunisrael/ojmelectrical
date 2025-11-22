<?php
include "config/conn.php";

// Check if required fields are set
if (isset($_POST['name'], $_POST['email'], $_POST['message'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $subject = mysqli_real_escape_string($conn, $_POST['subject']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);

    // Insert into the database (optional)
    $query = "INSERT INTO contact_messages (name, email, phone, subject, message)
              VALUES ('$name', '$email', '$phone', '$subject', '$message')";

    if (mysqli_query($conn, $query)) {
        echo json_encode(["success" => true, "message" => "Your message has been sent successfully."]);
    } else {
        echo json_encode(["success" => false, "message" => "Failed to send the message. Please try again."]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Please fill in all required fields."]);
}

mysqli_close($conn);
?>
