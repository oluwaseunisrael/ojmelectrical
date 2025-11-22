
<?php
session_start();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
     <!-- Alertify.js CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css"/>
    <!-- Alertify.js Theme -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/default.min.css"/>
    <style>
       
        .checkout-container {
            margin-top: 40px;
        }

        .checkout-header {
            text-align: center;
            margin-bottom: 30px;
            font-weight: bold;
        }

        .section-title {
            font-size: 1.25rem;
            font-weight: bold;
            color: #333;
            margin-bottom: 15px;
        }

        .form-label {
            font-weight: bold;
        }

        .order-summary-table th,
        .order-summary-table td {
            padding: 15px;
            text-align: center;
        }

        .order-summary-table {
            margin-bottom: 30px;
        }

        .payment-method {
            margin-bottom: 20px;
        }

        .place-order-btn {
            background-color: #28a745;
            color: white;
            font-size: 1.2rem;
            width: 100%;
        }

        .place-order-btn:hover {
            background-color: #218838;
        }

        .country-select {
            font-size: 1.1rem;
            height: 45px;
            padding: 10px;
        }

        .form-check-input:checked {
            background-color: #28a745;
            border-color: #28a745;
        }

        .order-summary-card {
            background-color: white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            padding: 25px;
        }
    </style>
</head>

<body>

<div class="container checkout-container">
  <?php

include "config/conn.php";

// Redirect to login if the user is not logged in
if (!isset($_SESSION['isLoggedIn']) || !$_SESSION['isLoggedIn']) {
    header("Location: login.php");
    exit;
}

// Fetch logged-in user's email (and other details if needed)
$email = isset($_SESSION['user_email']) ? $_SESSION['user_email'] : '';
?>

<h2 class="checkout-header">Checkout</h2>

<div class="row">
    <!-- Left Column - Billing Details -->
    <div class="col-lg-7">
        <!-- Billing Details Form -->
        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="section-title">Billing Details</h5>
               <form id="billingForm" method="POST" action="checkout-process.php">

    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="firstName" class="form-label">First Name *</label>
           <input type="text" class="form-control" id="firstName" name="first_name" required>
        </div>
        <div class="col-md-6 mb-3">
            <label for="lastName" class="form-label">Last Name *</label>
            <input type="text" class="form-control" id="lastName" name="last_name" required>

        </div>
    </div>
    <div class="mb-3">
        <label for="email" class="form-label">Email Address</label>
        <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($email) ?>" required>
    </div>
    <div class="mb-3">
        <label for="phone" class="form-label">Phone *</label>
        <input type="text" class="form-control" id="phone" name="phone" required>
    </div>
    <div class="mb-3">
        <label for="address" class="form-label">Address *</label>
        <input type="text" class="form-control" id="address" name="address" required>
    </div>
    <div class="mb-3">
        <label for="city" class="form-label">City *</label>
        <input type="text" class="form-control" id="city" name="city" required>
    </div>
    <div class="mb-3">
        <label for="zip" class="form-label">Zip / Postal Code</label>
        <input type="text" class="form-control" id="zip" name="zip">
    </div>
