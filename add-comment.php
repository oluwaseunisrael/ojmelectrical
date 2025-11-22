<?php
include('config/conn.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $blog_id = $_POST['blog_id'];
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $content = mysqli_real_escape_string($conn, $_POST['content']);

    $query = "INSERT INTO comments (blog_id, name, email, content, created_at) VALUES ('$blog_id', '$name', '$email', '$content', NOW())";
    if (mysqli_query($conn, $query)) {
        header("Location: single-blog.php?id=$blog_id");
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>
