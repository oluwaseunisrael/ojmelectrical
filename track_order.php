<?php
include('include/header.php');
session_start();

if (isset($_GET['order_id'])) {
    $order_id = $_GET['order_id'];

    // Fetch service request data
    $query = "SELECT * FROM service_request WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $order_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $order = mysqli_fetch_assoc($result);

    if ($order) {
        $status = $order['status'];
        $progress = $order['progress'];
    } else {
        echo "<div class='alert alert-danger'>Service request not found.</div>";
        exit;
    }
}
?>

<!-- Track Order Page -->
<div class="container mt-5">
    <div class="card shadow-lg border-0">
        <div class="card-body">
            <h3 class="card-title mb-4">Track Service Request #<?php echo htmlspecialchars($order_id); ?></h3>
            
            <!-- Service Details Section -->
            <div class="row mb-4">
                <div class="col-md-6">
                    <p class="text-muted">Status: <strong><?php echo htmlspecialchars($status); ?></strong></p>
                    <p class="text-muted">Progress: <strong><?php echo htmlspecialchars($progress); ?>%</strong></p>
                </div>
                <div class="col-md-6 text-md-end">
                    <!-- Modern button styles -->
                    <button class="btn btn-outline-primary btn-sm">Track Progress</button>
                    <button class="btn btn-outline-secondary btn-sm">Contact Support</button>
                </div>
            </div>

            <!-- Service Status Description -->
            <div class="mb-3">
                <?php if ($status == 'Completed'): ?>
                    <div class="alert alert-success">Your service request has been completed successfully!</div>
                <?php elseif ($status == 'In Progress'): ?>
                    <div class="alert alert-primary">Your service request is in progress. We will notify you once it's complete.</div>
                     <?php elseif ($status == 'cancelled'): ?>
                    <div class="alert alert-danger">Your service request as been cancelled. </div>
                <?php else: ?>
                    <div class="alert alert-info">Your service request is still pending. Stay tuned for updates.</div>
                <?php endif; ?>
            </div>

            <!-- Navigation Button -->
            <a href="service-order.php" class="btn btn-primary btn-lg">Back to My Orders</a>
        </div>
    </div>
</div>

<!-- Custom CSS for modern design -->
<style>
    .container {
        max-width: 900px;
    }

    .card {
        border-radius: 15px;
    }

    .card-body {
        padding: 30px;
    }

    .card-title {
        font-size: 24px;
        font-weight: 600;
    }

    .btn-outline-primary, .btn-outline-secondary {
        margin-top: 5px;
    }

    .btn-lg {
        padding: 12px 25px;
    }

    .alert {
        font-size: 1rem;
    }

    /* Add shadow effect to the container for depth */
    .card-shadow-lg {
        
    }
</style>
<?php
include('include/footer.php');
?>