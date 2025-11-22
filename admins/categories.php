<?php 
session_start();
include('include/header.php'); // Include header
?>


<div class="container mt-5">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card shadow">
                <div class="card-header bg-success text-white">
                    <h4 class="mb-0">Add New Category</h4>
                </div>
                <div class="card-body">
                    <!-- Display Success/Error Message -->
                    <?php if (isset($_SESSION['status'])): ?>
                        <div class="alert alert-info alert-dismissible fade show" role="alert">
                            <?php 
                                echo $_SESSION['status']; 
                                unset($_SESSION['status']); // Clear the message after displaying
                            ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <!-- Add Category Form -->
                    <form action="add-category.php" method="POST">
                        <div class="mb-3">
                            <label for="name" class="form-label">Category Name</label>
                            <input type="text" name="name" id="name" class="form-control" placeholder="Enter category name" required>
                        </div>
                        <div class="text-end">
                            <button type="submit" class="btn btn-success">Add Category</button>
                            <a href="categories.php" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<?php include('include/footer.php'); ?>
