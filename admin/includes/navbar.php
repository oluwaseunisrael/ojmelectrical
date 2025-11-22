<?php
// Include the database connection
include "../config/conn.php";


// Fetch recent notifications for the admin
$sqlNotifications = "
    SELECT n.*, an.is_read AS admin_read_status
    FROM `notifications` n
    LEFT JOIN `admin_notifications` an
    ON n.id = an.notification_id AND an.admin_id = ?
    ORDER BY n.created_at ASC
    LIMIT 5";

$stmtNotifications = mysqli_prepare($conn, $sqlNotifications);
mysqli_stmt_bind_param($stmtNotifications, "i", $adminId);
mysqli_stmt_execute($stmtNotifications);
$notificationsResult = mysqli_stmt_get_result($stmtNotifications);

// Fetch unread notifications count for the admin
$sqlUnreadCount = "
    SELECT COUNT(*) AS unread_count
    FROM `notifications` n
    LEFT JOIN `admin_notifications` an
    ON n.id = an.notification_id AND an.admin_id = ?
    WHERE an.is_read IS NULL OR an.is_read = 0";

$stmtUnread = mysqli_prepare($conn, $sqlUnreadCount);
mysqli_stmt_bind_param($stmtUnread, "i", $adminId);
mysqli_stmt_execute($stmtUnread);
$resultUnread = mysqli_stmt_get_result($stmtUnread);
$row = mysqli_fetch_assoc($resultUnread);

$unreadCount = $row ? $row['unread_count'] : 0;

// Function to format time ago
function timeAgo($datetime, $full = false) {
    $now = new DateTime();
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);
    
    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
        'y' => 'year',
        'm' => 'month',
        'w' => 'week',
        'd' => 'day',
        'h' => 'hour',
        'i' => 'minute',
        's' => 'second',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }

    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' ago' : 'just now';
}
?>
<style>
    /* General Styles */
    body {
        font-family: Arial, sans-serif;
        background-color: #f8f9fa;
        margin: 0;
        padding: 0;
    }
    /* Navbar Dropdown Styles */
    .dropdown-menu {
        min-width: 12rem;
    }
    .dropdown-item {
        color: #495057;
    }
    .dropdown-item:hover {
        background-color: #e9ecef;
    }
    .badge.bg-danger {
        position: relative;
        top: -10px;
        right: -10px;
        font-size: 0.8rem;
    }
</style>

<nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
    <!-- Navbar Brand-->
    <a class="navbar-brand ps-3" href="index.php" style="font-size: 1rem;">NOUN EASY </a>
    <!-- Sidebar Toggle-->
    <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle"><i class="fas fa-bars"></i></button>
    
    <!-- Navbar Search-->
    <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
        <div class="input-group">
            <input class="form-control" type="text" placeholder="Search for..." aria-label="Search" aria-describedby="btnNavbarSearch" />
            <button class="btn btn-primary" id="btnNavbarSearch" type="button"><i class="fas fa-search"></i></button>
        </div>
    </form>
    
    <!-- Navbar Notifications-->
    <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
        <!-- Notification icon with unread count -->
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" id="notificationDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fas fa-bell"></i>
                <?php if ($unreadCount > 0): ?>
                    <span class="badge bg-danger"><?php echo $unreadCount; ?></span>
                <?php endif; ?>
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="notificationDropdown">
                <?php if (mysqli_num_rows($notificationsResult) > 0): ?>
                    <?php while ($notification = mysqli_fetch_assoc($notificationsResult)): ?>
                        <li>
                            <a class="dropdown-item <?php echo !$notification['admin_read_status'] ? 'font-weight-bold' : ''; ?>" href="notification_details.php?id=<?php echo $notification['id']; ?>">
                                <?php echo htmlspecialchars($notification['message']); ?>
                                <br>
                                <small class="text-muted"><?php echo htmlspecialchars(timeAgo($notification['created_at'])); ?></small>
                            </a>
                        </li>
                    <?php endwhile; ?>
                <?php else: ?>
                    <li><a class="dropdown-item" href="#">No notifications</a></li>
                <?php endif; ?>
            </ul>
        </li>
        
        <!-- User Profile dropdown -->
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <?php echo isset($_SESSION['admin']['name']) ? htmlspecialchars($_SESSION['admin']['name']) : 'Admin'; ?>
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                <li><a class="dropdown-item" href="setting.php">Settings</a></li>
                <li><a class="dropdown-item" href="activity.php">Activity Log</a></li>
                <li><hr class="dropdown-divider" /></li>
                <li><a class="dropdown-item" href="logout.php">Logout</a></li>
            </ul>
        </li>
    </ul>
</nav>
