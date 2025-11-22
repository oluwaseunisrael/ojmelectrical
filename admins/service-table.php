<?php 
session_start(); // Start the session to access $_SESSION variables

include('include/header.php'); // Include the header file

// Fetch all services from the database
$query = "SELECT * FROM services";
$result = mysqli_query($conn, $query);
?>

<h2  style="margin-left:40px ;">Services</h2>

<!-- Add Service Button -->
<a href="add_service.php" class="btn btn-success mb-3" style="margin-left:40px ;">Add Service</a>

<?php if (isset($_SESSION['status'])): ?>
    <div class="alert alert-info"><?= $_SESSION['status']; unset($_SESSION['status']); ?></div>
<?php endif; ?>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Subtitle</th>
            <th>First Image</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($service = mysqli_fetch_assoc($result)): ?>
            <tr>
                <td><?= $service['id']; ?></td>
                <td><?= $service['title']; ?></td>
                <td><?= $service['subtitle']; ?></td>
                <td><img src="../uploads/<?= $service['firstimage']; ?>" width="50" height="50" alt="First Image"></td>
                <td>
                    <!-- Edit button -->
                    <a href="edit_service.php?id=<?= $service['id']; ?>" class="btn btn-warning">Edit</a>
                    
                    <!-- Delete button -->
                    <a href="delete_service.php?id=<?= $service['id']; ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this service?')">Delete</a>
                    
                    <!-- View button -->
                    <a href="view_service.php?id=<?= $service['id']; ?>" class="btn btn-info">View</a>
                    
                    <!-- Success button -->
                    <a href="success_service.php?id=<?= $service['id']; ?>" class="btn btn-success">Success</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>
</div>
<?php
include('include/footer.php');
?>