</form>

            </div>
        </div>
    </div>

    <!-- Right Column - Additional Information & Order Summary -->
    <div class="col-lg-5">
        <!-- Additional Information Form -->
        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="section-title">Additional Information</h5>
                <div class="mb-3">
                    <label for="orderNote" class="form-label">Order Note</label>
                    <textarea class="form-control" id="orderNote" rows="3" placeholder="Any special instructions for the order..."></textarea>
                </div>
            </div>
        </div>

        <!-- Order Summary -->
        <div class="card order-summary-card">
            <div class="card-body">
                <h5 class="section-title">Your Order</h5>
                <table class="table table-bordered order-summary-table" id="orderSummary">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Product rows will be inserted here dynamically -->
                    </tbody>
                </table>
                <div class="d-flex justify-content-between mb-3">
                    <span>Subtotal</span>
                    <strong id="subtotal">$0.00</strong>
                </div>
                <div class="d-flex justify-content-between mb-3">
                    <span>Shipping</span>
                    <span>Calculated at checkout</span>
                </div>
                <div class="d-flex justify-content-between mb-3">
                    <span>Total</span>
                    <strong id="total">$0.00</strong>
                </div>
            </div>
        </div>

        <!-- Payment Method -->
       <div class="card order-summary-card">
    <div class="card-body">
        <h5 class="section-title">Shipping Fee</h5>
        <p>Shipping fee will depend on your location and will be calculated during checkout.</p>

        <h5 class="section-title mt-3">Payment Method</h5>
        <div class="form-check payment-method">
            <input class="form-check-input" type="radio" name="paymentMethod" id="paymentCheque" value="cheque">
            <label class="form-check-label" for="paymentCheque">Cheque Payment</label>
        </div>
        <div class="form-check payment-method">
            <input class="form-check-input" type="radio" name="paymentMethod" id="paymentBankTransfer" value="bankTransfer">
            <label class="form-check-label" for="paymentBankTransfer">Direct Bank Transfer</label>
        </div>
        <div class="form-check payment-method">
            <input class="form-check-input" type="radio" name="paymentMethod" id="paymentPaypal" value="paypal">
            <label class="form-check-label" for="paymentPaypal">Paypal</label>
        </div>
        <div class="form-check payment-method">
            <input class="form-check-input" type="radio" name="paymentMethod" id="paymentOnDelivery" value="onDelivery">
            <label class="form-check-label" for="paymentOnDelivery">Pay on Delivery</label>
        </div>
        <button class="btn btn-primary mt-3" onclick="placeOrder()">Place Order</button>
    </div>
</div>

        </div>
    </div>
</div>

</div>

<script>
// Fetch cart data from localStorage
let cart = JSON.parse(localStorage.getItem('cart')) || [];
const orderSummary = document.getElementById('orderSummary').getElementsByTagName('tbody')[0];
const subtotalElem = document.getElementById('subtotal');
const totalElem = document.getElementById('total');

// Populate order summary with cart items
cart.forEach(item => {
    let row = orderSummary.insertRow();
    row.innerHTML = `
        <td><img src="uploads/${item.image}" alt="${item.name}" class="img-fluid" style="width: 50px; height: 50px;"> ${item.name}</td>
        <td>$${item.price}</td>
        <td>${item.quantity}</td>
        <td>$${(item.price * item.quantity).toFixed(2)}</td>
    `;
});

// Update Subtotal and Total
function updateTotals() {
    let subtotal = 0;
    cart.forEach(item => {
        subtotal += item.price * item.quantity;
    });

    subtotalElem.innerText = `$${subtotal.toFixed(2)}`;
    totalElem.innerText = `$${subtotal.toFixed(2)}`;
}

updateTotals();
</script>

<script>
function placeOrder() {
    const cart = JSON.parse(localStorage.getItem('cart')) || [];
    const billingForm = document.getElementById('billingForm');
    const formData = new FormData(billingForm);

    // Validation check for required fields
    const requiredFields = {
        first_name: formData.get('first_name'),
        last_name: formData.get('last_name'),
        email: formData.get('email'),
        phone: formData.get('phone'),
        address: formData.get('address'),
        city: formData.get('city'),
        payment_method: document.querySelector('input[name="paymentMethod"]:checked')?.value,
    };

    for (const [key, value] of Object.entries(requiredFields)) {
        if (!value || value.trim() === '') {
            alertify.error(`Please fill in the ${key.replace('_', ' ')} field.`);
            return; // Exit if a required field is empty
        }
    }

    const orderData = {
        ...requiredFields, // Add validated fields
        zip: formData.get('zip') || '', // Optional field
        order_note: document.getElementById('orderNote').value || '', // Optional field
        cart: JSON.stringify(cart),
    };

    fetch('place_order.php', {
        method: 'POST',
        body: new URLSearchParams(orderData),
    })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                alertify.success(data.message);
                localStorage.removeItem('cart');
                window.location.href = 'order-confirmation.php'; // Redirect to confirmation page
            } else {
                alertify.error(data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alertify.error('An unexpected error occurred.');
        });
}
</script>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
     <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css" />
<script src="https://cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>

</body>

</html>