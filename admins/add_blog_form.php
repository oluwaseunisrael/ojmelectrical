<?php 
session_start(); // Start the session to access $_SESSION variables

include('include/header.php'); // Include the header file
?>

<div class="container">
    <h2>Add Blog Post</h2>
    <form method="POST" action="blogcode.php" enctype="multipart/form-data">
        <!-- Title Input -->
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control" id="title" name="title" required>
        </div>

        <!-- Image Upload -->
        <div class="mb-3">
            <label for="image" class="form-label">Image</label>
            <input type="file" class="form-control" id="image" name="image" required>
        </div>

        <!-- Content Input -->
        <div class="mb-3">
            <label for="content" class="form-label">Content</label>
            <textarea class="form-control" id="content" name="content" rows="5" required></textarea>
        </div>

        <!-- Categories Dropdown -->
          <div class="mb-3">
        <label for="post_category" class="form-label">Category</label>
        <select class="form-select" id="post_category" name="post_category" required>
            <option value="">Select a category</option>
            <?php
            $category_query = "SELECT * FROM categories";
            $categories_result = mysqli_query($conn, $category_query);
            
            if (mysqli_num_rows($categories_result) > 0) {
                while ($category = mysqli_fetch_assoc($categories_result)) {
                    echo "<option value='{$category['id']}'>{$category['name']}</option>";
                }
            } else {
                echo "<option value=''>No categories found</option>";
            }
            ?>
        </select>
    </div>

    <!-- Tags Dropdown -->
    <div class="mb-3">
        <label for="post_tags" class="form-label">Tags</label>
        <select class="form-select" id="post_tags" name="post_tags" required>
            <option value="">Select a tag</option>
            <?php
            $tags_query = "SELECT * FROM tags";
            $tags_result = mysqli_query($conn, $tags_query);

            if (mysqli_num_rows($tags_result) > 0) {
                while ($tag = mysqli_fetch_assoc($tags_result)) {
                    echo "<option value='{$tag['id']}'>{$tag['name']}</option>";
                }
            } else {
                echo "<option value=''>No tags available</option>";
            }
            ?>
        </select>
    </div>

        <!-- Submit Button -->
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>

<?php
include('include/footer.php');
?>
</body>
</html>
