<?php

session_start();



?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>OJM Product</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/shop.css">
  <!-- Font Awesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
  <style >
        .dropdown-menu li {
      position: relative;
    }

    .dropdown-menu .submenu {
      display: none;
      position: absolute;
      left: 100%;
      top: 0;
      margin-top: -1px;
      border-radius: 0.25rem;
    }

    .dropdown-menu .dropdown-item:hover + .submenu {
      display: block;
    }

    .dropdown-menu .submenu .dropdown-item {
      white-space: nowrap;
    }

    .user-icon {
      font-size: 2rem;
      cursor: pointer;
    }

    .dropdown-menu {
      min-width: 220px;
    }

    .dropdown-menu .login-item {
      background-color: #007bff;
      color: white;
      text-align: center;
    }

    .dropdown-menu .login-item:hover {
      background-color: #0056b3;
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
<a href="shopping-cart.php" style="color:black; text-decoration: none;"> <i class="fas fa-shopping-cart cart-icon">
    <span class="cart-count" id="cartCount">0</span>
</i></a>
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

<script>
  // Utility Functions
  function getCart() {
    return JSON.parse(localStorage.getItem('cart')) || [];
  }

  function saveCart(cart) {
    localStorage.setItem('cart', JSON.stringify(cart));
  }

  function updateCartCount() {
    const cart = getCart();
    const cartCount = cart.reduce((acc, item) => acc + item.quantity, 0);
    document.getElementById('cartCount').textContent = cartCount;
    localStorage.setItem('cartCount', cartCount);
  }

  // Add to Cart Functionality
  function addToCart(product) {
    let cart = getCart();

    const existingProductIndex = cart.findIndex(item => item.id === product.id);
    if (existingProductIndex >= 0) {
      cart[existingProductIndex].quantity += product.quantity;
    } else {
      cart.push(product);
    }

    saveCart(cart);
    updateCartCount();
  }

  // Event Listener for Add to Cart Button
  document.addEventListener('DOMContentLoaded', () => {
    updateCartCount();

    // Assuming there are multiple products on the shop page
    document.querySelectorAll('.add-to-cart-btn').forEach(button => {
      button.addEventListener('click', function () {
        const productId = parseInt(this.dataset.id);
        const productName = this.dataset.name;
        const productPrice = parseFloat(this.dataset.price);
        const productImage = this.dataset.image;

        const product = {
          id: productId,
          name: productName,
          price: productPrice,
          quantity: 1,
          image: productImage,
        };

        addToCart(product);
        alert(`${productName} has been added to the cart!`);
      });
    });
  });
</script>


<script src="js/shop.js">
  
</script>
            <div class="hamburger">
                <div></div>
                <div></div>
                <div></div>
            </div>
        </div>
    </header>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-6">
            <input type="text" id="search" class="form-control" placeholder="Search for products...">
        </div>
        <div class="col-md-6">
            <select id="filter" class="form-select">
                <option value="">Sort by Price</option>
                <option value="low-to-high">Low to High</option>
                <option value="high-to-low">High to Low</option>
            </select>
        </div>
    </div>
    <div class="row mt-4" id="results">
        <!-- Results will be displayed here -->
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    // JavaScript to handle AJAX requests
    const fetchResults = () => {
        const search = $('#search').val();
        const filter = $('#filter').val();

        $.ajax({
            url: 'filter_products.php',
            method: 'POST',
            contentType: 'application/json',
            data: JSON.stringify({ search, filter }),
            success: (response) => {
                $('#results').empty();
                if (response.error) {
                    $('#results').html(`<p class="text-danger">${response.error}</p>`);
                    return;
                }

                if (response.length === 0) {
                    $('#results').html('<p>No products found.</p>');
                    return;
                }

                response.forEach(product => {
                    $('#results').append(`
                        <div class="col-md-3">
                            <div class="card">
                                <img src="${product.image}" class="card-img-top" alt="${product.product_name}">
                                <div class="card-body">
                                    <h5 class="card-title">${product.product_name}</h5>
                                    <p class="card-text">${product.short_content}</p>
                                    <p class="card-text"><strong>Price:</strong> $${product.new_price}</p>
                                </div>
                            </div>
                        </div>
                    `);
                });
            },
            error: () => {
                $('#results').html('<p class="text-danger">Error fetching results. Please try again later.</p>');
            }
        });
    };

    // Event listeners
    $('#search, #filter').on('input', fetchResults);
</script>
<?php
include "config/conn.php";
// Fetch the total number of products
$total_products_query = "SELECT COUNT(*) AS total FROM product";
$total_result = mysqli_query($conn, $total_products_query);
$total_products = mysqli_fetch_assoc($total_result)['total'];

// Define pagination (e.g., 9 products per page)
$products_per_page = 9;
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$offset = ($page - 1) * $products_per_page;

// Fetch products with pagination
$query = "SELECT * FROM product LIMIT $offset, $products_per_page";
$result = mysqli_query($conn, $query);
?>

<div class="shop-list">
    <p>Showing <?php echo $offset + 1; ?>–<?php echo min($offset + $products_per_page, $total_products); ?> of <?php echo $total_products; ?> results</p>
    <div class="shop-list-divider">
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <div class="shop-list-divider-box">
                <div>
                    <img src="uploads/<?php echo htmlspecialchars($row['image']); ?>" alt="Product" style="max-width: 100%;">
                </div>
                <?php if ($row['sale_status'] == 1): ?>
                    <div class="sale">Sale</div>
                <?php endif; ?>
               <span>
    <a href="single-shop.php?id=<?php echo $row['id']; ?>&name=<?php echo urlencode($row['product_name']); ?>" style="color:white; text-decoration: none;">
        <i class="fas fa-cart-plus"></i> Add to Cart
    </a>
</span>

                <p class="price-name"><?php echo htmlspecialchars($row['product_name']); ?></p>
                <div class="price-tag d-flex justify-content-space-between">
                    <?php if (!empty($row['old_price']) && $row['old_price'] > 0): ?>
                        <div class="old-price"><?php echo "$" . htmlspecialchars($row['old_price']); ?></div>
                    <?php endif; ?>
                    <?php if (!empty($row['new_price']) && $row['new_price'] > 0): ?>
                        <div class="price"><?php echo "$" . htmlspecialchars($row['new_price']); ?></div>
                    <?php endif; ?>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
</div>

<!-- Pagination -->
<div class="pagination-container">
    <ul class="pagination">
        <?php for ($i = 1; $i <= ceil($total_products / $products_per_page); $i++): ?>
            <li class="<?php echo $i === $page ? 'active' : ''; ?>">
                <a href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
            </li>
        <?php endfor; ?>
    </ul>
</div>

  <!-- Bootstrap JS Bundle -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<?php
include('include/footer.php');
?>
