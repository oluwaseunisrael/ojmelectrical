<?php
session_start();
include "config/conn.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

if (!isset($_SESSION['isLoggedIn']) || !$_SESSION['isLoggedIn']) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $customer_id = $_SESSION['user_id']; // Assuming this is stored in session
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    $zip = $_POST['zip'];
    $payment_method = $_POST['payment_method'];
    $order_note = $_POST['order_note'];
    $cart = json_decode($_POST['cart'], true); // Cart data passed as JSON

    $subtotal = array_reduce($cart, function ($total, $item) {
        return $total + ($item['price'] * $item['quantity']);
    }, 0);

    $shipping_cost = 5.00; // Example shipping cost
    $total = $subtotal + $shipping_cost;

    // Insert order into the `orders` table
    $stmt = $conn->prepare("INSERT INTO orders (customer_id, first_name, last_name, email, phone, address, city, zip, payment_method, order_note, subtotal, shipping_cost, total, order_status, order_date, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'Pending', NOW(), NOW())");
    $stmt->bind_param("isssssssssddd", $customer_id, $first_name, $last_name, $email, $phone, $address, $city, $zip, $payment_method, $order_note, $subtotal, $shipping_cost, $total);

    if ($stmt->execute()) {
        $order_id = $stmt->insert_id;

        // Insert items into the `order_items` table
        $item_stmt = $conn->prepare("INSERT INTO order_items (order_id, product_id, product_name, price, quantity, subtotal) VALUES (?, ?, ?, ?, ?, ?)");
        foreach ($cart as $item) {
            $product_id = $item['id'];
            $product_name = $item['name'];
            $price = $item['price'];
            $quantity = $item['quantity'];
            $item_subtotal = $price * $quantity;

            $item_stmt->bind_param("iisddi", $order_id, $product_id, $product_name, $price, $quantity, $item_subtotal);
            $item_stmt->execute();
        }

        // Send confirmation emails
        $business_email = "ojmelectrical@gmail.com"; // Replace with your business email
        $customer_email = $email; // Customer's email
        $fullname = $first_name . ' ' . $last_name;

        try {
            $mail = new PHPMailer(true);

            // SMTP configuration
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com'; // Update with your SMTP server
            $mail->SMTPAuth = true;
            $mail->Username = 'ojmelectrical@gmail.com'; // Update with your SMTP username
            $mail->Password = 'tkng pech bbqr pcdu'; // Update with your SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port = 465;

            // Email to the customer
            $mail->setFrom($business_email, 'OJM Electrical Company');
            $mail->addAddress($customer_email, $fullname);
            $mail->isHTML(true);
            $mail->Subject = 'Order Confirmation for ' . $fullname . ' from Your Business Name';  // Customer's name in the subject

            // Product list section
            $product_details = '';
            foreach ($cart as $item) {
                $product_details .= "<li><strong>Product Name:</strong> " . $item['name'] . " | <strong>Quantity:</strong> " . $item['quantity'] . " | <strong>Price:</strong> $$item[price]</li>";
            }

            $mail->Body = "
                <p>Dear $fullname,</p>
                <p>Thank you for your order! We have received your order and are processing it. Below are the details:</p>
                <ul>
                    <li><strong>Order ID:</strong> $order_id</li>
                    <li><strong>Shipping Address:</strong> $address, $city, $zip</li>
                    <li><strong>Phone:</strong> $phone</li>
                    <li><strong>Total Amount:</strong> $$total</li>
                    <li><strong>Payment Method:</strong> $payment_method</li>
                    <li><strong>Order Note:</strong> $order_note</li>
                    <li><strong>Ordered Products:</strong></li>
                    <ul>
                        $product_details
                    </ul>
                </ul>
                <p>We will notify you once your order has shipped In Your Dashboard.</p>
                <p>Thank you for choosing us!</p>
                <p>Best regards,<br>Your Business Team</p>
            ";

            $mail->send();

            // Email to the business
            $mail->clearAddresses(); // Clear the previous recipient
            $mail->addAddress($business_email, 'OJM Electrical Company');
            $mail->Subject = 'New Order Received';
            
            $mail->Body = "
                <p>Hello,</p>
                <p>A new order has been placed. Here are the details:</p>
                <ul>
                    <li><strong>Customer Name:</strong> $fullname</li>
                    <li><strong>Email:</strong> $customer_email</li>
                    <li><strong>Phone:</strong> $phone</li>
                    <li><strong>Shipping Address:</strong> $address, $city, $zip</li>
                    <li><strong>Order Total:</strong> $$total</li>
                    <li><strong>Payment Method:</strong> $payment_method</li>
                    <li><strong>Order Note:</strong> $order_note</li>
                    <li><strong>Ordered Products:</strong></li>
                    <ul>
                        $product_details
                    </ul>
                </ul>
                <p>Regards,<br>Your System</p>
            ";

            $mail->send();
            echo json_encode(['status' => 'success', 'message' => 'Order placed successfully and confirmation emails sent!']);
        } catch (Exception $e) {
            echo json_encode(['status' => 'error', 'message' => "Email could not be sent. Mailer Error: {$mail->ErrorInfo}"]);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to place order.']);
    }
}
?>
