<?php 
session_start(); // Start the session to access $_SESSION variables

include('includes/header.php'); // Include the header file

// Fetch all services from the database
$query = "SELECT * FROM services";
$result = mysqli_query($conn, $query);
?>

<div class="container mt-5">
    <h2 class="mb-4 text-center">Services</h2>

    <!-- Add Service Button -->
    <div class="mb-3 text-end">
        <a href="add_service.php" class="btn btn-success">Add Service</a>
    </div>

    <?php if (isset($_SESSION['status'])): ?>
        <div class="alert alert-info"><?= $_SESSION['status']; unset($_SESSION['status']); ?></div>
    <?php endif; ?>

    <div class="table-responsive">
        <table class="table table-striped table-bordered">
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
                        <td><img src="../uploads/<?= $service['firstimage']; ?>" width="50" height="50" alt="First Image" class="img-fluid"></td>
                        <td>
                            <!-- Edit button -->
                            <a href="edit_service.php?id=<?= $service['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                            
                            <!-- Delete button -->
                            <a href="delete_service.php?id=<?= $service['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this service?')">Delete</a>
                            
                            <!-- View button -->
                            <a href="view_service.php?id=<?= $service['id']; ?>" class="btn btn-info btn-sm">View</a>
                            
                            <!-- Success button -->
                            <a href="success_service.php?id=<?= $service['id']; ?>" class="btn btn-success btn-sm">Success</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

<?php
include('includes/footer.php');
?>
