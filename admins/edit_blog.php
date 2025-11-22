<?php
session_start();
include "../config/conn.php";
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the form values
    $post_id = $_POST['post_id']; // Get the blog post ID
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $content = mysqli_real_escape_string($conn, $_POST['content']);
    $post_category = mysqli_real_escape_string($conn, $_POST['post_category']);
    
    // Create a comma-separated list of tag IDs
    $tags = mysqli_real_escape_string($conn, implode(",", $_POST['post_tags']));
    
    // Initialize target file variable
    $target_file = '';

    // Check if a new image is uploaded
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
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
            header("Location: edit_blog_form.php?id=$post_id"); // Redirect back to the form
            exit();
        }

        // Check if the file size is within the limit
        if ($file_size > $max_size) {
            $_SESSION['status'] = "File size is too large. Maximum allowed size is 2MB.";
            header("Location: edit_blog_form.php?id=$post_id"); // Redirect back to the form
            exit();
        }

        // Move the uploaded image to the target directory
        $target_dir = "../uploads/";
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        
        // Attempt to move the uploaded file
        if (!move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            $_SESSION['status'] = "Error uploading the file.";
            header("Location: edit_blog_form.php?id=$post_id");
            exit();
        }
    } else {
        // Use the existing image if no new file is uploaded
        $target_file = $_POST['existing_image']; // Existing image is passed from the form
    }

    // Update the blog post in the database
    $update_blog_query = "UPDATE blogposts SET 
                          title = '$title',
                          image = '$target_file',
                          content = '$content',
                          post_category = '$post_category',
                          post_tags = '$tags'
                          WHERE id = '$post_id'";

    if (mysqli_query($conn, $update_blog_query)) {
        $_SESSION['status'] = "Blog post updated successfully!";
        header("Location: blogtable.php"); // Redirect to the blog table page
    } else {
        $_SESSION['status'] = "Error updating blog post: " . mysqli_error($conn);
        header("Location: edit_blog_form.php?id=$post_id"); // Redirect back to the form
    }
}
?>
