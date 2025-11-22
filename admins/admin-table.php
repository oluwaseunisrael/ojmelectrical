<?php 
session_start(); // Start the session to access $_SESSION variables


include('include/header.php')?>

<div class="container mt-4" style="background: white;">
    <h2>Admin Management</h2>
    <!-- Add Admin Button -->
    <div class="mb-3">
        <a href="add-admin.php" class="btn btn-success">Add Admin</a>
            <!-- Display Success/Error Message -->
    <?php if (isset($_SESSION['status'])): ?>
    <div class="alert <?php echo strpos($_SESSION['status'], 'successfully') !== false ? 'alert-success' : 'alert-danger'; ?>">
        <?php 
            echo $_SESSION['status']; 
            unset($_SESSION['status']);
        ?>
    </div>
<?php endif; ?>

    </div>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Image</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $result = mysqli_query($conn, "SELECT * FROM admins");

            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>
                        <td>{$row['id']}</td>
                        <td>{$row['name']}</td>
                        <td>{$row['email']}</td>
                        <td><img src='{$row['image']}' width='50' height='50'></td>
                        <td>" . ($row['is_banned'] ? 'Banned' : 'Active') . "</td>
                        <td>
                            <a href='edit-admin.php?id={$row['id']}' class='btn btn-sm btn-primary'>Edit</a>
                            <a href='delete-admin.php?id={$row['id']}' class='btn btn-sm btn-danger'>Delete</a>
                            <a href='toggle_ban.php?id={$row['id']}' class='btn btn-sm btn-warning'>" . ($row['is_banned'] ? 'Unban' : 'Ban') . "</a>
                        </td>
                      </tr>";
            }
            ?>
        </tbody>
    </table>
</div>
</div>
<?php include('include/footer.php')?>
