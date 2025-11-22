<?php
session_start();

if (isset($_SESSION['user_id']) && $_SESSION['isLoggedIn'] === true) {
    echo json_encode([
        'success' => true,
        'message' => 'User is logged in.',
    ]);
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Not logged in.',
    ]);
}
exit;
?>