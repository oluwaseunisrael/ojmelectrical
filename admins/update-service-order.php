<?php
session_start();
include('include/header.php');

// Check if the 'id' is provided
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch the service request details
    $sql = "SELECT * FROM service_request WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);

    if (!$row) {
        echo "No service request found.";
        exit;
    }
} else {
    echo "Invalid request.";
    exit;
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $status = $_POST['status'];
    $progress = $_POST['progress'];

    // Update the service request status and progress
    $sql_update = "UPDATE service_request SET status = ?, progress = ? WHERE id = ?";
    $stmt_update = mysqli_prepare($conn, $sql_update);
    mysqli_stmt_bind_param($stmt_update, "ssi", $status, $progress, $id);

    if (mysqli_stmt_execute($stmt_update)) {
        $_SESSION['status'] = "Service request updated successfully!";
        header("Location: service-request.php");
        exit;
    } else {
        $_SESSION['status'] = "Error updating service request.";
    }
}
?>

<div class="container p-4">
    <h2>Update Service Request - ID: <?php echo $row['id']; ?></h2>

    <form action="" method="POST">
        <div class="form-group">
            <label for="status">Status</label>
            <select name="status" id="status" class="form-control" required>
                <option value="pending" <?php echo ($row['status'] == 'pending') ? 'selected' : ''; ?>>Pending</option>
                <option value="In Progress" <?php echo ($row['status'] == 'in_progress') ? 'selected' : ''; ?>>In Progress</option>
                <option value="completed" <?php echo ($row['status'] == 'completed') ? 'selected' : ''; ?>>Completed</option>
                <option value="cancelled" <?php echo ($row['status'] == 'cancelled') ? 'selected' : ''; ?>>Cancelled</option>
            </select>
        </div>

        <div class="form-group">
            <label for="progress">Progress</label>
            <textarea name="progress" id="progress" class="form-control" rows="5" required><?php echo $row['progress']; ?></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
