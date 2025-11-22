<?php
include('include/header.php');
session_start();

if (isset($_SESSION['user_id']) && isset($_GET['order_id'])) {
    $user_id = $_SESSION['user_id'];
    $order_id = $_GET['order_id'];

    // Fetch order details
    $order_query = "SELECT * FROM orders WHERE customer_id = $user_id AND order_id = $order_id";
    $order_run = mysqli_query($conn, $order_query);
    $order = mysqli_fetch_assoc($order_run);

    // Fetch customer details
    $customer_query = "SELECT * FROM customers WHERE id = $user_id";
    $customer_run = mysqli_query($conn, $customer_query);
    $customer = mysqli_fetch_assoc($customer_run);

    // Fetch order items
    $items_query = "SELECT * FROM order_items WHERE order_id = $order_id";
    $items_run = mysqli_query($conn, $items_query);
} else {
    header("Location: order-item.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Order Details</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container my-5">
        <h2 class="mb-4">Order Details - Order ID: <?php echo $order['order_id']; ?></h2>
        
        <!-- Customer Information -->
        <div class="card mb-4 p-4">
            <h4>Customer Information</h4>
            <p><strong>Name:</strong> <?php echo $order['first_name'] . ' ' . $order['last_name']; ?></p>
            <p><strong>Email:</strong> <?php echo $order['email']; ?></p>
            <p><strong>Phone:</strong> <?php echo $order['phone']; ?></p>
            <p><strong>Address:</strong> <?php echo $order['address'] . ', ' . $order['city'] . ', ' . $order['zip']; ?></p>
        </div>

        <!-- Order Information -->
        <div class="card mb-4 p-4">
            <p><strong>Order Status:</strong> <?php echo $order['order_status']; ?></p>
            <p><strong>Order Date:</strong> <?php echo date('F j, Y', strtotime($order['order_date'])); ?></p>
        </div>
        
        <!-- Order Items -->
        <h4 class="mb-3">Order Items</h4>
        <div class="card mb-4 p-4">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Product Name</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($item = mysqli_fetch_assoc($items_run)) { ?>
                        <tr>
                            <td><?php echo $item['product_name']; ?></td>
                            <td><?php echo $item['quantity']; ?></td>
                            <td><?php echo number_format($item['price'], 2); ?></td>
                            <td><?php echo number_format($item['subtotal'], 2); ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

        <!-- Total and Payment Information -->
        <h4 class="mb-3">Order Summary</h4>
        <div class="card p-4">
            <p><strong>Subtotal:</strong> <?php echo number_format($order['subtotal'], 2); ?></p>
            <p><strong>Shipping Cost:</strong> <?php echo number_format($order['shipping_cost'], 2); ?></p>
            <p><strong>Total:</strong> <?php echo number_format($order['total'], 2); ?></p>
        </div>
    </div>

    <!-- Bootstrap JS (for features like modals, dropdowns) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
