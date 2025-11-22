<?php
ob_start();
session_start(); // Start the session
include 'includes/header.php'; // Include the header
include '../config/conn.php'; // Include the database connection

// Fetch customers from the database
$query = "SELECT * FROM customers";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}
?>

<div class="container mt-5">
    <h2>Customer List</h2>

    <!-- Display Session Messages -->
    <?php if (isset($_SESSION['success_message'])): ?>
        <div class="alert alert-success">
            <?php 
                echo $_SESSION['success_message']; 
                unset($_SESSION['success_message']); // Clear the message
            ?>
        </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['error_message'])): ?>
        <div class="alert alert-danger">
            <?php 
                echo $_SESSION['error_message']; 
                unset($_SESSION['error_message']); // Clear the message
            ?>
        </div>
    <?php endif; ?>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['id']); ?></td>
                    <td><?php echo htmlspecialchars($row['name']); ?></td>
                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                    <td><?php echo htmlspecialchars($row['phone']); ?></td>
                    <td><?php echo htmlspecialchars($row['status']); ?></td>
                    <td>
                        <?php if ($row['status'] === 'active'): ?>
                            <a href="ban_customer.php?id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm">Ban</a>
                        <?php else: ?>
                            <a href="unban_customer.php?id=<?php echo $row['id']; ?>" class="btn btn-success btn-sm">Unban</a>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<!-- Include Footer -->
<?php include 'includes/footer.php'; ?>

</body>
</html>
