<?php 
session_start(); // Start the session to access $_SESSION variables

include('includes/header.php');
?>

<div class="container-fluid">
    <h2 class="my-4 text-center">Admin Management</h2>
    
    <!-- Add Admin Button -->
    <div class="mb-3 text-end">
        <a href="add-admin.php" class="btn btn-success">+ Add Admin</a>
    </div>

    <!-- Display Success/Error Message -->
    <?php if (isset($_SESSION['status'])): ?>
        <div class="alert <?php echo strpos($_SESSION['status'], 'successfully') !== false ? 'alert-success' : 'alert-danger'; ?> text-center">
            <?php 
                echo $_SESSION['status']; 
                unset($_SESSION['status']);
            ?>
        </div>
    <?php endif; ?>

    <!-- Admin Table -->
    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="table-dark">
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
                    $statusBadge = $row['is_banned'] ? 'badge-danger' : 'badge-success';
                    $statusText = $row['is_banned'] ? 'Banned' : 'Active';
                    $imageSrc = $row['image'] ? $row['image'] : 'default-placeholder.png';

                    echo "
                    <tr>
                        <td>{$row['id']}</td>
                        <td>{$row['name']}</td>
                        <td>{$row['email']}</td>
                        <td>
                            <img src='{$imageSrc}' alt='Admin Image' class='img-thumbnail' style='width: 50px; height: 50px;'>
                        </td>
                        <td>
                            <span class='badge {$statusBadge}'>{$statusText}</span>
                        </td>
                        <td>
                            <div class='btn-group' role='group'>
                                <a href='edit-admin.php?id={$row['id']}' class='btn btn-sm btn-primary'>Edit</a>
                                <a href='delete-admin.php?id={$row['id']}' class='btn btn-sm btn-danger'>Delete</a>
                                <a href='toggle_ban.php?id={$row['id']}' class='btn btn-sm btn-warning'>
                                    " . ($row['is_banned'] ? 'Unban' : 'Ban') . "
                                </a>
                            </div>
                        </td>
                    </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<?php include('includes/footer.php'); ?>
