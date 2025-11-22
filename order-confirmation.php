<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f9f9f9;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .confirmation-container {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            padding: 40px;
            max-width: 400px;
            text-align: center;
        }
        .checkmark-circle {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background: #28a745;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0 auto 20px;
        }
        .checkmark {
            font-size: 3rem;
            color: #fff;
        }
        .confirmation-message {
            font-size: 1.5rem;
            font-weight: bold;
            color: #333;
            margin-bottom: 10px;
        }
        .sub-message {
            font-size: 1rem;
            color: #666;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

<div class="confirmation-container">
    <div class="checkmark-circle">
        <span class="checkmark">&#10003;</span>
    </div>
    <div class="confirmation-message">Order Complete</div>
    <p class="sub-message">Thank you for your order. We’ll send you a confirmation email shortly.</p>
    <a href="order-item.php" class="btn btn-success w-100">View Order</a>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
