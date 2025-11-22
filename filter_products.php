<?php
include "config/conn.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the JSON input
    $data = json_decode(file_get_contents('php://input'), true);
    $search = $data['search'] ?? '';
    $filter = $data['filter'] ?? '';

    // Base query
    $query = "SELECT * FROM product WHERE product_name LIKE '%$search%'";
if ($filter === 'low-to-high') {
    $query .= " ORDER BY new_price ASC";
} elseif ($filter === 'high-to-low') {
    $query .= " ORDER BY new_price DESC";
}

// Debugging
error_log("SQL Query: " . $query); // Logs query to PHP error log
$result = mysqli_query($connection, $query);
if (!$result) {
    echo json_encode(['error' => mysqli_error($connection)]);
    exit;
}

    $products = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $products[] = $row;
    }

    // Return JSON response
    echo json_encode($products);
}
?>


