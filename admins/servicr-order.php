<?php
session_start();
include('include/header.php');

// Check if the user is logged in and is an admin


// Fetch all service requests
$sql = "SELECT * FROM service_request";
$result = mysqli_query($conn, $sql);

if (!$result) {
    echo "Error fetching service requests: " . mysqli_error($conn);
    exit;
}

?>

<div class="container p-4">
    <h2>Service Requests</h2>
    <table class="table table-bordered">
        <thead>
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
                            <a href='update-service-order.php?id={$row['id']}' class='btn btn-primary'>Update</a>
                        </td>
                    </tr>";
            }
            ?>
        </tbody>
    </table>
</div>
