<?php
session_start();
include("config/conn.php"); 

if (isset($_SESSION['user_id']) && isset($_POST['service_id'])) {
    $service_id = $_POST['service_id'];
    $customer_email = $_SESSION['user_email'];

    $query = "SELECT * FROM service_request WHERE id = ? AND email = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "is", $service_id, $customer_email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
        $service = mysqli_fetch_assoc($result);

        $service_image = $service['service_image'];
        if (file_exists($service_image)) {
            unlink($service_image);
        }

        $delete_query = "DELETE FROM service_request WHERE id = ? AND email = ?";
        $delete_stmt = mysqli_prepare($conn, $delete_query);
        mysqli_stmt_bind_param($delete_stmt, "is", $service_id, $customer_email);
        if (mysqli_stmt_execute($delete_stmt)) {
            $_SESSION['status'] = "Service request deleted successfully.";
        } else {
            $_SESSION['status'] = "Error deleting service request.";
        }
        mysqli_stmt_close($delete_stmt);
    } else {
        $_SESSION['status'] = "Unauthorized action or service request not found.";
    }

    mysqli_stmt_close($stmt);
} else {
    $_SESSION['status'] = "Invalid request.";
}

header("Location: service-order.php");
exit;
?>
