<?php 
session_start(); // Start the session to access $_SESSION variables

include('includes/header.php');
?>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-primary">Add Admin</h2>

        <!-- Back Button -->
        <a href="admin-table.php" class="btn btn-outline-secondary">Back to Admin List</a>
    </div>

    <!-- Display Success/Error Message -->
    <?php if (isset($_SESSION['status'])): ?>
        <div class="alert <?php echo strpos($_SESSION['status'], 'successfully') !== false ? 'alert-success' : 'alert-danger'; ?> alert-dismissible fade show" role="alert">
            <?php 
                echo $_SESSION['status']; 
                unset($_SESSION['status']);
            ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <!-- Admin Form -->
    <form action="add_admin_process.php" method="POST" enctype="multipart/form-data" class="shadow p-4 rounded bg-light">
        <div class="mb-3">
            <label for="name" class="form-label">Full Name <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="name" name="name" placeholder="Enter full name" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email Address <span class="text-danger">*</span></label>
            <input type="email" class="form-control" id="email" name="email" placeholder="Enter email address" required>
        </div>

        <div class="mb-3 position-relative">
            <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Enter password" required>
            <button type="button" class="btn btn-outline-secondary btn-sm position-absolute top-50 end-0 translate-middle-y me-2" onclick="togglePassword('password')">Show</button>
        </div>

        <div class="mb-3 position-relative">
            <label for="confirm_password" class="form-label">Confirm Password <span class="text-danger">*</span></label>
            <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Re-enter password" required>
            <button type="button" class="btn btn-outline-secondary btn-sm position-absolute top-50 end-0 translate-middle-y me-2" onclick="togglePassword('confirm_password')">Show</button>
        </div>

        <div class="mb-3">
            <label for="image" class="form-label">Profile Image</label>
            <input type="file" class="form-control" id="image" name="image" accept="image/*">
        </div>

        <div class="text-center">
            <button type="submit" class="btn btn-primary w-100">Add Admin</button>
        </div>
    </form>
</div>

<script>
    function togglePassword(fieldId) {
        const field = document.getElementById(fieldId);
        if (field.type === "password") {
            field.type = "text";
        } else {
            field.type = "password";
        }
    }
</script>

<?php include('includes/footer.php'); ?>
