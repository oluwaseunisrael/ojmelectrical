<?php 
session_start();
include('includes/header.php');

// Define the number of products per page
$products_per_page = 10;

// Get the current page number from the URL (defaults to 1 if not set)
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start_from = ($page - 1) * $products_per_page;

// Query to fetch all products along with their categories with LIMIT for pagination
$query = "SELECT p.*, c.category_name FROM product p
          LEFT JOIN product_category c ON p.category_id = c.id
          ORDER BY p.id DESC LIMIT $start_from, $products_per_page";
$result = mysqli_query($conn, $query);

// Query to get the total number of products
$total_query = "SELECT COUNT(*) FROM product";
$total_result = mysqli_query($conn, $total_query);
$total_row = mysqli_fetch_array($total_result);
$total_products = $total_row[0];

// Calculate the total number of pages
$total_pages = ceil($total_products / $products_per_page);
?>

<div class="container mt-5">
    <h2 class="mb-4">Product List</h2>

    <!-- Display Session Message -->
   <?php if (isset($_SESSION['status'])): ?>
        <div class="alert alert-info"><?php echo $_SESSION['status']; unset($_SESSION['status']); ?></div>
    <?php endif; ?>

    <!-- Table Design with modern look -->
    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead class="thead-dark">
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
                                <img src="../uploads/<?php echo htmlspecialchars($row['image']); ?>" alt="Product Image" class="img-fluid rounded" style="width: 80px; height: 80px; object-fit: cover;">
                            </td>
                            <td>
                                <a href="update-product.php?id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                <a href="delete_product.php?id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this product?');">Delete</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="12" class="text-center">No products found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Pagination Controls -->
    <div class="d-flex justify-content-between mt-4">
        <!-- Previous Page -->
        <?php if ($page > 1): ?>
            <a href="product-list.php?page=<?php echo $page - 1; ?>" class="btn btn-secondary">Previous</a>
        <?php endif; ?>

        <!-- Page Numbers -->
        <div>
            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <a href="product-list.php?page=<?php echo $i; ?>" class="btn btn-light <?php if ($i == $page) echo 'active'; ?>"><?php echo $i; ?></a>
            <?php endfor; ?>
        </div>

        <!-- Next Page -->
        <?php if ($page < $total_pages): ?>
            <a href="product-list.php?page=<?php echo $page + 1; ?>" class="btn btn-secondary">Next</a>
        <?php endif; ?>
    </div>

    <!-- Button to add a new product -->
    <a href="add-product-sale.php" class="btn btn-primary mt-3">Add New Product</a>
</div>

<?php include('includes/footer.php'); ?>
