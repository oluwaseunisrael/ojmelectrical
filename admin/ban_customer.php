<?php
ob_start();
session_start();
include "../config/conn.php";
// Check if ID is provided
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $customer_id = intval($_GET['id']);
    include('includes/db_connection.php'); // Include your database connection

    // Update the customer's status to banned
    $query = "UPDATE customers SET status = 'banned' WHERE id = $customer_id";
    if (mysqli_query($conn, $query)) {
        $_SESSION['success_message'] = 'Customer banned successfully.';
    } else {
        $_SESSION['error_message'] = 'Error banning customer: ' . mysqli_error($conn);
    }
} else {
    $_SESSION['error_message'] = 'Invalid customer ID.';
}

// Redirect to the customer table
header("Location: customer-table.php");
exit();

ob_end_flush();
?>
