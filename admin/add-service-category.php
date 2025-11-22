<?php
session_start(); // Start the session to access $_SESSION variables

include('include/header.php'); 

// Check if we are editing an existing category
$category_id = isset($_GET['id']) ? $_GET['id'] : null;
$category_name = "";

// If editing, fetch the current category data
if ($category_id) {
    $query = "SELECT * FROM service_categories WHERE id = '$category_id'";
    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result) > 0) {
        $category = mysqli_fetch_assoc($result);
        $category_name = $category['name'];
    }
}
?>

<!-- Form to add/edit service categories -->
<form action="save_category.php" method="POST">
    <input type="hidden" name="id" value="<?= $category_id; ?>" />
    <div class="mb-3">
        <label for="name" class="form-label">Category Name</label>
        <input type="text" class="form-control" id="name" name="name" value="<?= $category_name; ?>" required>
    </div>
    <button type="submit" class="btn btn-primary"><?= $category_id ? "Update" : "Add"; ?> Category</button>
</form>
<?php
include('include/footer.php'); ?>