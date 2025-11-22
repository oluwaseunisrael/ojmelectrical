<?php  
session_start(); // Start the session to access $_SESSION variables
include('includes/header.php'); 
ini_set('display_errors', 1);
error_reporting(E_ALL);
?>

<style>
    body {
        font-family: 'Arial', sans-serif;
        background-color: #f8f9fa;
        color: #333;
    }

    .container {
        margin-top: 30px;
    }

    .alert-success {
        background-color: #e2f0ff;
        border-color: #b3d7ff;
        color: #1e3d58;
        font-weight: bold;
        padding: 10px;
        margin-bottom: 20px;
        border-radius: 5px;
    }

    h2 {
        color: #007bff;
        text-align: center;
        margin-bottom: 20px;
        font-size: 2rem;
    }

    .btn-success {
        background-color: #007bff;
        border-color: #007bff;
        color: white;
    }

    .btn-success:hover {
        background-color: #0056b3;
        border-color: #004085;
    }

    .btn-warning {
        background-color: #ffc107;
        border-color: #ffc107;
        color: black;
    }

    .btn-warning:hover {
        background-color: #e0a800;
        border-color: #d39e00;
    }

    .btn-danger {
        background-color: #dc3545;
        border-color: #dc3545;
        color: white;
    }

    .btn-danger:hover {
        background-color: #c82333;
        border-color: #bd2130;
    }

    .btn-sm {
        padding: 6px 12px;
        font-size: 14px;
    }

    table {
        width: 100%;
        margin-top: 20px;
        border: 1px solid #ddd;
        border-collapse: collapse;
        border-radius: 8px;
        overflow: hidden;
    }

    th, td {
        padding: 15px;
        text-align: left;
    }

    th {
        background-color: #007bff;
        color: white;
        font-weight: bold;
    }

    td {
        background-color: #f8f9fa;
    }

    td img {
        width: 100px;
        height: auto;
    }

    .table-bordered {
        border: 1px solid #ddd;
    }

    .table-bordered th,
    .table-bordered td {
        border: 1px solid #ddd;
    }

    .table-bordered td {
        background-color: #f1f1f1;
    }

    .table-bordered tbody tr:hover {
        background-color: #e9ecef;
    }

    .table-container {
        max-width: 100%;
        overflow-x: auto;
    }

    .table-actions a {
        margin-right: 10px;
    }

</style>

<div class="container">
    <?php if (isset($_SESSION['status'])): ?>
        <div class="alert alert-success">
            <?= $_SESSION['status']; unset($_SESSION['status']); ?>
        </div>
    <?php endif; ?>

    <h2>All Blog Posts</h2>
    <a href="add_blog_form.php" class="btn btn-success mb-3">Add New Blog</a>

    <div class="table-container">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Image</th>
                    <th>Category</th>
                    <th>Tags</th>
                    <th>Created At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // SQL to get blogposts with category name
                $sql = "SELECT blogposts.*, categories.name AS category_name 
                        FROM blogposts 
                        JOIN categories ON blogposts.post_category = categories.id";
                $result = mysqli_query($conn, $sql);

                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        // Get the comma-separated list of tag IDs from post_tags
                        $tags = $row['post_tags'];
                        $tag_names = [];

                        // Split the tag IDs into an array
                        $tag_ids = explode(',', $tags);
                        
                        // For each tag ID, fetch the tag name
                        foreach ($tag_ids as $tag_id) {
                            $tag_query = "SELECT name FROM tags WHERE id = $tag_id";
                            $tag_result = mysqli_query($conn, $tag_query);
                            if ($tag_result && mysqli_num_rows($tag_result) > 0) {
                                $tag_row = mysqli_fetch_assoc($tag_result);
                                $tag_names[] = $tag_row['name'];  // Add tag name to array
                            }
                        }
                        
                        // Convert the tag names array to a comma-separated string
                        $tag_names_str = implode(', ', $tag_names);

                        echo "<tr>
                                <td>{$row['id']}</td>
                                <td>{$row['title']}</td>
                                <td><img src='../uploads/{$row['image']}' alt='Image'></td>
                                <td>{$row['category_name']}</td>
                                <td>{$tag_names_str}</td>
                                <td>{$row['created_at']}</td>
                                <td class='table-actions'>
                                    <a href='edit_blog_form.php?id={$row['id']}' class='btn btn-warning btn-sm'>Edit</a>
                                    <a href='delete_blog.php?id={$row['id']}' class='btn btn-danger btn-sm'>Delete</a>
                                </td>
                            </tr>";
                    }
                } else {
                    echo "<tr><td colspan='7' class='text-center'>No blog posts found.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<?php
include('includes/footer.php');
?>

