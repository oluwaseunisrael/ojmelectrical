<?php
header('Content-Type: application/json');

try {
    $data = json_decode(file_get_contents('php://input'), true);

    // Check if the user is logged in
    $sessionCheck = json_decode(file_get_contents('check_session.php'), true);
    if (!$sessionCheck['success']) {
        echo json_encode([
            'success' => false,
            'message' => 'Please log in to place your order.',
            'redirect' => 'login.php'
        ]);
        exit;
    }

    // Extract billing and cart data
    $billing = $data['billingDetails'];
    $cart = $data['cart'];
    $paymentMethod = $data['paymentMethod'];
    $orderNote = $data['orderNote'];

    include "config/conn.php";

    // Check if customer email exists in database
    $stmt = $conn->prepare("SELECT * FROM customers WHERE email = ?");
    $stmt->bind_param("s", $billing['email']);
    $stmt->execute();
    $result = $stmt->get_result();
    $customer = $result->fetch_assoc();

    if (!$customer) {
        echo json_encode([
            'success' => false,
            'message' => 'Customer not found. Please register first.',
            'redirect' => 'register.php'
        ]);
        exit;
    }

    // Insert order into Orders table
    $stmt = $conn->prepare("INSERT INTO orders (customer_id, first_name, last_name, email, phone, address, city, zip, payment_method, order_note, total_amount) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isssssssssi", $customer['id'], $billing['firstName'], $billing['lastName'], $billing['email'], $billing['phone'], $billing['address'], $billing['city'], $billing['zip'], $paymentMethod, $orderNote, $totalAmount);
    $totalAmount = array_reduce($cart, function ($sum, $item) {
        return $sum + $item['price'] * $item['quantity'];
    }, 0);
    if (!$stmt->execute()) {
        throw new Exception("Order insertion failed: " . $stmt->error);
    }
    $orderId = $conn->insert_id;

    // Insert cart items into Order Items table
    foreach ($cart as $item) {
        $stmt = $conn->prepare("INSERT INTO order_items (order_id, product_name, price, quantity, subtotal) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("isiii", $orderId, $item['name'], $item['price'], $item['quantity'], $item['price'] * $item['quantity']);
        if (!$stmt->execute()) {
            throw new Exception("Order item insertion failed: " . $stmt->error);
        }
    }

    // Success response
    echo json_encode([
        'success' => true,
        'orderId' => $orderId
    ]);
} catch (Exception $e) {
    error_log($e->getMessage());
    echo json_encode([
        'success' => false,
        'message' => 'An error occurred while processing your order: ' . $e->getMessage()
    ]);
} finally {
    if (isset($conn) && $conn) {
        $conn->close();
    }
}
?>