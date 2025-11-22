<?php
session_start();
include('includes/header.php');

// Check if the user is logged in and is an admin (You can uncomment this when implementing the admin check)
// if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
//     header('Location: login.php');
//     exit;
// }

// Fetch all service requests
$sql = "SELECT * FROM service_request";
$result = mysqli_query($conn, $sql);

if (!$result) {
    echo "Error fetching service requests: " . mysqli_error($conn);
    exit;
}
?>

<div class="container p-4">
    <h2 class="mb-4">Service Requests</h2>

    <?php if (isset($_SESSION['status'])): ?>
        <div class="alert alert-info"><?= $_SESSION['status']; unset($_SESSION['status']); ?></div>
    <?php endif; ?>

    <table class="table table-bordered table-striped">
        <thead class="thead-dark">
            <tr>
                <th>ID</th>
                <th>Service</th>
                <th>Customer</th>
                <th>Status</th>
                <th>Progress</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>
                        <td>{$row['id']}</td>
                        <td>{$row['service']}</td>
                        <td>{$row['fullname']}</td>
                        <td>{$row['status']}</td>
                        <td>{$row['progress']}</td>
                        <td>
                            <a href='update-service-order.php?id={$row['id']}' class='btn btn-primary btn-sm'>Update</a>
                            <a href='view-service-details.php?id={$row['id']}' class='btn btn-info btn-sm'>View</a>
                        </td>
                    </tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<?php
include('includes/footer.php');
?>
