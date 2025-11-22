<?php 
ob_start();
session_start(); // Start the session
include('include/header.php');


if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    $query = "SELECT * FROM product_category WHERE id = $id";
    $result = mysqli_query($conn, $query);
    $category = mysqli_fetch_assoc($result);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $category_name = mysqli_real_escape_string($conn, $_POST['category_name']);
        $description = mysqli_real_escape_string($conn, $_POST['description']);

        $updateQuery = "UPDATE product_category SET category_name = '$category_name', description = '$description' WHERE id = $id";

        if (mysqli_query($conn, $updateQuery)) {
            // Set success message in session
            $_SESSION['success_message'] = "Category updated successfully!";
            header("Location: product_category_table.php");
            exit();
        } else {
            // Set error message in session
            $_SESSION['error_message'] = "Error updating category: " . mysqli_error($conn);
            header("Location: product_category_table.php");
            exit();
        }
    }
} else {
    // Set invalid request message in session
    $_SESSION['error_message'] = "Invalid request!";
    header("Location: view_categories.php");
    exit();
}
ob_end_flush(); 
?>


<div class="container mt-5">
    <h2>Edit Product Category</h2>
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
</body>
</html>
