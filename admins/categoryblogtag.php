<?php 
session_start(); // Start the session to access $_SESSION variables
include('includes/header.php');
include "../config/conn.php";

// Fetch categories
$sql = "SELECT * FROM categories";
$result = mysqli_query($conn, $sql);


$sql = "SELECT * FROM tags";
$results = mysqli_query($conn, $sql);
?>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-6">
            <h2>Tags</h2>
        </div>
<div class="col-md-6 text-end">
    <!-- Link to Add Categories Page -->
    <a href="add-tags.php" class="btn btn-success">
        Add Tag
    </a>
</div>

    <!-- Display Success/Error Message -->
    <?php if (isset($_SESSION['status'])): ?>
        <div class="alert alert-info alert-dismissible fade show mt-3" role="alert">
            <?php 
                echo $_SESSION['status']; 
                unset($_SESSION['status']); // Clear the message after displaying
            ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <table class="table table-striped mt-4">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($results)): ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['name']; ?></td>
                    <td>
                        <a href="edit-tag.php?id=<?php echo $row['id']; ?>&table=categories" class="btn btn-primary btn-sm">Edit</a>
                        <a href="delete-tag.php?id=<?php echo $row['id']; ?>&table=categories" 
                           onclick="return confirm('Are you sure you want to delete this category?');" 
                           class="btn btn-danger btn-sm">
                           Delete
                        </a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>





<div class="container mt-5">
    <div class="row">
        <div class="col-md-6">
            <h2>Categories</h2>
        </div>
<div class="col-md-6 text-end">
    <!-- Link to Add Categories Page -->
    <a href="categories.php" class="btn btn-success">
        Add Category
    </a>
</div>

    <!-- Display Success/Error Message -->
    <?php if (isset($_SESSION['status'])): ?>
        <div class="alert alert-info alert-dismissible fade show mt-3" role="alert">
            <?php 
                echo $_SESSION['status']; 
                unset($_SESSION['status']); // Clear the message after displaying
            ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <table class="table table-striped mt-4">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['name']; ?></td>
                    <td>
                        <a href="edit-category.php?id=<?php echo $row['id']; ?>&table=categories" class="btn btn-primary btn-sm">Edit</a>
                        <a href="delete-category.php?id=<?php echo $row['id']; ?>&table=categories" 
                           onclick="return confirm('Are you sure you want to delete this category?');" 
                           class="btn btn-danger btn-sm">
                           Delete
                        </a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
</div>
</div>
</div>

<?php include('includes/footer.php'); ?>
