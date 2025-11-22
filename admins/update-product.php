<?php
session_start();
include('include/header.php');

// Check if `id` is provided
if (!isset($_GET['id'])) {
    $_SESSION['status'] = "Invalid request.";
    header("Location: product-table-sale.php");
    exit;
}

$product_id = intval($_GET['id']);
$query = "SELECT * FROM product WHERE id = $product_id";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) === 0) {
    $_SESSION['status'] = "Product not found.";
    header("Location: product-table-sale.php");
    exit;
}

$product = mysqli_fetch_assoc($result);

// Fetch categories for dropdown
$categoryQuery = "SELECT * FROM product_category";
$categoryResult = mysqli_query($conn, $categoryQuery);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_name = mysqli_real_escape_string($conn, $_POST['product_name']);
    $product_description = mysqli_real_escape_string($conn, $_POST['product_description']);
    $short_content = mysqli_real_escape_string($conn, $_POST['short_content']);
    $new_price = floatval($_POST['new_price']);
    $old_price = isset($_POST['old_price']) ? floatval($_POST['old_price']) : null;
    $category_id = intval($_POST['category_id']);
    $type_one = mysqli_real_escape_string($conn, $_POST['type_one']);
    $type_two = mysqli_real_escape_string($conn, $_POST['type_two']);
    $type_three = mysqli_real_escape_string($conn, $_POST['type_three']);
    $type_four = mysqli_real_escape_string($conn, $_POST['type_four']);
    $sale_status = mysqli_real_escape_string($conn, $_POST['sale_status']);

    $image_path = $product['image']; // Default to existing image

    // Handle image upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $allowed_types = ['image/jpeg', 'image/png'];
        $max_size = 2 * 1024 * 1024;

        $file_tmp = $_FILES['image']['tmp_name'];
        $file_type = $_FILES['image']['type'];
        $file_size = $_FILES['image']['size'];

        if (!in_array($file_type, $allowed_types) || $file_size > $max_size) {
            $_SESSION['status'] = "Invalid file type or size.";
            header("Location: edit-product-sale.php?id=$product_id");
            exit();
        }

        $upload_dir = '../uploads/';
        if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);

        $file_dest = $upload_dir . uniqid() . '_' . basename($_FILES['image']['name']);
        if (move_uploaded_file($file_tmp, $file_dest)) {
            $image_path = $file_dest;
        }
    }

    $updateQuery = "UPDATE product SET
        product_name = '$product_name', product_description = '$product_description', short_content = '$short_content',
        new_price = $new_price, old_price = $old_price, image = '$image_path', sale_status = '$sale_status',
        type_one = '$type_one', type_two = '$type_two', type_three = '$type_three', type_four = '$type_four',
        category_id = $category_id
    WHERE id = $product_id";

    if (mysqli_query($conn, $updateQuery)) {
        $_SESSION['status'] = "Product updated successfully!";
    } else {
        $_SESSION['status'] = "Error updating product: " . mysqli_error($conn);
    }

    header("Location: product-table-sale.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <link rel="stylesheet" href="path/to/bootstrap.css"> <!-- Update with actual Bootstrap CSS file -->
</head>
<body>
<div class="container mt-5">
    <h2>Edit Product</h2>

    <!-- Display Session Message -->
    <?php if (isset($_SESSION['status'])): ?>
        <div class="alert alert-info"><?php echo $_SESSION['status']; unset($_SESSION['status']); ?></div>
    <?php endif; ?>

    <form method="POST" action="update-product.php?id=<?php echo $product_id; ?>" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="product_name" class="form-label">Product Name</label>
            <input type="text" class="form-control" id="product_name" name="product_name" 
                value="<?php echo htmlspecialchars($product['product_name']); ?>" required>
        </div>

        <div class="mb-3">
            <label for="product_description" class="form-label">Product Description</label>
            <textarea class="form-control" id="product_description" name="product_description" rows="3"><?php echo htmlspecialchars($product['product_description']); ?></textarea>
        </div>

        <div class="mb-3">
            <label for="short_content" class="form-label">Short Content</label>
            <input type="text" class="form-control" id="short_content" name="short_content" 
                value="<?php echo htmlspecialchars($product['short_content']); ?>">
        </div>

        <div class="mb-3">
            <label for="new_price" class="form-label">New Price</label>
            <input type="number" step="0.01" class="form-control" id="new_price" name="new_price" 
                value="<?php echo htmlspecialchars($product['new_price']); ?>">
        </div>

        <div class="mb-3">
            <label for="old_price" class="form-label">Old Price</label>
            <input type="number" step="0.01" class="form-control" id="old_price" name="old_price" 
                value="<?php echo htmlspecialchars($product['old_price']); ?>">
        </div>

        <div class="mb-3">
            <label for="category_id" class="form-label">Category</label>
            <select class="form-select" id="category_id" name="category_id" required>
                <?php while ($category = mysqli_fetch_assoc($categoryResult)): ?>
                    <option value="<?php echo $category['id']; ?>" 
                        <?php echo ($category['id'] == $product['category_id']) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($category['category_name']); ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="type_one" class="form-label">Type One</label>
            <input type="text" class="form-control" id="type_one" name="type_one" 
                value="<?php echo htmlspecialchars($product['type_one']); ?>">
        </div>

        <div class="mb-3">
            <label for="type_two" class="form-label">Type Two</label>
            <input type="text" class="form-control" id="type_two" name="type_two" 
                value="<?php echo htmlspecialchars($product['type_two']); ?>">
        </div>

        <div class="mb-3">
            <label for="type_three" class="form-label">Type Three</label>
            <input type="text" class="form-control" id="type_three" name="type_three" 
                value="<?php echo htmlspecialchars($product['type_three']); ?>">
        </div>

        <div class="mb-3">
            <label for="type_four" class="form-label">Type Four</label>
            <input type="text" class="form-control" id="type_four" name="type_four" 
                value="<?php echo htmlspecialchars($product['type_four']); ?>">
        </div>

        <div class="mb-3">
            <label for="sale_status" class="form-label">Sale Status</label>
            <select class="form-select" id="sale_status" name="sale_status">
                <option value="1" <?php echo ($product['sale_status'] == '1') ? 'selected' : ''; ?>>Sale</option>
                <option value="0" <?php echo ($product['sale_status'] == '0') ? 'selected' : ''; ?>>Unsale</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="image" class="form-label">Product Image</label>
            <input type="file" class="form-control" id="image" name="image">
            <!-- Show current image -->
            <?php if (!empty($product['image'])): ?>
                <img src="<?php echo htmlspecialchars($product['image']); ?>" alt="Product Image" class="img-thumbnail mt-2" style="max-width: 150px;">
            <?php endif; ?>
        </div>

        <button type="submit" class="btn btn-primary">Update Product</button>
        <a href="product-table-sale.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>
</body>
</html>
