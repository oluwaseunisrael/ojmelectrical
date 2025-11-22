<?php
session_start();

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Product detail</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="css/singleshop.css">
  <!-- FontAwesome Icons -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
  <!-- Custom CSS -->
  <style>

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
    </div>
</div>


  <script>
 
        document.addEventListener("DOMContentLoaded", function () {
  const header = document.querySelector(".main-header");

  window.addEventListener("scroll", () => {
    if (window.scrollY > 0) {
      header.classList.add("fixed-header");
    } else {
      header.classList.remove("fixed-header");
    }
  });
});

  </script>

            <div class="hamburger" onclick="toggleMenu()">
                <div></div>
                <div></div>
                <div></div>
            </div>
        </div>
    </header>
  <?php
include "config/conn.php";
if (isset($_GET['id'])) {
    $product_id = intval($_GET['id']); // Get the product id from URL

    // Query to fetch the product details
    $query = "SELECT * FROM product WHERE id = $product_id";
    $result = mysqli_query($conn, $query);

    // Check if the product exists
    if ($row = mysqli_fetch_assoc($result)) {
        // Fetch product data
        $product_name = htmlspecialchars($row['product_name']);
        $product_image = htmlspecialchars($row['image']);
        $old_price = htmlspecialchars($row['old_price']);
        $new_price = htmlspecialchars($row['new_price']);
        $product_description = htmlspecialchars($row['product_description']);
        $short_content = htmlspecialchars($row['short_content']);

        // Fetch product types
        $type_one = htmlspecialchars($row['type_one']);
        $type_two = htmlspecialchars($row['type_two']);
        $type_three = htmlspecialchars($row['type_three']);
        $type_four = htmlspecialchars($row['type_four']);
    } else {
        // Redirect or show an error if the product is not found
        echo "Product not found.";
        exit;
    }
} else {
    // Redirect or show an error if no product id is passed
    echo "No product selected.";
    exit;
}
?>
<div class="container py-5">
    <div class="row product-page">
        <!-- Product Image -->
        <div class="col-md-6 p-0">
            <img src="uploads/<?php echo $product_image; ?>" alt="<?php echo $product_name; ?>" class="img-fluid product-img">
        </div>

        <!-- Product Details -->
        <div class="col-md-6 product-details">
            <h1 class="product-title"><?php echo $product_name; ?></h1>
            <div class="d-flex align-items-center mb-3">
                <div class="rating me-3">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star-half-alt"></i>
                    <i class="far fa-star"></i>
                </div>
                <small>(45 Reviews)</small>
            </div>
            <div class="mb-4">
                <?php if (!empty($old_price)): ?>
                    <p class="text-decoration-line-through text-muted"><?php echo "$" . $old_price; ?></p>
                <?php endif; ?>
                <span class="product-price" id="product-price"><?php echo "$" . $new_price; ?></span>
            </div>
            <p class="text-muted mb-4">
                <?php echo $short_content; ?>
            </p>

            <!-- Type Options -->
            <div class="mb-4">
                <strong>Choose Type:</strong>
                <div class="btn-group mt-2" role="group">
                    <?php if (!empty($type_one)): ?>
                        <input type="radio" class="btn-check" name="type" id="type<?php echo $type_one; ?>" value="<?php echo $type_one; ?>">
                        <label class="btn btn-outline-secondary" for="type<?php echo $type_one; ?>"><?php echo $type_one; ?></label>
                    <?php endif; ?>
                    <?php if (!empty($type_two)): ?>
                        <input type="radio" class="btn-check" name="type" id="type<?php echo $type_two; ?>" value="<?php echo $type_two; ?>">
                        <label class="btn btn-outline-secondary" for="type<?php echo $type_two; ?>"><?php echo $type_two; ?></label>
                    <?php endif; ?>
                    <?php if (!empty($type_three)): ?>
                        <input type="radio" class="btn-check" name="type" id="type<?php echo $type_three; ?>" value="<?php echo $type_three; ?>">
                        <label class="btn btn-outline-secondary" for="type<?php echo $type_three; ?>"><?php echo $type_three; ?></label>
                    <?php endif; ?>
                    <?php if (!empty($type_four)): ?>
                        <input type="radio" class="btn-check" name="type" id="type<?php echo $type_four; ?>" value="<?php echo $type_four; ?>">
                        <label class="btn btn-outline-secondary" for="type<?php echo $type_four; ?>"><?php echo $type_four; ?></label>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Quantity Selector -->
            <div class="quantity-controls mb-4">
                <button id="decrement">-</button>
                <input type="text" id="quantity" value="1" readonly>
                <button id="increment">+</button>
            </div>

            <!-- Add to Cart -->
            <div class="d-flex align-items-center">
    <button class="add-to-cart-btn" id="addToCartBtn">
        <i class="fas fa-cart-plus"></i> Add to Cart
    </button>
