<?php 
session_start();
include('include/header.php'); // Include header

include "../config/conn.php";

$id = intval($_GET['id']); // Get the category ID from URL
$sql = "SELECT * FROM categories WHERE id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$category = mysqli_fetch_assoc($result);

if (!$category) {
    $_SESSION['status'] = "Category not found.";
    header("Location: categoryblogtag.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Edit Category</title>
</head>
<body>
<div class="container mt-5">
    <h2>Edit Category</h2>

    <!-- Display Success/Error Message -->
    <?php if (isset($_SESSION['status'])): ?>
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            <?php 
                echo $_SESSION['status']; 
                unset($_SESSION['status']);
            ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <form action="edit-category-process.php" method="POST">
        <input type="hidden" name="id" value="<?php echo $category['id']; ?>">
        <div class="mb-3">
            <label for="name" class="form-label">Category Name</label>
            <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($category['name']); ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Update Category</button>
        <a href="categoryblogtag.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>
<?php
include('include/footer.php'); // Include header
?>
