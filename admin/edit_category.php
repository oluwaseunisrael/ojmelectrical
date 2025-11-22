<?php
ob_start();
session_start(); // Start the session
include('includes/header.php'); // Include header

// Fetch the category details based on the ID
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT * FROM product_category WHERE id = $id";
    $result = mysqli_query($conn, $query);
    
    if (mysqli_num_rows($result) == 1) {
        $category = mysqli_fetch_assoc($result);
    } else {
        $_SESSION['error_message'] = 'Category not found.';
        header("Location: view_categories.php");
        exit();
    }
}

// Handle the form submission for updating the category
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $category_name = mysqli_real_escape_string($conn, $_POST['category_name']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    
    $update_query = "UPDATE product_category SET category_name = '$category_name', description = '$description' WHERE id = $id";
    
    if (mysqli_query($conn, $update_query)) {
        $_SESSION['success_message'] = 'Category updated successfully!';
        header("Location: view_categories.php");
        exit();
    } else {
        $_SESSION['error_message'] = 'Error updating category: ' . mysqli_error($conn);
    }
}

ob_end_flush(); // End output buffering
?>

<div class="container mt-5">
    <h2>Edit Product Category</h2>

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
        <div class="mb-3">
            <label for="category_name" class="form-label">Category Name</label>
            <input type="text" class="form-control" id="category_name" name="category_name" value="<?php echo htmlspecialchars($category['category_name']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description" rows="3"><?php echo htmlspecialchars($category['description']); ?></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Update Category</button>
    </form>
</div>

<!-- Include Footer -->
<?php include 'includes/footer.php'; ?>

</body>
</html>
