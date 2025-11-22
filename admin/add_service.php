<?php 
session_start(); // Start the session to access $_SESSION variables

include('includes/header.php'); // Include the header file

// Process the form submission for adding a service
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize the inputs
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $subtitle = mysqli_real_escape_string($conn, $_POST['subtitle']);
    $content = mysqli_real_escape_string($conn, $_POST['content']);
    $benefit_content = mysqli_real_escape_string($conn, $_POST['benefit_content']);
    
    // Handle the first image upload
    $firstimage = '';
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
        }
    }

    // Insert data into the database
    $insert_query = "INSERT INTO services (title, subtitle, content, firstimage, benefit_content, benefit_image1, benefit_image2, benefit_image3, benefit_image4)
                     VALUES ('$title', '$subtitle', '$content', '$firstimage', '$benefit_content', 
                             '{$benefit_images[1]}', '{$benefit_images[2]}', '{$benefit_images[3]}', '{$benefit_images[4]}')";

    if (mysqli_query($conn, $insert_query)) {
        $_SESSION['status'] = "Service added successfully!";
        header("Location: service-table.php");
    } else {
        $_SESSION['status'] = "Error adding service: " . mysqli_error($conn);
    }
}
?>

<div class="container mt-5">
    <h2 class="mb-4">Add Service</h2>

    <?php if (isset($_SESSION['status'])): ?>
        <div class="alert alert-info"><?= $_SESSION['status']; unset($_SESSION['status']); ?></div>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data">
        <!-- Title Input -->
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" class="form-control" name="title" required>
        </div>

        <!-- Subtitle Input -->
        <div class="form-group">
            <label for="subtitle">Subtitle</label>
            <input type="text" class="form-control" name="subtitle" required>
        </div>

        <!-- First Image Upload -->
        <div class="form-group">
            <label for="firstimage">First Image</label>
            <input type="file" class="form-control" name="firstimage" required>
        </div>

        <!-- Content Input -->
        <div class="form-group">
            <label for="content">Content</label>
            <textarea class="form-control" name="content" required></textarea>
        </div>

        <!-- Benefit Content Input -->
        <div class="form-group">
            <label for="benefit_content">Benefit Content</label>
            <textarea class="form-control" name="benefit_content" required></textarea>
        </div>

        <!-- Benefit Image 1 Upload -->
        <div class="form-group">
            <label for="benefit_image1">Benefit Image 1</label>
            <input type="file" class="form-control" name="benefit_image1">
        </div>

        <!-- Benefit Image 2 Upload -->
        <div class="form-group">
            <label for="benefit_image2">Benefit Image 2</label>
            <input type="file" class="form-control" name="benefit_image2">
        </div>

        <!-- Benefit Image 3 Upload -->
        <div class="form-group">
            <label for="benefit_image3">Benefit Image 3</label>
            <input type="file" class="form-control" name="benefit_image3">
        </div>

        <!-- Benefit Image 4 Upload -->
        <div class="form-group">
            <label for="benefit_image4">Benefit Image 4</label>
            <input type="file" class="form-control" name="benefit_image4">
        </div>

        <!-- Submit Button -->
        <button type="submit" class="btn btn-success">Add Service</button>
    </form>
</div>

<?php 
include('includes/footer.php');
?>
