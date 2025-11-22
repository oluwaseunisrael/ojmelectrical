<?php 
session_start();
include('includes/header.php'); // Include header
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg">
                <div class="card-header bg-primary text-white text-center">
                    <h4 class="mb-0">Add New Category</h4>
                </div>
                <div class="card-body">
                    <!-- Display Success/Error Message -->
                    <?php if (isset($_SESSION['status'])): ?>
                        <div class="alert alert-info alert-dismissible fade show" role="alert">
                            <?php 
                                echo htmlspecialchars($_SESSION['status'], ENT_QUOTES, 'UTF-8'); 
                                unset($_SESSION['status']); // Clear the message after displaying
                            ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <!-- Add Category Form -->
                    <form action="add-category.php" method="POST">
                        <div class="mb-4">
                            <label for="categoryName" class="form-label">Category Name</label>
                            <input 
                                type="text" 
                                name="name" 
                                id="categoryName" 
                                class="form-control" 
                                placeholder="Enter category name" 
                                required 
                                maxlength="100"
                            >
                            <small class="form-text text-muted">Provide a unique and descriptive category name.</small>
                        </div>
                        <div class="d-flex justify-content-between">
                            <a href="categories.php" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">Add Category</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>
