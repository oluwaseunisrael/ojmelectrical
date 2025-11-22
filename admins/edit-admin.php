<?php
session_start();
include('include/header.php');



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
    <h2>Edit Admin</h2>
    <form action="edit-admin-process.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo $admin['id']; ?>">
        
        <!-- Name -->
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" id="name" name="name" value="<?php echo $admin['name']; ?>" required>
        </div>

        <!-- Email -->
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="<?php echo $admin['email']; ?>" required>
        </div>

        <!-- Password -->
        <div class="mb-3">
            <label for="password" class="form-label">New Password</label>
            <input type="password" class="form-control" id="password" name="password">
        </div>

        <!-- Confirm Password -->
        <div class="mb-3">
            <label for="confirm_password" class="form-label">Confirm Password</label>
            <input type="password" class="form-control" id="confirm_password" name="confirm_password">
        </div>

        <!-- Image -->
        <div class="mb-3">
            <label for="image" class="form-label">Profile Image</label>
            <input type="file" class="form-control" id="image" name="image">
            <img src="<?php echo $admin['image']; ?>" width="100" height="100" alt="Current Image">
        </div>

        <button type="submit" class="btn btn-success">Update Admin</button>
    </form>
</div>
<?php
include('include/footer.php');?>