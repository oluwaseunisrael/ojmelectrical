<?php 
session_start(); // Start the session to access $_SESSION variables

include('include/header.php');
?>

<div class="container mt-4">

    <div class="d-flex justify-content-between">
        <h2>Add Admin</h2>
     <!-- Display Success/Error Message -->
<?php if (isset($_SESSION['status'])): ?>
    <div class="alert <?php echo strpos($_SESSION['status'], 'successfully') !== false ? 'alert-success' : 'alert-danger'; ?> alert-dismissible fade show" role="alert">
        <?php 
            echo $_SESSION['status']; 
            unset($_SESSION['status']);
        ?>
        <!-- Cancel (Close) Button -->
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>
.
        <!-- Styled Back Button -->
        <a href="admin-table.php" class="btn btn-success">Back</a>
    </div>
<form action="add_admin_process.php" method="POST" enctype="multipart/form-data">
    <div class="mb-3">
        <label for="name" class="form-label">Name</label>
        <input type="text" class="form-control" id="name" name="name">
    </div>
    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" class="form-control" id="email" name="email">
    </div>
    <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" class="form-control" id="password" name="password" >
    </div>
    <div class="mb-3">
        <label for="confirm_password" class="form-label">Confirm Password</label>
        <input type="password" class="form-control" id="confirm_password" name="confirm_password">
    </div>
    <div class="mb-3">
        <label for="image" class="form-label">Image</label>
        <input type="file" class="form-control" id="image" name="image">
    </div>
    <button type="submit" class="btn btn-success">Add Admin</button>
</form>

</div>

<?php include('include/footer.php') ?>
