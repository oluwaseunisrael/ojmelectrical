<?php
session_start();
include('includes/header.php');


// Fetch all estimates
$sql = "SELECT * FROM estimates ORDER BY date_submitted DESC";
$result = mysqli_query($conn, $sql);

if (!$result) {
    echo "Error fetching estimates: " . mysqli_error($conn);
    exit;
}
?>

<div class="container p-4">
    <h2>Estimates List</h2>
    
    <?php if (mysqli_num_rows($result) > 0): ?>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Service</th>
                    <th>Date Submitted</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['name']); ?></td>
                        <td><?php echo htmlspecialchars($row['email']); ?></td>
                        <td><?php echo htmlspecialchars($row['phone']); ?></td>
                        <td><?php
                            // Fetch service name based on service_id
                            $service_sql = "SELECT title FROM services WHERE id = " . $row['service_id'];
                            $service_result = mysqli_query($conn, $service_sql);
                            $service_row = mysqli_fetch_assoc($service_result);
                            echo htmlspecialchars($service_row['title']);
                        ?></td>
                        <td><?php echo date('Y-m-d H:i:s', strtotime($row['date_submitted'])); ?></td>
                        <td>
                            <a href="view-estimate-detail.php?id=<?php echo $row['id']; ?>" class="btn btn-primary">View Details</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No estimates available.</p>
    <?php endif; ?>
</div>

<?php include('includes/footer.php'); ?>
