<?php
session_start(); // Start the session to access $_SESSION variables

include "../config/conn.php";

// Check if an admin ID is provided
if (isset($_GET['id'])) {
    $id = $_GET['id']; // Get the ID of the admin to delete

    // Prepare the SQL query to delete the admin by ID
    $sql = "DELETE FROM admins WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);

    // Execute the query and check if it was successful
    if (mysqli_stmt_execute($stmt)) {
        $_SESSION['status'] = "Admin deleted successfully!";
    } else {
        $_SESSION['status'] = "Error: " . mysqli_error($conn);
    }

    // Redirect back to the admin table page
    header("Location: admin-table.php");
    exit();
} else {
    $_SESSION['status'] = "No admin ID provided.";
    header("Location: admin-table.php");
    exit();
}
