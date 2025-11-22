<?php
session_start();
include "../config/conn.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id']); // Retrieve category ID
    $name = trim($_POST['name']); // Retrieve category name

    // Validate input
    if (empty($name)) {
        $_SESSION['status'] = "Category name cannot be empty.";
        header("Location: edit-category.php?id=" . $id);
        exit();
    }

    // Update the database
    $sql = "UPDATE categories SET name = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "si", $name, $id);

    if (mysqli_stmt_execute($stmt)) {
        $_SESSION['status'] = "Category updated successfully!";
    } else {
        $_SESSION['status'] = "Error updating category: " . mysqli_error($conn);
    }

    header("Location: categoryblogtag.php");
    exit();
}
?>
