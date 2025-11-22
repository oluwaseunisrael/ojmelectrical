<?php

session_start();
include "../config/conn.php";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the form values
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $image = mysqli_real_escape_string($conn, $_FILES['image']['name']);
    $content = mysqli_real_escape_string($conn, $_POST['content']);
    $post_category = mysqli_real_escape_string($conn, $_POST['post_category']);
    $tags =mysqli_real_escape_string($conn,$_POST['post_tags']); // Create a comma-separated list of tag IDs

    // File validation: Check if the file is an image and within the size limit
    $allowed_types = ['image/jpeg', 'image/png']; // Allowed MIME types for jpg and png
    $max_size = 2 * 1024 * 1024; // 2MB size limit

    // Get the file details
    $file_tmp = $_FILES['image']['tmp_name'];
    $file_type = $_FILES['image']['type'];
    $file_size = $_FILES['image']['size'];

    // Check if the uploaded file is a valid image type
    if (!in_array($file_type, $allowed_types)) {
        $_SESSION['status'] = "Invalid file type. Only JPG and PNG images are allowed.";
        header("Location: add_blog_form.php"); // Redirect back to the form
        exit();
    }

    // Check if the file size is within the limit
    if ($file_size > $max_size) {
        $_SESSION['status'] = "File size is too large. Maximum allowed size is 2MB.";
        header("Location: add_blog_form.php"); // Redirect back to the form
        exit();
    }

    // Move the uploaded image to the target directory
    $target_dir = "../uploads/";
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    if (!move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
        $_SESSION['status'] = "Error uploading the file.";
        header("Location: add_blog_form.php");
        exit();
    }

    // Insert the blog post into the blogposts table
    $insert_blog_query = "INSERT INTO blogposts (title, image, content, post_category, post_tags, created_at) 
                          VALUES ('$title', '$image', '$content', '$post_category', '$tags', NOW())";

    if (mysqli_query($conn, $insert_blog_query)) {
        $_SESSION['status'] = "Blog post added successfully!";
        header("Location: blogtable.php"); // Redirect to view the posts
    } else {
        $_SESSION['status'] = "Error adding blog post: " . mysqli_error($conn);
        header("Location: add_blog_form.php");
    }
}
?>
