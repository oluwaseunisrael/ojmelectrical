<?php
header('Content-Type: application/json');

// Enable error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

try {
    // Start session
    session_start();

    // Check if session variables are set and valid
    if (!isset($_SESSION['userId']) || $_SESSION['isLoggedIn'] !== true) {
        echo json_encode([
            'success' => false,
            'message' => 'Session variables are not set or are false.',
            'redirect' => 'login.php'
        ]);
        exit;
    }

    // Debugging session data (for development purposes only)
    // echo "Session Data:<br>";
    // print_r($_SESSION);

    // Decode input JSON
    $data = json_decode(file_get_contents('php://input'), true);

    // Extract billing and cart data
    $billing = $data['billingDetails'];
    $cart = $data['cart'];
    $paymentMethod = $data['paymentMethod'];
    $orderNote = $data['orderNote'];

    // Include database connection
    include "config/conn.php";

    // Check if customer email exists in the database
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

    // Calculate the total amount from the cart
    $totalAmount = array_reduce($cart, function ($sum, $item) {
        return $sum + $item['price'] * $item['quantity'];
    }, 0);

    // Insert order into the Orders table
    $stmt = $conn->prepare("INSERT INTO orders (customer_id, first_name, last_name, email, phone, address, city, zip, payment_method, order_note, total_amount) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isssssssssi", $customer['id'], $billing['firstName'], $billing['lastName'], $billing['email'], $billing['phone'], $billing['address'], $billing['city'], $billing['zip'], $paymentMethod, $orderNote, $totalAmount);

    if (!$stmt->execute()) {
        throw new Exception("Order insertion failed: " . $stmt->error);
    }
    
    $orderId = $conn->insert_id;

    // Insert cart items into the Order Items table
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
    // Log error details for debugging purposes
    error_log($e->getMessage());

    // Send a generic error message to the user
    echo json_encode([
        'success' => false,
        'message' => 'An error occurred while processing your order.'
    ]);
} finally {
    // Close the database connection
    if (isset($conn) && $conn) {
        $conn->close();
    }
}
?>
