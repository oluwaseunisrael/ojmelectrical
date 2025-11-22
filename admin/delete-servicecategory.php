<?php
session_start();
include "../config/conn.php";

// Check if category ID is provided
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $category_id = $_GET['id'];
    
    // Delete the category
    $query = "DELETE FROM service_categories WHERE id = '$category_id'";
    
    if (mysqli_query($conn, $query)) {
        $_SESSION['status'] = "Category deleted successfully!";
    } else {
        $_SESSION['status'] = "Error deleting category: " . mysqli_error($conn);
    }
    
    // Redirect to the service categories list
    header("Location: service-category-table.php");
    exit();
} else {
    $_SESSION['status'] = "Invalid category ID.";
    header("Location: Location: service-category-table.php");
    exit();
}
?>
