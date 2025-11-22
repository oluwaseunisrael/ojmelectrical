<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Shopping Cart</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
   <!-- Font Awesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

  <style>
     .main-header {
            padding: 16px 6%;
            background-color: #fff;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 1px rgba(0, 0, 0, 0.01);
            position: relative;
            z-index: 100;
        }

        .main-header-logo img {
            max-height: 50px;
        }
           .main-header {
  position: relative; /* Default position */
  width: 100%;
  background-color: #fff; /* Adjust to your header's background color */
  transition: all 0.3s ease-in-out; /* Smooth transition */
  z-index: 1000;
}

.fixed-header {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2); /* Optional shadow for effect */
  transform: translateY(0);
}

        .main-header-nav ul {
            display: flex;
            list-style: none;
            font-size: 18px;
            gap: 1.5rem;
            font-weight: 600;
        }

        .main-header-nav ul a {
            text-decoration: none;
            color: #000;
            transition: color 0.3s;
        }

        .main-header-nav ul a:hover {
            color: #007bff;
        }

        .main-header-call {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .main-header-call button {
            padding: 8px 16px;
            background-color: #161f3b;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
        }

        .main-header-call button a {
            text-decoration: none;
            color: #fff;
        }

        .main-header-call button:hover {
            background-color: #0056b3;
        }

        .hamburger {
            display: none;
            width: 30px;
            height: 22px;
            cursor: pointer;
            position: relative;
            z-index: 200;

        }

        .hamburger div {
            position: absolute;
            width: 100%;
            height: 4px;
            background-color: #161f3b;
            border-radius: 2px;
            transition: all 0.3s ease-in-out;
        }

        .hamburger div:nth-child(1) {
            top: 0;
        }

        .hamburger div:nth-child(2) {
            top: 9px;
        }

        .hamburger div:nth-child(3) {
            top: 18px;
        }

        .hamburger.open div:nth-child(1) {
            transform: rotate(45deg);
            top: 9px;
        }

        .hamburger.open div:nth-child(2) {
            opacity: 0;
        }

        .hamburger.open div:nth-child(3) {
            transform: rotate(-45deg);
            top: 9px;
        }

        /* Overlay */
      
      .address i {
             margin-right: 1rem;
            
        }
        .social-icons{
            display: flex;
            gap: 2rem;
            display: none;
            color: #161f3b;
        }
      .address{
            display: flex;
            flex-direction: column;
            gap: 1rem;
            display: none;
            color: #161f3b;
        }
        /* Navigation Menu (for mobile) */
        @media (max-width: 798px) {
    .main-header-nav ul {
        display: flex;
        flex-direction: column;
        position: fixed !important;
        top: 0;
        right: -100%; /* Initially hidden */
        width: 100%;
        background-color: #fff;
        color: #000 !important; /* Ensure contrast with the background */
        padding: 30px 1rem;
        height: 100vh;
        transition: right 0.5s ease-in-out;
        z-index: 200;
    }

    .main-header-nav ul.active { 
        right: 0; /* Show menu when active */
    }

 
          .main-header-nav ul a {
            position: relative;
            z-index: 1;
            color: #161f3b;
            transition: color 0.3s;
        }

            .main-header-nav ul.show {
                right: 0; /* Smoothly slide in from the right */
            }

            .hamburger {
                display: block;
            }
        }
           @media (max-width: 798px) {
             .address{
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }
     
        .social-icons{
            display: flex;
            gap: 2rem;
           

        }
        .social-icons{
            display: flex;
            gap: 2rem;
           
            
        }
           .address i {
             margin-right: 1rem;
            
        }
    }
 .main-header-call-icon {
      font-size: 1.5rem;
      cursor: pointer;
      display: flex;
      gap: 1rem;
      
    }
    .cart-icon {
      position: relative;
      
      cursor: pointer;
    }

    .cart-count {
      position: absolute;
      top: -10px;
      right: -10px;
      background-color: blue;
      color: white;
      font-size: 0.8rem;
      font-weight: bold;
      border-radius: 50%;
      padding: 5px 8px;
      text-align: center;
    }

   .modal-body {
      text-align: left;
    }
        /* Prevent z-index conflicts */
    .modal-backdrop {
      z-index: 1000 !important;
    }
    .modal {
      z-index: 1050 !important;
    }

    .form-switch {
      text-align: center;
      margin-top: 15px;
    }
    .form-switch a {
      color: #6c63ff;
      text-decoration: none;
      cursor: pointer;
    }
    .form-switch a:hover {
      text-decoration: underline;
    }

  
/* Footer Styling */
.footer {
    padding: 80px 6%;
    background: #161f3b;
    color: #fff;
}

.footer-upper i {
    margin-right: 20px;
    font-size: 1.5rem;
}
.footer-lower-one{
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    gap: 1rem;
}
.logo img {
    width: 100%;
    max-width: 200px;
    height: auto;
    display: block;
    margin: 0 auto;
   
    padding: 10px;
    
    transition: transform 0.3s ease;
}



/**Layout for Footer Lower */
.footer-lower {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    align-items: flex-start;
    gap: 2rem;
}

/* Footer Lower One */
.footer-lower-one p {
    font-size: 16px;
    line-height: 1.8;
    color: #ccc;
    font-weight: 600;
    margin-bottom: 20px;
}

.footer-lower .icon {
    display: flex;
    gap: 1.5rem;
}

.footer-lower .icon i {
    font-size: 1.5rem;
    color: #f3b612;
    transition: color 0.3s ease;
}

.footer-lower .icon i:hover {
    color: #fff;
}

/* Footer Navigation Links */
.footer-lower ul {
    list-style: none;
    display: flex;
    flex-direction: column;
    gap: 15px;
    padding: 0;
}

.footer-lower li {
    display: flex;
    align-items: center;
}

.footer-lower li i {
    font-size: 0.5rem;
    margin-right: 0.5rem;
    color: #f39c12;
}

.footer-lower li a {
    color: white;
    text-decoration: none;
    font-size: 18px;
    font-weight: 600;
    transition: color 0.3s ease;
}

.footer-lower li a:hover {
    color: #f39c12;
}

/* Footer Headers */
.footer-lower h2 {
       font-size: 20px;
    color: #f3b612;
    font-weight: 600;
    margin-bottom: 15px;
}

/* Latest News Section */
.footer-lower-four .blog-detail {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

.blog-detail-box {
    display: flex;
    gap: 15px;
    align-items: flex-start;
}

.blog-detail-box .img {
    width: 60px;
    height: 60px;
    background-color: #ddd;
    border-radius: 8px;
}

.blog-detail-box .blog-detail-content p {
    font-size: 14px;
    color: #ccc;
    margin: 0;
}

.blog-detail-box .blog-detail-content span {
    font-size: 12px;
    color: #888;
}

/* Footer Main Lower */
.footer-main-lower {
    text-align: center;
    margin-top: 40px;
    font-size: 14px;
    color: #aaa;
}

.footer-main-lower p {
    margin: 0;
}

/* Hover Effects */
.footer-main-lower p:hover {
    color: #f3b612;
    transition: color 0.3s ease;
}

/* Responsive Design */
@media (max-width: 992px) {
    .footer-lower {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 576px) {
    .footer {
        padding: 40px 5%;
    }

    .footer-lower {
        grid-template-columns: 1fr;
    }

    .footer-lower h2 {
        font-size: 16px;
    }

    .footer-lower li a {
        font-size: 14px;
    }

    .footer-main-lower {
        font-size: 12px;
    }
}
.modal-backdrop {
      display: none !important; /* Hides the overlay */
    }
    .modal {
      background: none !important; /* Ensures the modal doesn't have its own overlay */
    }
    table.table td, table.table th {
      padding: 2.5rem; /* Increase cell padding */
    }
  </style>
</head>
<body>
    <header class="main-header">
        <div class="main-header-logo">
            <img src="img/logo1.png" alt="Logo">
        </div>
        <nav class="main-header-nav">
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="services.php">Services</a></li>
                <li><a href="about.php">About</a></li>
                <li><a href="shop.php">Shop</a></li>
                <li><a href="blog.php">Blog</a></li>
                <li><a href="contact.php">Contact</a></li>
                <li><a href="portifolio.php">Portifolio</a></li>
                <li><a href="login.php">Login</a></li>
               <div class="address" >
                <p><i class="fa fa-envelope"></i>info@example.com</p>
                <p><i class="fa fa-phone"></i>09028622243</p>
            </div>
             <div class="social-icons"> 
    <i class="fab fa-facebook-f"></i> 
<i class="fab fa-youtube"></i> 
<i class="fab fa-linkedin-in"></i> 
    <i class="fab fa-instagram"></i> 
</div>


            </ul>

        </nav>
       <div class="main-header-call">
    <div class="main-header-call-icon">
        <!-- Shopping Cart Icon -->
        <a href="shopping-cart.php" style="color:black; text-decoration: none;">
            <i class="fas fa-shopping-cart cart-icon">
                <span class="cart-count" id="cartCount">0</span>
            </i>
        </a>

        <!-- Login Icon -->
        <div class="dropdown">
            <i class="fas fa-user-circle user-icon" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false" style="font-size:30px !important;"></i>
            <ul class="dropdown-menu shadow" aria-labelledby="userDropdown">
                <?php
                
                if (isset($_SESSION['user_name'])) {
                    echo '<li class="dropdown-header text-center fw-bold">Welcome, ' . htmlspecialchars($_SESSION['user_name']) . '!</li>';
                    echo '<li><hr class="dropdown-divider"></li>';
                }
                ?>
                <li><a class="dropdown-item" href="dashboard.php"><i class="fas fa-user-circle me-2"></i> My Account</a></li>
                <li><a class="dropdown-item" href="order-item.php"><i class="fas fa-box me-2"></i> Orders</a></li>
                <li><a class="dropdown-item" href="service-order.php"><i class="fas fa-cogs me-2"></i> Services</a></li>
                <li><a class="dropdown-item" href="inbox.php"><i class="fas fa-envelope me-2"></i> Inbox</a></li>
                <?php
                if (isset($_SESSION['user_name'])) {
                    echo '<li><a class="dropdown-item" href="logout.php"><i class="fas fa-sign-out-alt me-2"></i> Logout</a></li>';
                } else {
                    echo '<li><a class="dropdown-item login-item fw-bold py-2" href="login.php">Login</a></li>';
                }
                ?>
            </ul>
        </div>
    </div>
</div>



            <div class="hamburger">
                <div></div>
                <div></div>
                <div></div>
            </div>
        </div>
    </header>
<div class="container mt-5">
  <h1 class="mb-4">Shopping Cart</h1>
  <div class="row">
    <!-- Shopping Cart Table -->
    <div class="col-lg-8">
      <div class="table-responsive">
        <table class="table table-bordered text-center" id="cartTable">
          <thead class="table-dark">
            <tr>
              <th>Product</th>
              <th>Price</th>
              <th>Quantity</th>
              <th>Total</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <!-- Cart items will be populated here by JavaScript -->
          </tbody>
        </table>
      </div>
    </div>

    <!-- Coupon and Cart Totals -->
    <div class="col-lg-4">
      <!-- Cart Totals -->
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Cart Totals</h5>
          <ul class="list-group list-group-flush">
            <li class="list-group-item d-flex justify-content-between">
              <span>SUBTOTAL</span>
              <strong id="subtotal">$0.00</strong>
            </li>
            <li class="list-group-item d-flex justify-content-between">
              <span>TOTAL</span>
              <strong id="total">$0.00</strong>
            </li>
          </ul>
          <button class="btn btn-success w-100 mt-3" id="checkoutBtn">Proceed to Checkout</button>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  // Fetch cart data from localStorage and render cart items
  let cart = JSON.parse(localStorage.getItem('cart')) || [];
  const cartTable = document.getElementById('cartTable').getElementsByTagName('tbody')[0];
  const subtotalElem = document.getElementById('subtotal');
  const totalElem = document.getElementById('total');
  const checkoutBtn = document.getElementById('checkoutBtn');
  const cartCountElem = document.getElementById('cartCount');

  // Function to populate the cart table
  function populateCart() {
    // Clear the current table body
    cartTable.innerHTML = '';

    if (cart.length === 0) {
      // Show message if cart is empty
      const row = cartTable.insertRow();
      row.innerHTML = `<td colspan="5">No product added to cart</td>`;
    } else {
      // Populate cart items
      cart.forEach(item => {
        let row = cartTable.insertRow();
        row.innerHTML = `
          <td><img src="uploads/${item.image}" alt="${item.name}" style="width: 50px; height: auto;"> ${item.name}</td>
          <td>$${item.price}</td>
          <td><input type="number" class="form-control quantity" value="${item.quantity}" min="1" data-id="${item.id}"></td>
          <td class="total">$${(item.price * item.quantity).toFixed(2)}</td>
          <td><button class="btn btn-danger delete-btn" data-id="${item.id}">Delete</button></td>
        `;
      });
    }
  }

  // Initial population of cart
  populateCart();

  // Update cart count
  let cartCount = cart.reduce((acc, item) => acc + item.quantity, 0);
  cartCountElem.textContent = cartCount;

  // Update totals when quantity changes
  document.querySelectorAll('.quantity').forEach(input => {
    input.addEventListener('input', function () {
      const productId = parseInt(this.dataset.id);
      const newQuantity = parseInt(this.value);
      cart = cart.map(item => {
        if (item.id === productId) {
          item.quantity = newQuantity;
        }
        return item;
      });

      localStorage.setItem('cart', JSON.stringify(cart));

      // Update total for this product
      const row = this.closest('tr');
      const price = parseFloat(row.cells[1].innerText.replace('$', ''));
      const total = price * newQuantity;
      row.querySelector('.total').innerText = `$${total.toFixed(2)}`;

      updateSubtotal();
    });
  });

  // Delete product from cart
  document.querySelectorAll('.delete-btn').forEach(button => {
    button.addEventListener('click', function () {
      const productId = parseInt(this.dataset.id);
      cart = cart.filter(item => item.id !== productId);
      localStorage.setItem('cart', JSON.stringify(cart));
      this.closest('tr').remove();
      updateSubtotal();

      // Update cart count
      cartCount = cart.reduce((acc, item) => acc + item.quantity, 0);
      cartCountElem.textContent = cartCount;
      populateCart(); // Re-render the table after deletion
    });
  });

  // Update Subtotal and Total
  function updateSubtotal() {
    let subtotal = 0;
    document.querySelectorAll('.total').forEach(totalCell => {
      subtotal += parseFloat(totalCell.innerText.replace('$', ''));
    });
    subtotalElem.innerText = `$${subtotal.toFixed(2)}`;
    totalElem.innerText = `$${subtotal.toFixed(2)}`;
  }

  // Initial subtotal calculation
  updateSubtotal();

  // Prevent checkout if cart is empty
  checkoutBtn.addEventListener('click', function (e) {
    if (cart.length === 0) {
      e.preventDefault(); // Prevent navigation
      alert("Your cart is empty. Please add some products before proceeding to checkout.");
    } else {
      window.location.href = 'checkout.php'; // Redirect to checkout page
    }
  });
</script>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script></body>
<?php
include('include/footer.php');
?>
