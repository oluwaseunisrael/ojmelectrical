<?php
include('include/header.php');
session_start();

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $query = "SELECT * FROM customers WHERE id = $user_id";
    $query_run = mysqli_query($conn, $query);

    if (mysqli_num_rows($query_run) > 0) {
        $user = mysqli_fetch_assoc($query_run);
    } else {
        header("Location: login.php");
        exit;
    }
} else {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Order Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .progress {
        height: 20px;
        border-radius: 10px;
        background-color: #e9ecef;
    }
    .progress-bar {
        height: 100%;
        line-height: 20px;
        color: white;
        text-align: center;
        font-size: 12px;
    }
    .order-card {
        margin-bottom: 20px;
        padding: 20px;
        border: 1px solid #ddd;
        border-radius: 10px;
        background: #fff;
    }
    .order-card h6 {
        font-size: 16px;
        margin-bottom: 10px;
    }
    .order-card p {
        margin-bottom: 5px;
        font-size: 14px;
    }
    .action-buttons button {
        margin-right: 10px;
    }
  </style>
</head>
<body style="background-color: #f8f9fa;">

<div class="container py-5">
  <div class="row">
    <div class="col-lg-4">
      <div class="card mb-4">
        <div class="card-body text-center">
          <img src="uploads/<?php echo $user['image']; ?>" alt="User Avatar" class="rounded-circle img-fluid mb-3" style="width: 150px;">
          <h5><?php echo $user['name']; ?></h5>
          <p class="text-muted">OJM Member</p>
          <button class="btn btn-primary">
            <a href="edit-profile.php?name=<?php echo urlencode($user['id']); ?>" style="color: white; text-decoration: none;">Edit Profile</a>
          </button>
        </div>
      </div>
      <div class="card">
        <div class="card-body p-0">
          <ul class="list-group list-group-flush">
            <li class="list-group-item"><a href="order-item.php">Orders</a></li>
            <li class="list-group-item"><a href="#">Inbox</a></li>
            <li class="list-group-item"><a href="service-order.php">Services</a></li>
            <li class="list-group-item"><a href="#">Estimation Quote</a></li>
            <li class="list-group-item"><a href="logout.php">Logout</a></li>
          </ul>
        </div>
      </div>
    </div>

    <div class="col-lg-8">
      <h3 class="mb-4">Order Status</h3>
      <?php
      $order_query = "SELECT * FROM orders WHERE customer_id = $user_id ORDER BY order_date DESC";
      $order_run = mysqli_query($conn, $order_query);

      if (mysqli_num_rows($order_run) > 0) {
          while ($order = mysqli_fetch_assoc($order_run)) {
              $progress = 0;
              $progress_bar_class = 'bg-secondary'; // Default color for unknown statuses

              // Adjust the progress and bar color based on order_status
              switch ($order['order_status']) {
                  case 'Pending':
                      $progress = 25;
                      $progress_bar_class = 'bg-warning'; // Yellow for Pending
                      break;
                  case 'Processing':
                      $progress = 50;
                      $progress_bar_class = 'bg-info'; // Blue for Processing
                      break;
                  case 'Shipped':
                      $progress = 75;
                      $progress_bar_class = 'bg-primary'; // Blue for Shipped
                      break;
                  case 'Delivered':
                      $progress = 100;
                      $progress_bar_class = 'bg-success'; // Green for Delivered
                      break;
                  case 'Cancelled':
                      $progress = 0;
                      $progress_bar_class = 'bg-danger'; // Red for Cancelled
                      break;
              }
      ?>

      <div class="order-card">
        <h6>Order ID: <?php echo $order['order_id']; ?></h6>
        <p>Date: <?php echo date('F j, Y', strtotime($order['order_date'])); ?></p>
        <p>Status: <strong><?php echo $order['order_status']; ?></strong></p>
        <div class="progress mb-3">
          <div class="progress-bar <?php echo $progress_bar_class; ?>" role="progressbar" style="width: <?php echo $progress; ?>%;" aria-valuenow="<?php echo $progress; ?>" aria-valuemin="0" aria-valuemax="100">
            <?php echo $progress; ?>%
          </div>
        </div>
        
        <div class="action-buttons">
            <!-- View Details Button -->
            <a href="view-order-details.php?order_id=<?php echo $order['order_id']; ?>" class="btn btn-sm btn-primary">View Details</a>
            
            <!-- Cancel Order Button -->
            <?php if ($order['order_status'] != 'Cancelled' && $order['order_status'] != 'Delivered') { ?>
                <a href="cancel-order.php?order_id=<?php echo $order['order_id']; ?>" class="btn btn-sm btn-danger">Cancel Order</a>
            <?php } ?>

            <!-- Delete Order Button -->
            <?php if ($order['order_status'] == 'Cancelled' || $order['order_status'] == 'Delivered') { ?>
                <a href="delete-order.php?order_id=<?php echo $order['order_id']; ?>" class="btn btn-sm btn-warning">Delete Order</a>
            <?php } ?>
        </div>
      </div>

      <?php
          }
      } else {
          echo "<p>No orders found.</p>";
      }
      ?>
    </div>
  </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
