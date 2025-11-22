<?php 
session_start();
include('includes/header.php'); // Include header
include "../config/conn.php";

// Get and validate the tag ID
$id = intval($_GET['id'] ?? 0);
$sql = "SELECT * FROM tags WHERE id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$tag = mysqli_fetch_assoc($result);

// Redirect if the tag is not found
if (!$tag) {
    $_SESSION['status'] = "Tag not found.";
    $_SESSION['status_type'] = "danger";
    header("Location: categoryblogtag.php");
    exit();
}
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-lg">
                <div class="card-header bg-warning text-white text-center">
                    <h4>Edit Tag</h4>
                </div>
                <div class="card-body">
                    <!-- Display Success/Error Message -->
                    <?php if (isset($_SESSION['status'])): ?>
                        <div class="alert alert-<?php echo $_SESSION['status_type'] ?? 'info'; ?> alert-dismissible fade show" role="alert">
                            <?php 
                                echo htmlspecialchars($_SESSION['status'], ENT_QUOTES, 'UTF-8'); 
                                unset($_SESSION['status'], $_SESSION['status_type']);
                            ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <!-- Edit Tag Form -->
                    <form action="edit-tags-process.php" method="POST">
                        <input type="hidden" name="id" value="<?php echo $tag['id']; ?>">
                        <div class="mb-4">
                            <label for="tagName" class="form-label">Tag Name</label>
                            <input 
                                type="text" 
                                class="form-control" 
                                id="tagName" 
                                name="name" 
                                value="<?php echo htmlspecialchars($tag['name'], ENT_QUOTES, 'UTF-8'); ?>" 
                                required
                                maxlength="50"
                            >
                            <small class="form-text text-muted">Ensure the tag name is unique and descriptive.</small>
                        </div>
                        <div class="d-flex justify-content-between">
                            <a href="categoryblogtag.php" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-warning text-white">Update Tag</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>
