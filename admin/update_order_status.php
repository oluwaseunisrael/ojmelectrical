<?php
session_start();
include('include/header.php');

if (isset($_GET['order_id'])) {
    $order_id = $_GET['order_id'];

    // Fetch order details
    $query = "SELECT * FROM orders WHERE order_id = $order_id";
    $result = mysqli_query($conn, $query);
    $order = mysqli_fetch_assoc($result);
}

if (isset($_POST['update_status'])) {
    $new_status = $_POST['order_status'];

    // Update order status in the database
    $update_query = "UPDATE orders SET order_status = '$new_status', updated_at = NOW() WHERE order_id = $order_id";
    mysqli_query($conn, $update_query);

    // Redirect back to the admin orders page
    header("Location: admin_orders.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Order Status</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Update Order Status</h1>

        <form method="POST">
            <div class="mb-3">
                <label for="order_status" class="form-label">Order Status</label>
                <select name="order_status" id="order_status" class="form-select">
                    <option value="Pending" <?php if ($order['order_status'] == 'Pending') echo 'selected'; ?>>Pending</option>
                    <option value="Shipped" <?php if ($order['order_status'] == 'Shipped') echo 'selected'; ?>>Shipped</option>
                    <option value="Delivered" <?php if ($order['order_status'] == 'Delivered') echo 'selected'; ?>>Delivered</option>
                    <option value="Cancelled" <?php if ($order['order_status'] == 'Cancelled') echo 'selected'; ?>>Cancelled</option>
                </select>
            </div>
            <button type="submit" name="update_status" class="btn btn-primary">Update Status</button>
        </form>
    </div>

    <!-- Bootstrap JS (Optional for interactive components) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
