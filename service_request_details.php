<?php
include('include/header.php');
session_start();

if (isset($_GET['order_id'])) {
    $order_id = $_GET['order_id'];

    // Fetch service request data
    $query = "SELECT sr.*, s.title AS service_name 
              FROM service_request sr
              LEFT JOIN services s ON sr.service = s.id 
              WHERE sr.id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $order_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $order = mysqli_fetch_assoc($result);
    
    if ($order) {
        $country = $order['country'];
        $state = $order['state'];
        $city = $order['city'];
        $address = $order['address'];
        $service = $order['service_name']; // Fetch service name instead of ID
        $fullname = $order['fullname'];
        $email = $order['email'];
        $phone = $order['phone'];
        $job_start_date = $order['job_start_date'];
        $service_description = $order['service_description'];
        $readiness_to_hire = $order['readiness_to_hire'];
        $service_image = $order['service_image'];
    } else {
        echo "Service request not found.";
        exit;
    }
}

?>

<!-- Modernized Service Request Details Page -->
<div class="container mt-5">
    <div class="card shadow-lg border-0">
        <div class="card-header bg-primary text-white text-center">
            <h3>Service Request Details</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <h5><strong>Service:</strong></h5>
                    <p><?php echo htmlspecialchars($service); ?></p>
                </div>
                <div class="col-md-6 mb-3">
                    <h5><strong>Full Name:</strong></h5>
                    <p><?php echo htmlspecialchars($fullname); ?></p>
                </div>
                <div class="col-md-6 mb-3">
                    <h5><strong>Email:</strong></h5>
                    <p><?php echo htmlspecialchars($email); ?></p>
                </div>
                <div class="col-md-6 mb-3">
                    <h5><strong>Phone:</strong></h5>
                    <p><?php echo htmlspecialchars($phone); ?></p>
                </div>
                <div class="col-md-12 mb-3">
                    <h5><strong>Address:</strong></h5>
                    <p><?php echo htmlspecialchars($address) . ', ' . htmlspecialchars($city) . ', ' . htmlspecialchars($state) . ', ' . htmlspecialchars($country); ?></p>
                </div>
                <div class="col-md-6 mb-3">
                    <h5><strong>Job Start Date:</strong></h5>
                    <p><?php echo htmlspecialchars($job_start_date); ?></p>
                </div>
                <div class="col-md-6 mb-3">
                    <h5><strong>Readiness to Hire:</strong></h5>
                    <p><?php echo htmlspecialchars($readiness_to_hire ?: 'Not specified'); ?></p>
                </div>
                <div class="col-md-12 mb-3">
                    <h5><strong>Service Description:</strong></h5>
                    <p><?php echo nl2br(htmlspecialchars($service_description)); ?></p>
                </div>
                <?php if ($service_image): ?>
                <div class="col-md-12 mb-3 text-center">
                    <img src="<?php echo htmlspecialchars($service_image); ?>" alt="Service Image" class="img-fluid rounded shadow-sm" style="max-height: 300px;">
                </div>
                <?php endif; ?>
            </div>
        </div>
        <div class="card-footer text-center">
            <a href="service_request_form.php" class="btn btn-outline-primary">
                <i class="fas fa-arrow-left"></i> Back to My Orders
            </a>
        </div>
    </div>
</div>
