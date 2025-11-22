<?php
session_start(); // Start the session to access $_SESSION variables

include "../config/conn.php";

// Retrieve input values
$id = $_POST['id']; // The admin's ID to edit
$name = trim($_POST['name']);
$email = trim($_POST['email']);
$password = $_POST['password'];
$confirm_password = $_POST['confirm_password']; // Retrieve the confirm password value
$image = $_FILES['image']['name'];

// Input validation: Check if name or email is empty
if (empty($name)) {
    $_SESSION['status'] = "Name cannot be empty.";
    header("Location: edit-admin.php?id=$id");
    exit();
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['status'] = "Invalid email format.";
    header("Location: edit-admin.php?id=$id");
    exit();
}

// Confirm password validation: Check if passwords match
if ($password !== $confirm_password) {
    $_SESSION['status'] = "Passwords do not match.";
    header("Location: edit-admin.php?id=$id");
    exit();
}

// Hash the password before storing, only if the password is provided (for edit scenario)
if (!empty($password)) {
    $password_hash = password_hash($password, PASSWORD_BCRYPT);
} else {
    $password_hash = null; // If no password provided, retain the current password
}

// Handle file upload (optional image update)
$target_dir = "../uploads/";
$target_file = $target_dir . basename($image);
$file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
$file_size = $_FILES['image']['size'];

// File validation: Check file type and size (only if a new image is uploaded)
$allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
$max_file_size = 2 * 1024 * 1024; // 2MB

if (!empty($image)) {
    if (!in_array($file_type, $allowed_types)) {
        $_SESSION['status'] = "Invalid file type. Only JPG, JPEG, PNG, and GIF files are allowed.";
        header("Location: edit-admin.php?id=$id");
        exit();
    }

    if ($file_size > $max_file_size) {
        $_SESSION['status'] = "File size exceeds 2MB limit.";
        header("Location: edit-admin.php?id=$id");
        exit();
    }

    if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
        $image_path = $target_file;
    } else {
        $_SESSION['status'] = "Failed to upload image. Please try again.";
        header("Location: edit-admin.php?id=$id");
        exit();
    }
} else {
    $image_path = null; // If no image uploaded, retain the existing image
}

// Check if the email is already registered by someone else (for update scenario)
$sql = "SELECT * FROM admins WHERE email = ? AND id != ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "si", $email, $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) > 0) {
    $_SESSION['status'] = "This email is already registered.";
    header("Location: edit-admin.php?id=$id");
    exit();
}

// If no password provided, retain the existing password from the database
if (empty($password)) {
    $sql = "UPDATE admins SET name = ?, email = ?, image = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "sssi", $name, $email, $image_path, $id);
} else {
    // Update password, name, email, and image
    $sql = "UPDATE admins SET name = ?, email = ?, password_hash = ?, image = ? WHERE id = ?";
    mysqli_stmt_bind_param($stmt, "ssssi", $name, $email, $password_hash, $image_path, $id);
}

// Execute the update
if (mysqli_stmt_execute($stmt)) {
    $_SESSION['status'] = "Admin updated successfully!";
} else {
    $_SESSION['status'] = "Error: " . mysqli_error($conn);
}

header("Location: admin-table.php");
exit();
?>
