<?php
include('config/conn.php');

session_start();

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $query = "SELECT * FROM customers WHERE id = $user_id";
    $query_run = mysqli_query($conn, $query);

    if (mysqli_num_rows($query_run) > 0) {
        $rows = mysqli_fetch_assoc($query_run);

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Get form data
            $name = $_POST['name'];
            $email = $_POST['email'];
            $phone = $_POST['phone'];
            $city = $_POST['city'];
            $country = $_POST['country'];

            // Handle image upload
            $image = $_FILES['image']['name'];
            $image_tmp = $_FILES['image']['tmp_name'];
            $image_size = $_FILES['image']['size'];
            $image_type = $_FILES['image']['type']; // Get MIME type of the uploaded file

            if ($image_size > 0) {
                // Check if image is larger than 2MB
                if ($image_size > 2 * 1024 * 1024) { // 2MB in bytes
                    $_SESSION['status'] = "Image size should not exceed 2MB.";
                    header("Location: profile.php");
                    exit;
                }

                // Check if file is a valid image (JPG, JPEG, PNG, GIF)
                $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
                if (!in_array($image_type, $allowed_types)) {
                    $_SESSION['status'] = "Invalid image type. Allowed types are JPG, JPEG, PNG, and GIF.";
                    header("Location: profile.php");
                    exit;
                }

                // If file is valid, upload it
                $image_extension = pathinfo($image, PATHINFO_EXTENSION);
                $new_image_name = time() . "." . $image_extension;
                $upload_dir = "uploads/";

                if (move_uploaded_file($image_tmp, $upload_dir . $new_image_name)) {
                    $_SESSION['status'] = "Image uploaded successfully.";
                } else {
                    $_SESSION['status'] = "Error uploading image.";
                    header("Location: profile.php");
                    exit;
                }
            } else {
                $new_image_name = $rows['image']; // Retain the old image if no new image is uploaded
            }

            // Update customer details
            $query_update = "UPDATE customers SET name = '$name', email = '$email', phone = '$phone', image = '$new_image_name', city = '$city', country = '$country' WHERE id = $user_id";
            if (mysqli_query($conn, $query_update)) {
                $_SESSION['status'] = "Profile updated successfully.";
                header("Location: dashboard.php"); // Redirect to dashboard page
                exit;
            } else {
                $_SESSION['status'] = "Error updating profile: " . mysqli_error($conn);
                header("Location: edit-profile.php");
                exit;
            }
        }
    } else {
        $_SESSION['status'] = "No user found.";
        header("Location: dashboard.php");
        exit;
    }
} else {
    $_SESSION['status'] = "User not logged in.";
    header("Location: login.php"); // Redirect to login page if user is not logged in
    exit;
}
?>
