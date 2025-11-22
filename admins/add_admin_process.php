<?php
session_start(); // Start the session to access $_SESSION variables

include "../config/conn.php";

// Retrieve input values
$name = trim($_POST['name']);
$email = trim($_POST['email']);
$password = $_POST['password'];
$confirm_password = $_POST['confirm_password']; // Retrieve the confirm password value
$image = $_FILES['image']['name'];

// Input validation: Check if name or email is empty
if (empty($name)) {
    $_SESSION['status'] = "Name cannot be empty.";
    header("Location: add-admin.php");
    exit();
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['status'] = "Invalid email format.";
    header("Location: add-admin.php");
    exit();
}

// Confirm password validation: Check if passwords match
if ($password !== $confirm_password) {
    $_SESSION['status'] = "Passwords do not match.";
    header("Location: add-admin.php");
    exit();
}

// Hash the password before storing
$password_hash = password_hash($password, PASSWORD_BCRYPT);

// Handle file upload
$target_dir = "../uploads/";
$target_file = $target_dir . basename($image);
$file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
$file_size = $_FILES['image']['size'];

// File validation: Check file type and size
$allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
$max_file_size = 2 * 1024 * 1024; // 2MB

if (!empty($image)) {
    if (!in_array($file_type, $allowed_types)) {
        $_SESSION['status'] = "Invalid file type. Only JPG, JPEG, PNG, and GIF files are allowed.";
        header("Location: add-admin.php");
        exit();
    }

    if ($file_size > $max_file_size) {
        $_SESSION['status'] = "File size exceeds 2MB limit.";
        header("Location: add-admin.php");
        exit();
    }

    if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
        $image_path = $target_file;
    } else {
        $_SESSION['status'] = "Failed to upload image. Please try again.";
        header("Location: add-admin.php");
        exit();
    }
} else {
    $image_path = null; // If no image is uploaded
}

// Check if the email already exists in the database
$sql = "SELECT * FROM admins WHERE email = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "s", $email);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) > 0) {
    $_SESSION['status'] = "This email is already registered.";
    header("Location: add-admin.php");
    exit();
}

// Insert into database
$sql = "INSERT INTO admins (name, email, password_hash, image) VALUES (?, ?, ?, ?)";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "ssss", $name, $email, $password_hash, $image_path);

if (mysqli_stmt_execute($stmt)) {
    $_SESSION['status'] = "Admin added successfully!";
} else {
    $_SESSION['status'] = "Error: " . mysqli_error($conn);
}

header("Location: admin-table.php");
exit();
?>
