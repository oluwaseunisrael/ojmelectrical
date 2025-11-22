<?php
session_start(); // Start the session to access $_SESSION variables
include('include/header.php'); // Include the header file

// Check if the ID is set in the URL (from the "Edit" button)
if (isset($_GET['id'])) {
    $post_id = $_GET['id'];

    // Fetch the current blog post data from the database
    $sql = "SELECT * FROM blogposts WHERE id = '$post_id'";
    $result = mysqli_query($conn, $sql);
    $post = mysqli_fetch_assoc($result);

    // If the blog post does not exist
    if (!$post) {
        $_SESSION['status'] = "Blog post not found.";
        header("Location: blogtable.php"); // Redirect to blog table if not found
        exit();
    }
} else {
    // If ID is not passed, redirect to blog table
    $_SESSION['status'] = "No blog post ID specified.";
    header("Location: blogtable.php");
    exit();
}
?>

<div class="container mt-5">
    <?php if (isset($_SESSION['status'])): ?>
        <div class="alert alert-success">
            <?= $_SESSION['status']; unset($_SESSION['status']); ?>
        </div>
    <?php endif; ?>

    <h2>Edit Blog Post</h2>
    <form method="POST" action="edit_blog.php" enctype="multipart/form-data">
        <input type="hidden" name="post_id" value="<?= $post['id']; ?>">

        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control" id="title" name="title" value="<?= $post['title']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="image" class="form-label">Image</label>
            <input type="file" class="form-control" id="image" name="image">
            <img src="../uploads/<?= $post['image']; ?>" alt="Current Image" style="width: 100px;">
        </div>
        <div class="mb-3">
            <label for="content" class="form-label">Content</label>
            <textarea class="form-control" id="content" name="content" rows="5" required><?= $post['content']; ?></textarea>
        </div>
<div class="mb-3">
    <label for="post_category" class="form-label">Category</label>
    <select class="form-select" id="post_category" name="post_category" required>
        <option value="">Select a category</option>
        <?php
        // Fetch categories from the database
        $categories = $conn->query("SELECT * FROM categories");
        while ($category = $categories->fetch_assoc()) {
            // Check if the category is already selected
            $selected = ($category['id'] == $post['post_category']) ? 'selected' : '';
            echo "<option value='{$category['id']}' $selected>{$category['name']}</option>";
        }
        ?>
    </select>
</div>

<div class="mb-3">
    <label for="post_tags" class="form-label">Tags</label>
    <select class="form-select" id="post_tags" name="post_tags[]" multiple required>
        <option value="">Select tags</option>
        <?php
        // Fetch tags from the database
        $tags = $conn->query("SELECT * FROM tags");
        // Convert current post_tags into an array
        $selected_tags = explode(",", $post['post_tags']);
        while ($tag = $tags->fetch_assoc()) {
            // Check if the tag is already selected
            $selected = in_array($tag['id'], $selected_tags) ? 'selected' : '';
            echo "<option value='{$tag['id']}' $selected>{$tag['name']}</option>";
        }
        ?>
    </select>
</div>

        <button type="submit" class="btn btn-success">Update</button>
    </form>
</div>

<?php
include('include/footer.php');
?>
