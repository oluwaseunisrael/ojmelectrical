<?php
include "config/conn.php";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize the input to prevent SQL injection
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $service_id = mysqli_real_escape_string($conn, $_POST['service']);
    $details = mysqli_real_escape_string($conn, $_POST['details']);

    // Insert into the 'estimates' table
    $sql = "INSERT INTO estimates (name, email, phone, address, service_id, details) 
            VALUES ('$name', '$email', '$phone', '$address', '$service_id', '$details')";

    // Check if the insertion was successful
    if (mysqli_query($conn, $sql)) {
        echo "Your estimate request has been successfully submitted!";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
    
    // Close the database connection
    mysqli_close($conn);
}
?>
