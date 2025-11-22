<?php
session_start();
include('../config/conn.php');

$id = $_GET['id'];

// Delete the service
$query = "DELETE FROM services WHERE id = '$id'";
if (mysqli_query($conn, $query)) {
    $_SESSION['status'] = "Service deleted successfully!";
    header("Location: service-table.php");
} else {
    $_SESSION['status'] = "Error deleting service: " . mysqli_error($conn);
    header("Location: service-table.php");
}
?>
