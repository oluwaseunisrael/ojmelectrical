<?php 
ob_start();
session_start(); // Start the session
include('include/header.php');


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $category_name = mysqli_real_escape_string($conn, $_POST['category_name']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);

    $query = "INSERT INTO product_category (category_name, description) VALUES ('$category_name', '$description')";

    if (mysqli_query($conn, $query)) {
        $_SESSION['success_message'] = 'Category added successfully!';
    } else {
        $_SESSION['error_message'] = 'Error adding category: ' . mysqli_error($conn);
    }

    // Redirect to avoid form resubmission
    header("Location: add_category.php");
    exit();
}
ob_end_flush(); // End output buffering
?>
<div class="container mt-5">
    <h2>Add Product Category</h2>

    <!-- Display Session Messages -->
    <?php if (isset($_SESSION['success_message'])): ?>
        <div class="alert alert-success">
            <?php 
                echo $_SESSION['success_message']; 
                unset($_SESSION['success_message']); // Clear the message
            ?>
        </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['error_message'])): ?>
        <div class="alert alert-danger">
            <?php 
                echo $_SESSION['error_message']; 
                unset($_SESSION['error_message']); // Clear the message
            ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="">
        <div class="mb-3">
            <label for="category_name" class="form-label">Category Name</label>
            <input type="text" class="form-control" id="category_name" name="category_name" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description" rows="3"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Add Category</button>
    </form>
</div>
</body>
</html>
