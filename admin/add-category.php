<?php
session_start();
include "../config/conn.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);

    // Validate input
    if (empty($name)) {
        $_SESSION['status'] = "Category name cannot be empty.";
        header("Location: add-category.php");
        exit();
    }

    // Insert into the database
    $sql = "INSERT INTO categories (name) VALUES (?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $name);

    if (mysqli_stmt_execute($stmt)) {
        $_SESSION['status'] = "Category added successfully!";
    } else {
        $_SESSION['status'] = "Error adding category: " . mysqli_error($conn);
    }

    header("Location: categoryblogtag.php");
    exit();
}
?>
