<?php 
session_start();
include('include/header.php'); // Include header

include "../config/conn.php";

$id = intval($_GET['id']); // Get the category ID from URL
$sql = "SELECT * FROM tags WHERE id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$tag = mysqli_fetch_assoc($result);

if (!$tag) {
    $_SESSION['status'] = "Tags not found.";
    header("Location: categoryblogtag.php");
    exit();
}
?>
<div class="container mt-5">
    <h2>Edit tag</h2>

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

    <form action="edit-tags-process.php" method="POST">
        <input type="hidden" name="id" value="<?php echo $tag['id']; ?>">
        <div class="mb-3">
            <label for="name" class="form-label">tag Name</label>
            <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($tag['name']); ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Update tag</button>
        <a href="categoryblogtag.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>
<?php
include('include/footer.php'); // Include header
?>
