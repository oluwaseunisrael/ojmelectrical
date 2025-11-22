<?php
include('include/header.php');
session_start();

if (isset($_SESSION['user_id']) && isset($_GET['order_id'])) {
    $user_id = $_SESSION['user_id'];
    $order_id = $_GET['order_id'];

    // Delete the order and its items
    $delete_items_query = "DELETE FROM order_items WHERE order_id = $order_id";
    $delete_order_query = "DELETE FROM orders WHERE order_id = $order_id AND customer_id = $user_id";

    if (mysqli_query($conn, $delete_items_query) && mysqli_query($conn, $delete_order_query)) {
        header("Location: order-item.php");
    } else {
        echo "Error deleting the order.";
    }
} else {
    header("Location: order-item.php");
}
?>