</div>
        </div>
    </div>
</div>
<script>
  // Function to get cart from localStorage or initialize as an empty array
  function getCart() {
    return JSON.parse(localStorage.getItem('cart')) || [];
  }

  // Function to save cart to localStorage
  function saveCart(cart) {
    localStorage.setItem('cart', JSON.stringify(cart));
  }

  // Function to update the cart count icon
  function updateCartCount() {
    const cart = getCart();
    const cartCount = cart.reduce((acc, item) => acc + item.quantity, 0);
    document.getElementById('cartCount').textContent = cartCount;
    localStorage.setItem('cartCount', cartCount);
  }

  // Function to add an item to the cart
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

  // Function to populate the cart table
  function populateCartTable() {
    const cart = getCart();
    const cartTable = document.getElementById('cartTable').getElementsByTagName('tbody')[0];
    const subtotalElem = document.getElementById('subtotal');
    const totalElem = document.getElementById('total');

    cartTable.innerHTML = ''; // Clear current table body

    if (cart.length === 0) {
      const row = cartTable.insertRow();
      row.innerHTML = `<td colspan="5">No product added to cart</td>`;
      subtotalElem.textContent = '$0.00';
      totalElem.textContent = '$0.00';
      return;
    }

    let subtotal = 0;
    cart.forEach(item => {
      const row = cartTable.insertRow();
      const itemTotal = item.price * item.quantity;
      subtotal += itemTotal;

      row.innerHTML = `
        <td><img src="uploads/${item.image}" alt="${item.name}" style="width: 50px; height: auto;"> ${item.name}</td>
        <td>$${item.price}</td>
        <td><input type="number" class="form-control quantity" value="${item.quantity}" min="1" data-id="${item.id}"></td>
        <td class="total">$${itemTotal.toFixed(2)}</td>
        <td><button class="btn btn-danger delete-btn" data-id="${item.id}">Delete</button></td>
      `;
    });

    subtotalElem.textContent = `$${subtotal.toFixed(2)}`;
    totalElem.textContent = `$${subtotal.toFixed(2)}`;

    addEventListenersToCartTable();
  }

  // Function to add event listeners to the cart table
  function addEventListenersToCartTable() {
    document.querySelectorAll('.quantity').forEach(input => {
      input.addEventListener('input', function () {
        const productId = parseInt(this.dataset.id);
        const newQuantity = parseInt(this.value);
        let cart = getCart();

        cart = cart.map(item => {
          if (item.id === productId) {
            item.quantity = newQuantity;
          }
          return item;
        });

        saveCart(cart);
        populateCartTable();
        updateCartCount();
      });
    });

    document.querySelectorAll('.delete-btn').forEach(button => {
      button.addEventListener('click', function () {
        const productId = parseInt(this.dataset.id);
        let cart = getCart();

        cart = cart.filter(item => item.id !== productId);
        saveCart(cart);
        populateCartTable();
        updateCartCount();
      });
    });
  }

  // Attach to Add to Cart button (for single shop page)
  document.getElementById('addToCartBtn').addEventListener('click', function () {
    const product = {
      id: <?php echo $product_id; ?>,
      name: "<?php echo $product_name; ?>",
      price: parseFloat("<?php echo $new_price; ?>"),
      quantity: 1,
      image: "<?php echo $product_image; ?>"
    };

    addToCart(product);
  });

  // Initialize cart count on page load
  document.addEventListener('DOMContentLoaded', () => {
    updateCartCount();

    // For cart page, populate the cart table
    if (document.getElementById('cartTable')) {
      populateCartTable();
    }
  });

  // Checkout button handler (on cart page)
  if (document.getElementById('checkoutBtn')) {
    document.getElementById('checkoutBtn').addEventListener('click', function (e) {
      const cart = getCart();
      if (cart.length === 0) {
        e.preventDefault(); // Prevent navigation
        alert('Your cart is empty. Please add some products before proceeding to checkout.');
      }
    });
  }
</script>


