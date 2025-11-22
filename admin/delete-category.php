<?php
session_start();
include "../config/conn.php";

if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Get the category ID from URL

    // Delete the category from the database
    $sql = "DELETE FROM categories WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);

    if (mysqli_stmt_execute($stmt)) {
        $_SESSION['status'] = "Category deleted successfully!";
    } else {
        $_SESSION['status'] = "Error deleting category: " . mysqli_error($conn);
    }
}

header("Location: categoryblogtag.php"); // Redirect back to the categories page
exit();
?>
