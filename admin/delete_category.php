<?php
include "../config/conn.php";

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    $query = "DELETE FROM product_category WHERE id = $id";
    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Category deleted successfully!'); window.location.href='product_category_table.php';</script>";
    } else {
        echo "<script>alert('Error deleting category: " . mysqli_error($conn) . "');</script>";
    }
} else {
    echo "<script>alert('Invalid request!'); window.location.href='product_category_table.php';</script>";
}
?>
