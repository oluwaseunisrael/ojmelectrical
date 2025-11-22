<?php
include "config/conn.php";

if (!isset($_GET['order_id'])) {
    header("Location: index.php");
    exit;
}

$order_id = $_GET['order_id'];

$orderQuery = "SELECT * FROM orders WHERE id = $order_id";
$orderResult = mysqli_query($conn, $orderQuery);

if (!$orderResult || mysqli_num_rows($orderResult) === 0) {
    header("Location: index.php");
    exit;
}

$order = mysqli_fetch_assoc($orderResult);

$orderItemsQuery = "SELECT * FROM order_items WHERE order_id = $order_id";
$orderItemsResult = mysqli_query($conn, $orderItemsQuery);

if (!$orderItemsResult) {
    throw new Exception("Failed to retrieve order items: " . mysqli_error($conn));
}

$orderItems = [];
while ($item = mysqli_fetch_assoc($orderItemsResult)) {
    $orderItems[] = $item;
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Order Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f0f0f0;
        }
    </style>
</head>
<body>
    <h1>Order Details</h1>
    <p>Order ID: <?= $order['id'] ?></p>
    <p>Order Date: <?= $order['created_at'] ?></p>
    <p>Total Amount: <?= $order['total_amount'] ?></p>
    <h2>Order Items:</h2>
    <table>
        <tr>
            <th>Product Name</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Subtotal</th>
        </tr>
        <?php foreach ($orderItems as $item): ?>
        <tr>
            <td><?= $item['product_name'] ?></td>
            <td><?= $item['price'] ?></td>
            <td><?= $item['quantity'] ?></td>
            <td><?= $item['subtotal'] ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
    <p><a href="index.php">Back to Home</a></p>
</body>
</html>