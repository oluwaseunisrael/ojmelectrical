<?php
ob_start();
session_start();
include('includes/header.php');

// Check if ID is provided
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $customer_id = intval($_GET['id']);

    // Fetch customer details
    $query = "SELECT * FROM customers WHERE id = $customer_id";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $customer = mysqli_fetch_assoc($result);
    } else {
        $_SESSION['error_message'] = 'Customer not found.';
        header("Location: customer-table.php");
        exit();
    }
} else {
    $_SESSION['error_message'] = 'Invalid customer ID.';
    header("Location: customer-table.php");
    exit();
}

ob_end_flush();
?>

<div class="container mt-5">
    <h2>Customer Details</h2>

    <table class="table table-bordered">
        <tr>
            <th>ID</th>
            <td><?php echo htmlspecialchars($customer['id']); ?></td>
        </tr>
        <tr>
            <th>Name</th>
            <td><?php echo htmlspecialchars($customer['name']); ?></td>
        </tr>
        <tr>
            <th>Email</th>
            <td><?php echo htmlspecialchars($customer['email']); ?></td>
        </tr>
        <tr>
            <th>Phone</th>
            <td><?php echo htmlspecialchars($customer['phone']); ?></td>
        </tr>
        <tr>
            <th>Image</th>
            <td>
                <?php if (!empty($customer['image'])): ?>
                    <img src="../uploads/<?php echo htmlspecialchars($customer['image']); ?>" alt="Customer Image" class="img-fluid" style="max-width: 150px;">
                <?php else: ?>
                    <p>No image available</p>
                <?php endif; ?>
            </td>
        </tr>
        <tr>
            <th>City</th>
            <td><?php echo htmlspecialchars($customer['city']); ?></td>
        </tr>
        <tr>
            <th>Country</th>
            <td><?php echo htmlspecialchars($customer['country']); ?></td>
        </tr>
    </table>

    <a href="customer-table.php" class="btn btn-primary">Back to Customer List</a>
</div>

<?php include 'includes/footer.php'; ?>
