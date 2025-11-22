<?php
session_start();
ob_start();  // Start output buffering

include('includes/header.php');

// Check if the 'id' is provided
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch the service request details along with the service title from the 'services' table
    $sql = "
        SELECT sr.*, s.title AS service_title 
        FROM service_request sr
        LEFT JOIN services s ON sr.service = s.id
        WHERE sr.id = ?
    ";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);

    if (!$row) {
        echo "No service request found.";
        exit;
    }

    // Debugging: Print the array to see the keys
    // echo "<pre>";
    // print_r($row);
    // echo "</pre>";

} else {
    echo "Invalid request.";
    exit;
}
?>

<div class="container p-4">
    <h2 class="mb-4">Service Request Details (ID: <?php echo $row['id']; ?>)</h2>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Field</th>
                <th>Details</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><strong>Service</strong></td>
                <td><?php echo isset($row['service_title']) ? $row['service_title'] : 'N/A'; ?></td> <!-- Display the service title -->
            </tr>
            <tr>
                <td><strong>Customer Name</strong></td>
                <td><?php echo isset($row['fullname']) ? $row['fullname'] : 'N/A'; ?></td>
            </tr>
            <tr>
                <td><strong>Email</strong></td>
                <td><?php echo isset($row['email']) ? $row['email'] : 'N/A'; ?></td>
            </tr>
            <tr>
                <td><strong>Phone</strong></td>
                <td><?php echo isset($row['phone']) ? $row['phone'] : 'N/A'; ?></td>
            </tr>
            <tr>
                <td><strong>Country</strong></td>
                <td><?php echo isset($row['country']) ? $row['country'] : 'N/A'; ?></td>
            </tr>
            <tr>
                <td><strong>State</strong></td>
                <td><?php echo isset($row['state']) ? $row['state'] : 'N/A'; ?></td>
            </tr>
            <tr>
                <td><strong>City</strong></td>
                <td><?php echo isset($row['city']) ? $row['city'] : 'N/A'; ?></td>
            </tr>
            <tr>
                <td><strong>Address</strong></td>
                <td><?php echo isset($row['address']) ? $row['address'] : 'N/A'; ?></td>
            </tr>
            <tr>
                <td><strong>Job Start Date</strong></td>
                <td><?php echo isset($row['job_start_date']) ? $row['job_start_date'] : 'N/A'; ?></td>
            </tr>
            <tr>
                <td><strong>Service Description</strong></td>
                <td><?php echo isset($row['service_description']) ? nl2br($row['service_description']) : 'N/A'; ?></td>
            </tr>
            <tr>
                <td><strong>Readiness to Hire</strong></td>
                <td><?php echo isset($row['readiness_to_hire']) ? $row['readiness_to_hire'] : 'N/A'; ?></td>
            </tr>
            <tr>
                <td><strong>Service Image</strong></td>
                <td>
                    
                        <img src="<?php echo $row['service_image']; ?>" alt="Service Image" class="img-fluid" width="200px">
                  
                </td>
            </tr>
            <tr>
                <td><strong>Created At</strong></td>
                <td><?php echo isset($row['created_at']) ? $row['created_at'] : 'N/A'; ?></td>
            </tr>
            <tr>
                <td><strong>Status</strong></td>
                <td><?php echo isset($row['status']) ? $row['status'] : 'N/A'; ?></td>
            </tr>
            <tr>
                <td><strong>Progress</strong></td>
                <td><?php echo isset($row['progress']) ? nl2br($row['progress']) : 'N/A'; ?></td>
            </tr>
        </tbody>
    </table>

    <a href="service-request.php" class="btn btn-secondary">Back to Service Requests</a>
</div>

<?php
include('includes/footer.php');
ob_end_flush();  // End output buffering and flush the output
?>
