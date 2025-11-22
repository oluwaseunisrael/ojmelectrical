<?php 
session_start();
include('include/header.php');

// Query to fetch all products along with their categories
$query = "SELECT p.*, c.category_name FROM product p
          LEFT JOIN product_category c ON p.category_id = c.id
          ORDER BY p.id DESC";
$result = mysqli_query($conn, $query);
?>

<div class="container mt-5">
    <h2 class="mb-4">Product List</h2>

    <!-- Display Session Message -->
    <?php if (isset($_SESSION['message'])): ?>
        <div class="alert alert-info"><?php echo $_SESSION['message']; unset($_SESSION['message']); ?></div>
    <?php endif; ?>

    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Category</th>
                <th>New Price</th>
                <th>Old Price</th>
                <th>Sale Status</th>
                <th>Type One</th>
                <th>Type Two</th>
                <th>Type Three</th>
                <th>Type Four</th>
                
              
                <th>Image</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (mysqli_num_rows($result) > 0): ?>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo htmlspecialchars($row['product_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['category_name']); ?></td>
                        <td>$<?php echo number_format($row['new_price'], 2); ?></td>
                        <td>$<?php echo number_format($row['old_price'], 2); ?></td>
                        <td><?php echo htmlspecialchars(ucfirst($row['sale_status'])); ?></td>
                        <td><?php echo htmlspecialchars($row['type_one']); ?></td>
                        <td><?php echo htmlspecialchars($row['type_two']); ?></td>
                        <td><?php echo htmlspecialchars($row['type_three']); ?></td>
                        <td><?php echo htmlspecialchars($row['type_four']); ?></td>
                       
                        <td>
                            <img src="../uploads/<?php echo htmlspecialchars($row['image']); ?>" alt="Product Image" style="width: 80px; height: 80px; object-fit: cover;">
                        </td>
                        <td>
                            <a href="update-product.php?id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                            <a href="delete_product.php?id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this product?');">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="14" class="text-center">No products found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <a href="add-product-sale.php" class="btn btn-primary mt-3">Add New Product</a>
</div>
</body>
</html>
