<?php
session_start();
include('includes/header.php');
include "../config/conn.php";

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

$limit = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start = ($page - 1) * $limit;

// Fetch activity logs
$sql = "
    SELECT a.id, a.activity, a.created_at, a.ip_address, ad.name as admin_name
    FROM admin_activity_logs a
    JOIN admin ad ON a.admin_id = ad.id
    ORDER BY a.created_at DESC
    LIMIT ?, ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $start, $limit);
$stmt->execute();
$result = $stmt->get_result();

// Count total logs for pagination
$countSql = "SELECT COUNT(*) as count FROM admin_activity_logs";
$countResult = $conn->query($countSql);
$totalRecords = $countResult->fetch_assoc()['count'];
$totalPages = ceil($totalRecords / $limit);
?>


<div class="container mt-5">
    <h1 class="mb-4">Admin Activity Logs</h1>
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Admin Name</th>
                    <th>Activity</th>
                    <th>IP Address</th>
                    <th>Timestamp</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['id']); ?></td>
                            <td><?php echo htmlspecialchars($row['admin_name']); ?></td>
                            <td><?php echo htmlspecialchars($row['activity']); ?></td>
                            <td><?php echo htmlspecialchars($row['ip_address']); ?></td>
                            <td><?php echo htmlspecialchars($row['created_at']); ?></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="text-center">No activity logs found</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <nav aria-label="Page navigation">
        <ul class="pagination justify-content-center">
            <?php if ($page > 1): ?>
                <li class="page-item"><a class="page-link" href="?page=<?php echo $page - 1; ?>">Previous</a></li>
            <?php endif; ?>
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <li class="page-item <?php if ($i == $page) echo 'active'; ?>">
                    <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                </li>
            <?php endfor; ?>
            <?php if ($page < $totalPages): ?>
                <li class="page-item"><a class="page-link" href="?page=<?php echo $page + 1; ?>">Next</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</div>

<?php include('includes/footer.php'); ?>
