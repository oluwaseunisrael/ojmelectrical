<?php
session_start();
include('includes/header.php');

// Get the admin ID from the URL
$id = $_GET['id'];

// Fetch admin details from the database
$sql = "SELECT * FROM admins WHERE id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$admin = mysqli_fetch_assoc($result);
?>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-primary">Edit Admin</h2>
        <a href="admin-table.php" class="btn btn-outline-secondary">Back to Admin List</a>
    </div>

    <!-- Admin Edit Form -->
    <form action="edit-admin-process.php" method="POST" enctype="multipart/form-data" class="shadow p-4 rounded bg-light">
        <input type="hidden" name="id" value="<?php echo $admin['id']; ?>">

        <!-- Name -->
        <div class="mb-3">
            <label for="name" class="form-label">Full Name <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="name" name="name" value="<?php echo $admin['name']; ?>" placeholder="Enter full name" required>
        </div>

        <!-- Email -->
        <div class="mb-3">
            <label for="email" class="form-label">Email Address <span class="text-danger">*</span></label>
            <input type="email" class="form-control" id="email" name="email" value="<?php echo $admin['email']; ?>" placeholder="Enter email address" required>
        </div>

        <!-- Password -->
        <div class="mb-3 position-relative">
            <label for="password" class="form-label">New Password</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Enter new password">
            <button type="button" class="btn btn-outline-secondary btn-sm position-absolute top-50 end-0 translate-middle-y me-2" onclick="togglePassword('password')">Show</button>
        </div>

        <!-- Confirm Password -->
        <div class="mb-3 position-relative">
            <label for="confirm_password" class="form-label">Confirm Password</label>
            <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Re-enter new password">
            <button type="button" class="btn btn-outline-secondary btn-sm position-absolute top-50 end-0 translate-middle-y me-2" onclick="togglePassword('confirm_password')">Show</button>
        </div>

        <!-- Profile Image -->
        <div class="mb-3">
            <label for="image" class="form-label">Profile Image</label>
            <input type="file" class="form-control" id="image" name="image" accept="image/*">
            <div class="mt-3">
                <label>Current Image:</label>
                <br>
                <img src="<?php echo $admin['image']; ?>" class="border rounded" width="120" height="120" alt="Current Profile Image">
            </div>
        </div>

        <div class="text-center">
            <button type="submit" class="btn btn-primary w-100">Update Admin</button>
        </div>
    </form>
</div>

<script>
    function togglePassword(fieldId) {
        const field = document.getElementById(fieldId);
        field.type = field.type === "password" ? "text" : "password";
    }
</script>

<?php
include('includes/footer.php');
?>
