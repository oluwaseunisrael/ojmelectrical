<?php
session_start();
include('includes/header.php');


// Check if the 'id' is provided in the URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch the estimate details based on the 'id'
    $sql = "SELECT * FROM estimates WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $estimate = mysqli_fetch_assoc($result);

    if (!$estimate) {
        echo "Estimate not found.";
        exit;
    }

    // Fetch service name based on service_id
    $service_sql = "SELECT title FROM services WHERE id = " . $estimate['service_id'];
    $service_result = mysqli_query($conn, $service_sql);
    $service_row = mysqli_fetch_assoc($service_result);
    $service_name = $service_row['title'];
} else {
    echo "Invalid request.";
    exit;
}
?>

<div class="container p-4">
    <h2>Estimate Details</h2>
    
    <div>
        <p><strong>Name:</strong> <?php echo htmlspecialchars($estimate['name']); ?></p>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($estimate['email']); ?></p>
        <p><strong>Phone:</strong> <?php echo htmlspecialchars($estimate['phone']); ?></p>
        <p><strong>Address:</strong> <?php echo nl2br(htmlspecialchars($estimate['address'])); ?></p>
        <p><strong>Service:</strong> <?php echo htmlspecialchars($service_name); ?></p>
        <p><strong>Details:</strong> <?php echo nl2br(htmlspecialchars($estimate['details'])); ?></p>
        <p><strong>Date Submitted:</strong> <?php echo date('Y-m-d H:i:s', strtotime($estimate['date_submitted'])); ?></p>
    </div>
</div>

<?php include('includes/footer.php'); ?>