<!-- JavaScript to Update Price Based on Quantity with Local Storage -->
<script>
    // Assuming these are set dynamically from PHP
    var productPrice = <?php echo $new_price; ?>;
    var quantityInput = document.getElementById('quantity');
    var priceDisplay = document.getElementById('product-price');

    // Function to update the displayed price
    function updatePrice() {
        var quantityValue = parseInt(quantityInput.value);
        var totalPrice = productPrice * quantityValue;
        priceDisplay.innerText = "$" + totalPrice.toFixed(2); // Format to 2 decimal places
    }

    // Function to get stored quantity from local storage
    function loadQuantity() {
        var savedQuantity = localStorage.getItem('product_quantity');
        if (savedQuantity) {
            quantityInput.value = savedQuantity;
        } else {
            quantityInput.value = 1; // Default to 1 if no saved quantity
        }
        updatePrice(); // Update price on page load
    }

    // Function to store the quantity in local storage
    function saveQuantity() {
        localStorage.setItem('product_quantity', quantityInput.value);
    }

    // Event listener for increment button
    document.getElementById('increment').addEventListener('click', function() {
        var quantityValue = parseInt(quantityInput.value);
        quantityInput.value = quantityValue + 1;
        updatePrice();
        saveQuantity(); // Save to local storage
    });

    // Event listener for decrement button
    document.getElementById('decrement').addEventListener('click', function() {
        var quantityValue = parseInt(quantityInput.value);
        if (quantityValue > 1) {
            quantityInput.value = quantityValue - 1;
            updatePrice();
            saveQuantity(); // Save to local storage
        }
    });

    // Load the quantity and price when the page loads
    window.onload = function() {
        loadQuantity();
    }
</script>
<div class="container py-5">
  <div class="single-product-review">
    <!-- Tab Navigation: Product Description / Reviews -->
    <div class="single-product-review-divider">
      <span id="product-description-tab">Product Description</span>
      <span id="reviews-tab">Reviews (44)</span>
    </div>

    <!-- Product Description -->
    <div class="product-description">
      <p>
        <?php echo $product_description; ?>
      </p>
      <p>
        Goodbye gray sky hello blue. There's nothing can hold me when I hold you. Feels so right it cant be wrong. Rockin' and rollin' all week long. Said Californ'y is the place you ought to be.
      </p>
    </div>

    <!-- Reviews Section -->
    <!-- Reviews Section -->
<div class="product-reviews">
  <h3>Reviews</h3>

  <!-- Display reviews dynamically -->
  <?php
include "config/conn.php";

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate and sanitize inputs
    $product_id = intval($_POST['product_id']);
    $reviewer_name = htmlspecialchars(trim($_POST['reviewer_name']), ENT_QUOTES, 'UTF-8');
    $review_text = htmlspecialchars(trim($_POST['review_text']), ENT_QUOTES, 'UTF-8');

    // Check if product ID exists
    $check_query = "SELECT id FROM products WHERE id = ?";
    $stmt = $conn->prepare($check_query);
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // Insert review into the database
        $insert_query = "INSERT INTO product_reviews (product_id, reviewer_name, review_text) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($insert_query);
        $stmt->bind_param("iss", $product_id, $reviewer_name, $review_text);

        if ($stmt->execute()) {
            $message = "Your review has been submitted successfully!";
        } else {
            $message = "Error: " . $conn->error;
        }
    } else {
        $message = "Invalid product ID.";
    }
}

// Fetch reviews for the product
$product_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$reviews = [];
if ($product_id > 0) {
    $query = "SELECT * FROM product_reviews WHERE product_id = ? ORDER BY review_date DESC";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $reviews[] = $row;
    }
}
?>


    <div id="reviewSection">
        
        <?php if (!empty($reviews)): ?>
            <?php foreach ($reviews as $review): ?>
                <div class='review-comment'>
                    <div class='user-name'><?php echo htmlspecialchars($review['reviewer_name'], ENT_QUOTES, 'UTF-8'); ?></div>
                    <div class='comment-text'><?php echo htmlspecialchars($review['review_text'], ENT_QUOTES, 'UTF-8'); ?></div>
                    <div class='comment-date'><?php echo htmlspecialchars($review['review_date'], ENT_QUOTES, 'UTF-8'); ?></div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No reviews yet. Be the first to leave a review!</p>
        <?php endif; ?>
    </div>

    <div class="add-review">
        <h3>Leave a Review</h3>
        <?php if (isset($message)): ?>
            <p><?php echo htmlspecialchars($message, ENT_QUOTES, 'UTF-8'); ?></p>
        <?php endif; ?>
        <form method="POST" action="">
            <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($product_id); ?>">
            <input type="text" name="reviewer_name" placeholder="Your Name" required>
            <textarea name="review_text" rows="4" placeholder="Write a review..." required></textarea>
            <button type="submit">Submit Review</button>
        </form>
    </div>
