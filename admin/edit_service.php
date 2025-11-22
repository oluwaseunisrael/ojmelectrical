<?php 
ob_start(); // Start output buffering
session_start(); // Start the session to access $_SESSION variables

include('includes/header.php'); // Include the header file

// Fetch the service details to edit
if (isset($_GET['id'])) {
    $service_id = $_GET['id'];
    $query = "SELECT * FROM services WHERE id = '$service_id'";
    $result = mysqli_query($conn, $query);
    $service = mysqli_fetch_assoc($result);
} else {
    // Redirect if ID is not provided
    header("Location: service-table.php");
    exit();
}

// Process the form submission for updating the service
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $subtitle = mysqli_real_escape_string($conn, $_POST['subtitle']);
    $content = mysqli_real_escape_string($conn, $_POST['content']);
    $benefit_content = mysqli_real_escape_string($conn, $_POST['benefit_content']);
    
    // Handle the first image upload
    $firstimage = $service['firstimage']; // Default to existing first image
    if (isset($_FILES['firstimage']) && $_FILES['firstimage']['error'] == 0) {
        $target_dir = "../uploads/";
        $firstimage = basename($_FILES["firstimage"]["name"]);
        move_uploaded_file($_FILES["firstimage"]["tmp_name"], $target_dir . $firstimage);
    }
    
    // Handle the 4 benefit images upload
    $benefit_images = [];
    for ($i = 1; $i <= 4; $i++) {
        if (isset($_FILES['benefit_image' . $i]) && $_FILES['benefit_image' . $i]['error'] == 0) {
            $target_dir = "../uploads/";
            $benefit_images[$i] = basename($_FILES["benefit_image" . $i]["name"]);
            move_uploaded_file($_FILES["benefit_image" . $i]["tmp_name"], $target_dir . $benefit_images[$i]);
        } else {
            $benefit_images[$i] = $service["benefit_image$i"]; // Keep existing images if not uploaded
        }
    }

    // Update the service in the database
    $update_query = "UPDATE services SET title = '$title', subtitle = '$subtitle', content = '$content', firstimage = '$firstimage', benefit_content = '$benefit_content', 
                    benefit_image1 = '{$benefit_images[1]}', benefit_image2 = '{$benefit_images[2]}', benefit_image3 = '{$benefit_images[3]}', 
                    benefit_image4 = '{$benefit_images[4]}'
                    WHERE id = '$service_id'";

    if (mysqli_query($conn, $update_query)) {
        $_SESSION['status'] = "Service updated successfully!";
        header("Location: service-table.php"); // Redirect after successful update
        exit();
    } else {
        $_SESSION['status'] = "Error updating service: " . mysqli_error($conn);
    }
}
?>

<div class="container mt-5">
    <h2 class="mb-4 text-center">Edit Service</h2>

    <?php if (isset($_SESSION['status'])): ?>
        <div class="alert alert-info"><?= $_SESSION['status']; unset($_SESSION['status']); ?></div>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data">
        <!-- Title and Subtitle -->
        <div class="form-row mb-3">
            <div class="form-group col-md-6">
                <label for="title">Title</label>
                <input type="text" class="form-control" name="title" value="<?= $service['title']; ?>" required>
            </div>
            <div class="form-group col-md-6">
                <label for="subtitle">Subtitle</label>
                <input type="text" class="form-control" name="subtitle" value="<?= $service['subtitle']; ?>" required>
            </div>
        </div>

        <!-- Content and Benefit Content -->
        <div class="form-row mb-3">
            <div class="form-group col-md-6">
                <label for="content">Content</label>
                <textarea class="form-control" name="content" required><?= $service['content']; ?></textarea>
            </div>
            <div class="form-group col-md-6">
                <label for="benefit_content">Benefit Content</label>
                <textarea class="form-control" name="benefit_content" required><?= $service['benefit_content']; ?></textarea>
            </div>
        </div>

        <!-- Image Uploads Section -->
        <div class="form-row mb-3">
            <!-- First Image -->
            <div class="form-group col-md-6">
                <label for="firstimage">First Image</label>
                <input type="file" class="form-control" name="firstimage">
                <?php if ($service['firstimage']): ?>
                    <img src="../uploads/<?= $service['firstimage']; ?>" width="100" alt="First Image" class="mt-2">
                <?php endif; ?>
            </div>

            <!-- Benefit Images -->
            <?php for ($i = 1; $i <= 4; $i++): ?>
                <div class="form-group col-md-6">
                    <label for="benefit_image<?= $i ?>">Benefit Image <?= $i ?></label>
                    <input type="file" class="form-control" name="benefit_image<?= $i ?>">
                    <?php if ($service["benefit_image$i"]): ?>
                        <img src="../uploads/<?= $service["benefit_image$i"]; ?>" width="100" alt="Benefit Image <?= $i ?>" class="mt-2">
                    <?php endif; ?>
                </div>
            <?php endfor; ?>
        </div>

        <div class="text-center">
            <button type="submit" class="btn btn-primary btn-lg">Update Service</button>
        </div>
    </form>
</div>

<?php 
include('includes/footer.php');
ob_end_flush(); // End output buffering and flush output
?>
