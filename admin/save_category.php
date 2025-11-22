<?php
session_start();
include "../config/conn.php";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $category_id = $_POST['id']; // Category ID if updating
    $category_name = mysqli_real_escape_string($conn, $_POST['name']);
    
    // If there's an ID, it's an update, otherwise it's an insert
    if ($category_id) {
        // Update the category
        $query = "UPDATE service_categories SET name = '$category_name' WHERE id = '$category_id'";
    } else {
        // Insert a new category
        $query = "INSERT INTO service_categories (name) VALUES ('$category_name')";
    }
    
    if (mysqli_query($conn, $query)) {
        $_SESSION['status'] = "Category " . ($category_id ? "updated" : "added") . " successfully!";
        header("Location: service-category-table.php"); // Redirect to the list page
    } else {
        $_SESSION['status'] = "Error: " . mysqli_error($conn);
        header("Location: add_category_form.php"); // Redirect back to the form
    }
}
?>
