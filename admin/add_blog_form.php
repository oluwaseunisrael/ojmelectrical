<?php 
session_start(); // Start the session to access $_SESSION variables

include('includes/header.php'); // Include the header file
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

    h2 {
        color: #007bff;
        text-align: center;
        margin-bottom: 20px;
    }

    .form-label {
        font-weight: bold;
    }

    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
    }

    .btn-primary:hover {
        background-color: #0056b3;
        border-color: #004085;
    }

    .form-select, .form-control {
        margin-top: 5px;
    }

    .mb-3 {
        margin-bottom: 1.5rem;
    }

    .alert-success {
        background-color: #cce5ff;
        border-color: #b8daff;
        color: #004085;
        font-weight: bold;
        text-align: center;
        margin-top: 20px;
    }

    .form-control-file {
        padding: 10px;
    }
</style>

<div class="container">
    <h2>Add New Blog Post</h2>
    
    <!-- Display session message if exists -->
    <?php if (isset($_SESSION['status'])): ?>
        <div class="alert alert-success">
            <?= $_SESSION['status']; unset($_SESSION['status']); ?>
        </div>
    <?php endif; ?>

    <!-- Blog Post Form -->
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
                    echo "<option value=''>No categories available</option>";
                }
                ?>
            </select>
        </div>

        <!-- Tags Dropdown -->
        <div class="mb-3">
            <label for="post_tags" class="form-label">Tags</label>
            <select class="form-select" id="post_tags" name="post_tags[]" multiple required>
                <option value="">Select tags</option>
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
        <div class="d-flex justify-content-center">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>
</div>

<?php
include('includes/footer.php');
?>

