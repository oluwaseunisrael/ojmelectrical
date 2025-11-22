<?php 
session_start();
include('includes/header.php'); // Include header
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-lg">
                <div class="card-header bg-primary text-white text-center">
                    <h4 class="mb-0">Add New Tag</h4>
                </div>
                <div class="card-body">
                    <!-- Display Success/Error Message -->
                    <?php if (isset($_SESSION['status'])): ?>
                        <div class="alert alert-<?php echo $_SESSION['status_type'] ?? 'info'; ?> alert-dismissible fade show" role="alert">
                            <?php 
                                echo htmlspecialchars($_SESSION['status'], ENT_QUOTES, 'UTF-8'); 
                                unset($_SESSION['status'], $_SESSION['status_type']); // Clear the message after displaying
                            ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <!-- Add Tag Form -->
                    <form action="add-tag-code.php" method="POST">
                        <div class="mb-4">
                            <label for="tagName" class="form-label">Tag Name</label>
                            <input type="text" name="name" id="tagName" class="form-control" placeholder="Enter tag name" required maxlength="50" aria-describedby="tagHelp">
                            <small id="tagHelp" class="form-text text-muted">The tag name must be unique and not exceed 50 characters.</small>
                        </div>
                        <div class="d-flex justify-content-between">
                            <a href="tags.php" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">Add Tag</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>
