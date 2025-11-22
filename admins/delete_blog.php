<?php
session_start();
include "../config/conn.php";

// Check if 'id' is set in the URL (this is the ID of the post to delete)
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $post_id = $_GET['id'];

    // First, retrieve the post to get the image path (so we can delete it if needed)
    $select_post_query = "SELECT image FROM blogposts WHERE id = '$post_id'";
    $result = mysqli_query($conn, $select_post_query);

    if ($result && mysqli_num_rows($result) > 0) {
        $post = mysqli_fetch_assoc($result);
        $image_path = $post['image'];

        // If the image exists and is a valid file, delete it from the server
        if (!empty($image_path) && file_exists($image_path)) {
            unlink($image_path); // Deletes the image file
        }

        // Now delete the blog post from the database
        $delete_query = "DELETE FROM blogposts WHERE id = '$post_id'";

        if (mysqli_query($conn, $delete_query)) {
            $_SESSION['status'] = "Blog post deleted successfully!";
        } else {
            $_SESSION['status'] = "Error deleting blog post: " . mysqli_error($conn);
        }
    } else {
        $_SESSION['status'] = "Post not found.";
    }

    // Redirect back to the blog table page or wherever you want
    header("Location: blogtable.php");
    exit();
} else {
    $_SESSION['status'] = "Invalid post ID.";
    header("Location: blogtable.php");
    exit();
}
?>