</div>

  </div>

 
<div class="shop-list">
    <p style="display: flex; justify-content:center; font-size:1.8rem">Related Product</p>
    <div class="shop-list-divider">
      <div class="shop-list-divider-box">
        <div>
          <img src="img/6.jpg" alt="Product">
        </div>
        <div class="sale">Sale</div>
        <span><i class="fas fa-cart-plus"></i> Add to Cart</span>
        <p class="price-name">Energy Battery</p>
        <div class="price-tag d-flex justify-content-space-between">
        <div class="old-price">$300</div>
        <div class="price">$300</div>
        </div>      </div>
      <div class="shop-list-divider-box">
        <div>
          <img src="img/3.jpg"  alt="Product">
        </div>
        
        <span><i class="fas fa-cart-plus"></i> Add to Cart</span>
        <p class="price-name">Energy Battery</p>
        <div class="price-tag d-flex justify-content-space-between">
        <div class="old-price">$300</div>
        <div class="price">$300</div>
        </div>
              </div>
      <div class="shop-list-divider-box">
        <div>
          <img src="img/5.jpg" alt="Product">
        </div>
        <div class="sale">Sale</div>
        <span><i class="fas fa-cart-plus"></i> Add to Cart</span>
        <p class="price-name">Energy Battery</p>
        <div class="price-tag d-flex justify-content-space-between">
        <div class="old-price">$300</div>
        <div class="price">$300</div>
        </div>
      </div>
      <div class="shop-list-divider-box">
        <div>
          <img src="img/10.jpg"  alt="Product">
        </div>
        <div class="sale">Sale</div>
        <span><i class="fas fa-cart-plus"></i> Add to Cart</span>
        <p class="price-name">Energy Battery</p>
        <div class="price-tag d-flex justify-content-space-between">
        <div class="old-price">$300</div>
        <div class="price">$300</div>
        </div>
      </div>
            </div>
  </div>
</div>
<!-- Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
  // JavaScript to handle tab switching (Product Description / Reviews)
  const productDescriptionTab = document.getElementById('product-description-tab');
  const reviewsTab = document.getElementById('reviews-tab');
  const productDescriptionSection = document.querySelector('.product-description');
  const reviewsSection = document.querySelector('.product-reviews');

  // Initially show the product description
  productDescriptionSection.classList.add('active');

  productDescriptionTab.addEventListener('click', () => {
    // Show product description and hide reviews
    productDescriptionSection.classList.add('active');
    reviewsSection.classList.remove('active');
  });

  reviewsTab.addEventListener('click', () => {
    // Show reviews and hide product description
    reviewsSection.classList.add('active');
    productDescriptionSection.classList.remove('active');
  });

  // Function to submit a new review
  function submitReview() {
    const reviewerName = document.getElementById('reviewer-name').value;
    const reviewText = document.getElementById('review-text').value;

    if (reviewerName && reviewText) {
      const reviewSection = document.querySelector('.review-section');
      const newReview = document.createElement('div');
      newReview.classList.add('review-comment');
      
      newReview.innerHTML = `
        <div class="user-name">${reviewerName}</div>
        <div class="comment-text">${reviewText}</div>
        <div class="comment-date">Just now</div>
      `;

      reviewSection.appendChild(newReview);

      // Reset input fields
      document.getElementById('reviewer-name').value = '';
      document.getElementById('review-text').value = '';
    } else {
      alert('Please fill in both fields before submitting.');
    }
  }
</script>
  <script>
    // JavaScript for Increment/Decrement Buttons
    const decrementBtn = document.getElementById('decrement');
    const incrementBtn = document.getElementById('increment');
    const quantityInput = document.getElementById('quantity');

    decrementBtn.addEventListener('click', () => {
      let quantity = parseInt(quantityInput.value);
      if (quantity > 1) {
        quantityInput.value = quantity - 1;
      }
    });

    incrementBtn.addEventListener('click', () => {
      let quantity = parseInt(quantityInput.value);
      quantityInput.value = quantity + 1;
    });

    // JavaScript for Color Selection
    const colorOptions = document.querySelectorAll('input[name="color"]');
    colorOptions.forEach(option => {
      option.addEventListener('change', () => {
        console.log('Selected Color:', option.value);
      });
    });

    // JavaScript for Type Selection
    const typeOptions = document.querySelectorAll('input[name="type"]');
    typeOptions.forEach(option => {
      option.addEventListener('change', () => {
        console.log('Selected Type:', option.value);
      });
    });
  </script>

<?php
include('include/footer.php');
?>