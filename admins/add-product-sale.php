<?php
session_start();
include('include/header.php');

// Fetch categories for the select dropdown
$categoryQuery = "SELECT * FROM product_category";
$categoryResult = mysqli_query($conn, $categoryQuery);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form values
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

    // Handle file upload
    $image_path = null; // Default is no image

    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        // Allowed MIME types and max size for image upload
        $allowed_types = ['image/jpeg', 'image/png'];
        $max_size = 2 * 1024 * 1024; // 2MB size limit

        $file_tmp = $_FILES['image']['tmp_name'];
        $file_type = $_FILES['image']['type'];
        $file_size = $_FILES['image']['size'];

        // Validate image file type
        if (!in_array($file_type, $allowed_types)) {
            $_SESSION['status'] = "Invalid file type. Only JPG and PNG images are allowed.";
            header("Location: add-product-sale.php");
            exit();
        }

        // Validate file size
        if ($file_size > $max_size) {
            $_SESSION['status'] = "File size is too large. Maximum allowed size is 2MB.";
            header("Location: add-product-sale.php");
            exit();
        }

        // Define the upload directory and create it if necessary
        $upload_dir = '../uploads/';
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        // Generate unique file name to avoid overwriting existing files
        $file_name = basename($_FILES['image']['name']);
        $file_dest = $upload_dir . uniqid() . '_' . $file_name;

        // Move uploaded file to the target directory
        if (move_uploaded_file($file_tmp, $file_dest)) {
            $image_path = $file_dest;
        } else {
            $_SESSION['status'] = "Error uploading the file.";
            header("Location: Location:add-product-sale.php");
            exit();
        }
    }

    // Insert the new product into the database
    $query = "INSERT INTO product (
        product_name, product_description, short_content, new_price, old_price, 
        image, sale_status, type_one, type_two, type_three, type_four, category_id
    ) VALUES (
        '$product_name', '$product_description', '$short_content', $new_price, 
        $old_price, '$image_path', '$sale_status', '$type_one', '$type_two', 
        '$type_three', '$type_four', $category_id
    )";

    if (mysqli_query($conn, $query)) {
        $_SESSION['status'] = "Product added successfully!";
    } else {
        $_SESSION['status'] = "Error adding product: " . mysqli_error($conn);
    }

    header("Location:product-table-sale.php");
    exit;
}
?>


<div class="container mt-5">
    <h2>Add New Product</h2>

    <!-- Display Session Message -->
    <?php if (isset($_SESSION['status'])): ?>
        <div class="alert alert-info"><?php echo $_SESSION['status']; unset($_SESSION['status']); ?></div>
    <?php endif; ?>

    <form method="POST" action="add-product-sale.php" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="product_name" class="form-label">Product Name</label>
            <input type="text" class="form-control" id="product_name" name="product_name" required>
        </div>

        <div class="mb-3">
            <label for="product_description" class="form-label">Product Description</label>
            <textarea class="form-control" id="product_description" name="product_description" rows="3"></textarea>
        </div>

        <div class="mb-3">
            <label for="short_content" class="form-label">Short Content</label>
            <input type="text" class="form-control" id="short_content" name="short_content">
        </div>

        <div class="mb-3">
            <label for="new_price" class="form-label">New Price</label>
            <input type="number" step="0.01" class="form-control" id="new_price" name="new_price" required>
        </div>

        <div class="mb-3">
            <label for="old_price" class="form-label">Old Price</label>
            <input type="number" step="0.01" class="form-control" id="old_price" name="old_price">
        </div>

        <div class="mb-3">
            <label for="category_id" class="form-label">Category</label>
            <select class="form-select" id="category_id" name="category_id" required>
                <?php while ($category = mysqli_fetch_assoc($categoryResult)): ?>
                    <option value="<?php echo $category['id']; ?>"><?php echo $category['category_name']; ?></option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="type_one" class="form-label">Type One</label>
            <input type="text" class="form-control" id="type_one" name="type_one">
        </div>

        <div class="mb-3">
            <label for="type_two" class="form-label">Type Two</label>
            <input type="text" class="form-control" id="type_two" name="type_two">
        </div>

        <div class="mb-3">
            <label for="type_three" class="form-label">Type Three</label>
            <input type="text" class="form-control" id="type_three" name="type_three">
        </div>

        <div class="mb-3">
            <label for="type_four" class="form-label">Type Four</label>
            <input type="text" class="form-control" id="type_four" name="type_four">
        </div>

        <div class="mb-3">
            <label for="sale_status" class="form-label">Sale Status</label>
            <select class="form-select" id="sale_status" name="sale_status">
                <option value="1">Sale</option>
                <option value="0">unsale</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="image" class="form-label">Product Image</label>
            <input type="file" class="form-control" id="image" name="image" required>
        </div>

        <button type="submit" class="btn btn-primary">Add Product</button>
    </form>
</div>
</body>
</html>
