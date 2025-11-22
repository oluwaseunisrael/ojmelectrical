<?php 
session_start(); // Start the session to access $_SESSION variables


include('include/header.php');

$query = "SELECT * FROM product_category ORDER BY created_at DESC";
$result = mysqli_query($conn, $query);
?>


<div class="container mt-5">
    <h2 class="mb-4">Product Categories</h2>

    <!-- Add Category Button -->
    <div class="d-flex justify-content-end mb-3">
        <a href="add_category.php" class="btn btn-primary">Add Category</a>
    </div>

    <!-- Category Table -->
    <table class="table table-bordered">
        
    <!-- Display Session Messages -->
    <?php if (isset($_SESSION['success_message'])): ?>
        <div class="alert alert-success">
            <?php 
                echo $_SESSION['success_message']; 
                unset($_SESSION['success_message']); // Clear the message
            ?>
        </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['error_message'])): ?>
        <div class="alert alert-danger">
            <?php 
                echo $_SESSION['error_message']; 
                unset($_SESSION['error_message']); // Clear the message
            ?>
        </div>
    <?php endif; ?>
        <thead>
            <tr>
                <th>ID</th>
                <th>Category Name</th>
                <th>Description</th>
                <th>Created At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo htmlspecialchars($row['category_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['description']); ?></td>
                    <td><?php echo $row['created_at']; ?></td>
                    <td>
                        <a href="edit-product-category.php?id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                        <a href="delete_category.php?id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
</body>
</html>
