<?php
include('include/header.php');
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
  <title>OJM Product</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/shop.css">
  <!-- Font Awesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
<style>
  .shop-list-divider{
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 1.5rem;
  }
  @media(max-width:768px){
     .shop-list-divider{
    display: grid;
    grid-template-columns: repeat(1, 1fr);
    gap: 1.5rem;
  }
  }

.view-all-button {
    display: flex;
    justify-content: center;
    align-items: center;
    background-color: #007bff; /* Change to desired background color */
    border: none;
    padding: 10px 20px; /* Add padding for spacing */
    border-radius: 5px; /* Optional: for rounded corners */
    cursor: pointer;
}

.view-all-button a {
    color: white; /* Link text color */
    text-decoration: none; /* Remove underline from the link */
    font-size: 16px; /* Adjust font size */
}

.view-all-button:hover {
    background-color: #0056b3; /* Change background on hover */
}

</style>
</head>
<body style="background-color: #eee;">

<section>
  <div class="container py-5">
    <!-- Breadcrumb -->
    <div class="row">
      <div class="col">
        <nav aria-label="breadcrumb" class="bg-light rounded-3 p-3 mb-4">
          <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item"><a href="#">My Account</a></li>
            <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
          </ol>
        </nav>
      </div>
    </div>
<?php

if (isset($_SESSION['status'])) {
    echo "<p>" . $_SESSION['status'] . "</p>";
    unset($_SESSION['status']); // Clear the session message after displaying it
}
?>

    <div class="row">
      <!-- Sidebar -->
      <div class="col-lg-4">
        <div class="card mb-4">
          <div class="card-body text-center">
            <img src="uploads/<?php echo $rows['image']; ?>" alt="User Avatar"
              class="rounded-circle img-fluid mb-3" style="width: 150px;">
            <h5 class="mb-3"><?php echo $rows['name']; ?></h5>
            <p class="text-muted mb-1">OJM Member</p>
            <p class="text-muted mb-4"><?php echo $rows['city']; ?>, <?php echo $rows['country']; ?></p>
           <button class="btn btn-primary"><a href="edit-profile.php?name=<?php echo urlencode($rows['id']); ?>" style="text-decoration: none; color: white;">Edit Profile</a></button>

          </div>
        </div>
        <?php
    } else {
        // If no customer found, redirect to login page
        header("Location: login.php");
        exit;
    }
} else {
    // If not logged in, redirect to login page
    header("Location: login.php");
    exit;
}
?>
        <div class="card mb-4">
          <div class="card-body p-0">
            <ul class="list-group list-group-flush">
              <li class="list-group-item"><a href="order-item.php">Orders</a></li>
              <li class="list-group-item"><a href="#">Inbox</a></li>
              <li class="list-group-item"><a href="service-order.php">Services</a></li>
              <li class="list-group-item"><a href="#">Estimation quote</a></li>

              <li class="list-group-item"><a href="logout.php">Logout</a></li>
                            <li class="list-group-item"><a href="#">Followed Sellers</a></li>
              <li class="list-group-item"><a href="#">Recently Viewed</a></li>
            </ul>
          </div>
        </div>
      </div>

      <!-- Main Content -->
      <div class="col-lg-8">
        <!-- Orders Section -->
        <div class="card mb-4">
          <div class="card-body">
            <h5 class="mb-3">My Orders</h5>
            <div class="row mb-3">
              <div class="col-sm-6">
                <p class="text-muted">Order ID: <strong>12345</strong></p>
                <p class="text-muted">Date: <strong>Dec 1, 2024</strong></p>
                <p class="text-muted">Status: <strong>Shipped</strong></p>
              </div>
              <div class="col-sm-6 text-end">
                <button class="btn btn-sm btn-primary">Track Order</button>
                <button class="btn btn-sm btn-secondary">View Details</button>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-sm-6">
                <p class="text-muted">Order ID: <strong>12346</strong></p>
                <p class="text-muted">Date: <strong>Nov 20, 2024</strong></p>
                <p class="text-muted">Status: <strong>Delivered</strong></p>
              </div>
              <div class="col-sm-6 text-end">
                <button class="btn btn-sm btn-primary">Reorder</button>
                <button class="btn btn-sm btn-secondary">Leave Review</button>
              </div>
            </div>
          </div>
        </div>

        <!-- Recently Viewed Section -->
        <div class="card mb-4">
          <div class="card-body">
            <h5 class="mb-3">Recent Product</h5>
<?php
include "config/conn.php";
// Fetch 4 products (limit to 4)
$query = "SELECT * FROM product ORDER BY id desc LIMIT 4"; // Limiting to 4 products

$result = mysqli_query($conn, $query);
?>

<div class="shop-list">
    <div class="shop-list-divider">
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <div class="shop-list-divider-box">
                <div>
                    <img src="uploads/<?php echo htmlspecialchars($row['image']); ?>" alt="Product" style="max-width: 100%;">
                </div>
                <?php if ($row['sale_status'] == 1): ?>
                    <div class="sale">Sale</div>
                <?php endif; ?>
                <span>
                    <a href="single-shop.php?id=<?php echo $row['id']; ?>&name=<?php echo urlencode($row['product_name']); ?>" style="color:white; text-decoration: none;">
                        <i class="fas fa-cart-plus"></i> Add to Cart
                    </a>
                </span>
                <p class="price-name"><?php echo htmlspecialchars($row['product_name']); ?></p>
                <div class="price-tag d-flex justify-content-space-between">
                    <?php if (!empty($row['old_price']) && $row['old_price'] > 0): ?>
                        <div class="old-price"><?php echo "$" . htmlspecialchars($row['old_price']); ?></div>
                    <?php endif; ?>
                    <?php if (!empty($row['new_price']) && $row['new_price'] > 0): ?>
                        <div class="price"><?php echo "$" . htmlspecialchars($row['new_price']); ?></div>
                    <?php endif; ?>
                </div>
            </div>
        <?php endwhile; ?>
    </div>

</div>
   <button class="view-all-button"><a href="shop.php">View all</a></button>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php
include('include/footer.php');
?>
