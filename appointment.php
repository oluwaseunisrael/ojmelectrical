<?php
header('Content-Type: application/json'); // Ensure JSON response


include "config/conn.php";

// Check if required data is set
if (isset($_POST['name'], $_POST['email'], $_POST['address'], $_POST['visitDate'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $service = mysqli_real_escape_string($conn, $_POST['service']);
    $visitDate = mysqli_real_escape_string($conn, $_POST['visitDate']);
    $comment = mysqli_real_escape_string($conn, $_POST['comment']);

    // Insert into the database
    $query = "INSERT INTO appointments (name, email, phone, address, service, visit_date, comment)
              VALUES ('$name', '$email', '$phone', '$address', '$service', '$visitDate', '$comment')";

    if (mysqli_query($conn, $query)) {
        echo json_encode(["success" => true, "message" => "Appointment successfully submitted."]);
    } else {
        echo json_encode(["success" => false, "message" => "Failed to submit appointment."]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Missing required fields."]);
}

mysqli_close($conn);
?>
