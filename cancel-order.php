<?php
include('include/header.php');
session_start();

if (isset($_SESSION['user_id']) && isset($_GET['order_id'])) {
    $user_id = $_SESSION['user_id'];
    $order_id = $_GET['order_id'];

    // Update order status to 'Cancelled'
    $cancel_query = "UPDATE orders SET order_status = 'Cancelled' WHERE customer_id = $user_id AND order_id = $order_id";
    if (mysqli_query($conn, $cancel_query)) {
        header("Location: order-item.php");
    } else {
        echo "Error cancelling the order.";
    }
} else {
    header("Location: order-item.php");
}
?>
