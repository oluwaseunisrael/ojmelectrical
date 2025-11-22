<?php 
ob_start();
session_start(); // Start the session
include('includes/header.php');

// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $category_name = mysqli_real_escape_string($conn, $_POST['category_name']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);

    // Insert category into the database
    $query = "INSERT INTO product_category (category_name, description) VALUES ('$category_name', '$description')";

    // Handle success and error messages
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
    <h2 class="mb-4">Add Product Category</h2>

    <!-- Display Session Messages -->
    <?php if (isset($_SESSION['success_message'])): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?php 
                echo $_SESSION['success_message']; 
                unset($_SESSION['success_message']); // Clear the message
            ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['error_message'])): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?php 
                echo $_SESSION['error_message']; 
                unset($_SESSION['error_message']); // Clear the message
            ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <form method="POST" action="">
        <!-- Category Name Input -->
        <div class="mb-3">
            <label for="category_name" class="form-label">Category Name</label>
            <input type="text" class="form-control" id="category_name" name="category_name" required placeholder="Enter category name">
        </div>

        <!-- Description Input -->
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description" rows="3" placeholder="Enter category description"></textarea>
        </div>

        <!-- Submit Button -->
        <button type="submit" class="btn btn-primary">Add Category</button>
    </form>
</div>

</body>
</html>

<?php
include 'includes/footer.php';
?>
