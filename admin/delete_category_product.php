<?php
ob_start();
session_start(); // Start the session
include('includes/header.php'); // Include header

// Handle the deletion of the category
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Ensure the ID is numeric to prevent SQL injection
    if (is_numeric($id)) {
        $delete_query = "DELETE FROM product_category WHERE id = $id";
        
        if (mysqli_query($conn, $delete_query)) {
            $_SESSION['success_message'] = 'Category deleted successfully!';
        } else {
            $_SESSION['error_message'] = 'Error deleting category: ' . mysqli_error($conn);
        }
    } else {
        $_SESSION['error_message'] = 'Invalid category ID.';
    }
}

header("Location: view_categories.php");
exit();

ob_end_flush(); // End output buffering
?>
