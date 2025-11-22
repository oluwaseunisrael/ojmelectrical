<?php 
session_start(); // Start the session to access $_SESSION variables

include('include/header.php'); // Include the header file

// Fetch all service categories
$query = "SELECT * FROM service_categories";
$result = mysqli_query($conn, $query);
?>

<h2>Service Categories</h2>

<!-- Success Message -->
<?php if (isset($_SESSION['status'])): ?>
    <div class="alert alert-info"><?= $_SESSION['status']; unset($_SESSION['status']); ?></div>
<?php endif; ?>

<!-- Add Category Button -->
<a href="add-service-category.php" class="btn btn-success mb-3">Add Category Service</a>

<!-- Categories Table -->
<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($category = mysqli_fetch_assoc($result)): ?>
            <tr>
                <td><?= $category['id']; ?></td>
                <td><?= $category['name']; ?></td>
                <td>
                    <a href="add-service-category.php?id=<?= $category['id']; ?>" class="btn btn-warning">Edit</a>
                    <a href="delete-servicecategorym,q.php?id=<?= $category['id']; ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this category?')">Delete</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>

<?php
include('include/footer.php');
?>
