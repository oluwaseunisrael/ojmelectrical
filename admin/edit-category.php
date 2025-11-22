<?php 
session_start();
include('includes/header.php'); // Include header

include "../config/conn.php";

$id = intval($_GET['id']); // Get the category ID from URL
$sql = "SELECT * FROM categories WHERE id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$category = mysqli_fetch_assoc($result);

if (!$category) {
    $_SESSION['status'] = "Category not found.";
    header("Location: categoryblogtag.php");
    exit();
}
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg">
                <div class="card-header bg-primary text-white text-center">
                    <h4>Edit Category</h4>
                </div>
                <div class="card-body">
                    <!-- Display Success/Error Message -->
                    <?php if (isset($_SESSION['status'])): ?>
                        <div class="alert alert-info alert-dismissible fade show" role="alert">
                            <?php 
                                echo htmlspecialchars($_SESSION['status'], ENT_QUOTES, 'UTF-8'); 
                                unset($_SESSION['status']);
                            ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <form action="edit-category-process.php" method="POST">
                        <input type="hidden" name="id" value="<?php echo htmlspecialchars($category['id']); ?>">
                        <div class="mb-3">
                            <label for="name" class="form-label">Category Name</label>
                            <input 
                                type="text" 
                                class="form-control" 
                                id="name" 
                                name="name" 
                                value="<?php echo htmlspecialchars($category['name']); ?>" 
                                required 
                                maxlength="100"
                            >
                            <small class="form-text text-muted">Edit the category name as needed.</small>
                        </div>
                        <div class="d-flex justify-content-between">
                            <a href="categoryblogtag.php" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">Update Category</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>
