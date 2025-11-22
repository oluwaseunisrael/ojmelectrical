<?php
include "../config/conn.php";

$id = $_GET['id'];
$result = mysqli_query($conn, "SELECT is_banned FROM admins WHERE id=$id");
$row = mysqli_fetch_assoc($result);

$is_banned = $row['is_banned'] ? 0 : 1;
$sql = "UPDATE admins SET is_banned=? WHERE id=?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "ii", $is_banned, $id);
mysqli_stmt_execute($stmt);

header("Location: admin-table.php");
?>
