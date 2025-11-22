z<?php 
session_start(); // Start the session to access $_SESSION variables
include('include/header.php');
ini_set('display_errors', 1);
error_reporting(E_ALL);

?>

<div class="container ">
    <?php if (isset($_SESSION['status'])): ?>
        <div class="alert alert-success">
            <?= $_SESSION['status']; unset($_SESSION['status']); ?>
        </div>
    <?php endif; ?>

    <h2>All Blog Posts</h2>
    <a href="add_blog_form.php" class="btn btn-success mb-3">Add New Blog</a>
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
                        <td><img src='../uploads/{$row['image']}' alt='Image' style='width: 100px;'></td>
                        <td>{$row['category_name']}</td>
                        <td>{$tag_names_str}</td>
                        <td>{$row['created_at']}</td>
                        <td>
                            <a href='edit_blog_form.php?id={$row['id']}' class='btn btn-warning btn-sm'>Edit</a>
                            <a href='delete_blog.php?id={$row['id']}' class='btn btn-danger btn-sm'>Delete</a>
                        </td>
                    </tr>";
            }
        } else {
            echo "<tr><td colspan='7'>No blog posts found.</td></tr>";
        }
        ?>
        </tbody>
    </table>
</div>
</div>
<?php
include('include/footer.php');
?>
</body>
</html>
