<?php
session_start();
include('../config/conn.php');

$id = $_GET['id'];
$query = "SELECT * FROM services WHERE id = '$id'";
$result = mysqli_query($conn, $query);
$service = mysqli_fetch_assoc($result);
?>

<h2>View Service: <?= $service['title']; ?></h2>

<p><strong>Title:</strong> <?= $service['title']; ?></p>
<p><strong>Subtitle:</strong> <?= $service['subtitle']; ?></p>
<p><strong>Benefit Content:</strong> <?= $service['benefit_content']; ?></p>
<img src="../uploads/<?= $service['firstimage']; ?>" width="100" height="100" alt="First Image">
<!-- Display other images if needed -->
