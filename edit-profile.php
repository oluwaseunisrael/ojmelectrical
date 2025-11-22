<?php
include('include/header.php');
?>
<?php
session_start();

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $query = "SELECT * FROM customers WHERE id = $user_id";
    $query_run = mysqli_query($conn, $query);

    if (mysqli_num_rows($query_run) > 0) {
        $rows = mysqli_fetch_assoc($query_run);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Profile</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/shop.css">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>
<body style="background-color: #f8f9fa;">

<section>
  <div class="container py-5">
    <h2 class="mb-4">Edit Profile</h2>
    <form action="update-profile.php" method="POST" enctype="multipart/form-data">
      <div class="row mb-3">
        <div class="col-md-6">
          <label for="name" class="form-label">Full Name</label>
          <input type="text" class="form-control" id="name" name="name" value="<?php echo $rows['name']; ?>" required>
        </div>
        <div class="col-md-6">
          <label for="email" class="form-label">Email</label>
          <input type="email" class="form-control" id="email" name="email" value="<?php echo $rows['email']; ?>" required>
        </div>
      </div>
      
      <div class="row mb-3">
        <div class="col-md-6">
          <label for="phone" class="form-label">Phone</label>
          <input type="text" class="form-control" id="phone" name="phone" value="<?php echo $rows['phone']; ?>" required>
        </div>
        <div class="col-md-6">
          <label for="city" class="form-label">City</label>
          <input type="text" class="form-control" id="city" name="city" value="<?php echo $rows['city']; ?>" required>
        </div>
      </div>

      <div class="row mb-3">
        <div class="col-md-6">
          <label for="country" class="form-label">Country</label>
          <input type="text" class="form-control" id="country" name="country" value="<?php echo $rows['country']; ?>" required>
        </div>
        <div class="col-md-6">
          <label for="image" class="form-label">Profile Image</label>
          <input type="file" class="form-control" id="image" name="image">
        </div>
      </div>

      <button type="submit" class="btn btn-primary">Save Changes</button>
    </form>
  </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
    } else {
        echo "No user found.";
    }
} else {
    echo "User not logged in.";
}
?>
<?php
include('include/footer.php');
?>
