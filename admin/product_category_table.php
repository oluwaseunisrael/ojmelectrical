<?php 
ob_start();
session_start(); // Start the session
include('includes/header.php'); // Include header

// Fetch categories from the database
$query = "SELECT * FROM product_category";
$result = mysqli_query($conn, $query);

if (!$result) {
    $_SESSION['error_message'] = 'Error fetching categories: ' . mysqli_error($conn);
    header("Location: view_categories.php");
    exit();
}

ob_end_flush(); // End output buffering
?>

<div class="container mt-5">
    <h2 class="mb-4">View Product Categories</h2>

    <!-- Display Session Messages -->
    <?php if (isset($_SESSION['success_message'])): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?php 
                echo $_SESSION['success_message']; 
                unset($_SESSION['success_message']); // Clear the message
            ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['error_message'])): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?php 
                echo $_SESSION['error_message']; 
                unset($_SESSION['error_message']); // Clear the message
            ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <!-- Table to Display Categories -->
    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Category Name</th>
                <th scope="col">Description</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $row['id'] . "</td>";
                    echo "<td>" . $row['category_name'] . "</td>";
                    echo "<td>" . $row['description'] . "</td>";
                    echo "<td>
                            <a href='edit_category.php?id=" . $row['id'] . "' class='btn btn-warning btn-sm'>Edit</a>
                            <a href='delete_category_product.php?id=" . $row['id'] . "' class='btn btn-danger btn-sm' onclick='return confirm(\"Are you sure you want to delete this category?\")'>Delete</a>
                          </td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='4'>No categories found</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<!-- Include Footer -->
<?php include 'includes/footer.php'; ?>

</body>
</html>
