<?php
ob_start();
session_start();
include "../config/conn.php";

// Check if ID is provided
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $customer_id = intval($_GET['id']);

    // Update the customer's status to active
    $query = "UPDATE customers SET status = 'active' WHERE id = $customer_id";
    if (mysqli_query($conn, $query)) {
        $_SESSION['success_message'] = 'Customer unbanned successfully.';
    } else {
        $_SESSION['error_message'] = 'Error unbanning customer: ' . mysqli_error($conn);
    }
} else {
    $_SESSION['error_message'] = 'Invalid customer ID.';
}

// Redirect to the customer table
header("Location: customer-table.php");
exit();

ob_end_flush();
?>
