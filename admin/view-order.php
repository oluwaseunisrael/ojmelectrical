<?php
session_start();
include('include/header.php');
// Fetch all orders
$query = "SELECT * FROM orders";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Manage Orders</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Manage Orders</h1>

        <table class="table table-bordered table-striped">
            <thead class="thead-dark">
                <tr>
                    <th>Order ID</th>
                    <th>Customer Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Total</th>
                    <th>Order Status</th>
                    <th>Order Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($order = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $order['order_id'] . "</td>";
                    echo "<td>" . $order['first_name'] . " " . $order['last_name'] . "</td>";
                    echo "<td>" . $order['email'] . "</td>";
                    echo "<td>" . $order['phone'] . "</td>";
                    echo "<td>" . $order['total'] . "</td>";
                    echo "<td>" . $order['order_status'] . "</td>";
                    echo "<td>" . $order['order_date'] . "</td>";
                    echo "<td><a href='update_order_status.php?order_id=" . $order['order_id'] . "' class='btn btn-primary btn-sm'>Update Status</a></td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- Bootstrap JS (Optional for interactive components) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
