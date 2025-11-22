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
            .shop-list-divider {
              display: grid;
              grid-template-columns: repeat(2, 1fr);
              gap: 1.5rem;
            }
            @media(max-width:768px) {
              .shop-list-divider {
                display: grid;
                grid-template-columns: repeat(1, 1fr);
                gap: 1.5rem;
              }
            }
            .view-all-button {
                display: flex;
                justify-content: center;
                align-items: center;
                background-color: #007bff; 
                border: none;
                padding: 10px 20px;
                border-radius: 5px; 
                cursor: pointer;
            }

            .view-all-button a {
                color: white; 
                text-decoration: none; 
                font-size: 16px;
            }

            .view-all-button:hover {
                background-color: #0056b3; 
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
              <!-- Sidebar (Restored) -->
              <div class="col-lg-4">
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
                    <h5 class="mb-3">My Service Requests</h5>

                    <?php
                    // Assuming customer email is stored in session
                    $customer_email = $_SESSION['user_email'];  // Get logged-in customer email

                    // Query to fetch service requests for the customer based on email
                    $sql = "SELECT * FROM service_request WHERE email = ?";
                    $stmt = mysqli_prepare($conn, $sql);
                    mysqli_stmt_bind_param($stmt, "s", $customer_email);
                    mysqli_stmt_execute($stmt);
                    $result = mysqli_stmt_get_result($stmt);

                    // Check if there are any service requests
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            $order_id = $row['id'];
                            $service = $row['service'];
                            $date = $row['created_at'];
                            $status = $row['status'];  // The status of the service request
                            $progress = $row['progress'];  // The progress percentage
                            ?>
                            <div class="row mb-3">
                                <div class="col-sm-6">
                                    <p class="text-muted">Order ID: <strong><?php echo $order_id; ?></strong></p>
                                    <p class="text-muted">Date: <strong><?php echo date("M d, Y", strtotime($date)); ?></strong></p>
                                    <p class="text-muted">Status: <strong><?php echo $status; ?></strong></p>

                                    <!-- Display Progress Bar -->
                                    <div class="progress" style="height: 20px;">
                                        <div class="progress-bar" role="progressbar" style="width: <?php echo $progress; ?>%;" aria-valuenow="<?php echo $progress; ?>" aria-valuemin="0" aria-valuemax="100">
                                            <?php echo $progress; ?>%
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 text-end">
                                    <!-- Edit and Delete Buttons -->
  


                                   <form action="service-edit-delete.php" method="POST" onsubmit="return confirm('Are you sure you want to delete this order?');">
    <input type="hidden" name="service_id" value="<?php echo $order_id; ?>
"> 
    <button type="submit" class="btn btn-sm btn-danger">Delete Order</button>
</form>

                                    <button class="btn btn-sm btn-primary" onclick="window.location.href='track_order.php?order_id=<?php echo $order_id; ?>'">Track Order</button>
                                    <button class="btn btn-sm btn-secondary" onclick="window.location.href='service_request_details.php?order_id=<?php echo $order_id; ?>'">View Details</button>
                                </div>
                            </div>
                            <hr>
                        <?php
                        }
                    } else {
                        echo "<p>You have no service order now.</p>";
                    }
                    ?>
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
    }
}
include('include/footer.php');
?>
