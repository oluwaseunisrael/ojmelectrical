<?php
include('include/header.php');
?>

    <?php
        // Database connection
        include('config/conn.php');

        // Get the service ID from the URL
        $service_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

        // Fetch service details
        $query = "SELECT * FROM services WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $service_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        // Check if service exists
        if (!$row) {
            echo "<p>Service not found.</p>";
            exit;
        }
        ?>
<div class="blog-header" style="
    position: relative; 
    background: url('uploads/<?php echo htmlspecialchars($row['firstimage']); ?>') no-repeat center center; 
    background-size: cover; 
    min-height: 500px; 
    border-radius: 0px!important;
    background-position: top center;
    display: flex; 
    align-items: center; 
    justify-content: center; 
    color: white;">
  
  <!-- Overlay -->
  <div style="
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.5); /* Dark overlay */
      z-index: 1;
      border-radius: inherit;"></div>

  <!-- Blog Title -->
  <h1 style="position: relative; z-index: 2; margin: 0 2%"><?php echo htmlspecialchars($row['title']); ?></h1>
</div>
<div class="main-single-service">
  <div class="main-single-service-one">
    <div class="main-single-service-img">
      <img src="uploads/<?php echo htmlspecialchars($row['firstimage']); ?>" alt="Service Image">
        
    </div>
    <div>
     
  <h2 class="h2">Services Overview</h2>
  <p><?php echo nl2br(htmlspecialchars($row['content'])); ?></p>
    </div>
    <div>
      <h2 class="h2">Benefits of Installing</h2>
     <p><?php echo nl2br(htmlspecialchars($row['benefit_content'])); ?></p>
      <div class="main-single-service-gallery">
         <img src="uploads/<?php echo htmlspecialchars($row['benefit_image1']); ?>" alt="Gallery Image">
            <img src="uploads/<?php echo htmlspecialchars($row['benefit_image2']); ?>" alt="Gallery Image">
            <img src="uploads/<?php echo htmlspecialchars($row['benefit_image3']); ?>" alt="Gallery Image">
            <img src="uploads/<?php echo htmlspecialchars($row['benefit_image4']); ?>" alt="Gallery Image">
      </div>
    </div>
    <!--frequent question -->
<div class="container my-5">
    <h2 class="text-center mb-4">Frequently Asked Questions</h2>
    <div class="accordion" id="faqAccordion">

      <!-- Question 1 -->
      <div class="accordion-item">
        <h2 class="accordion-header" id="headingOne">
          <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
            Can I trust your company?
          </button>
        </h2>
        <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#faqAccordion">
          <div class="accordion-body">
            Our team has been developing over the years. Today it includes only highly qualified specialists with experience and their own best practices.
          </div>
        </div>
      </div>

      <!-- Question 2 -->
      <div class="accordion-item">
        <h2 class="accordion-header" id="headingTwo">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
            What influences the price?
          </button>
        </h2>
        <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#faqAccordion">
          <div class="accordion-body">
            The price is influenced by the complexity of the service, the materials required, and the time needed to complete the task. We always strive to provide the best value for our clients.
          </div>
        </div>
      </div>

      <!-- Question 3 -->
      <div class="accordion-item">
        <h2 class="accordion-header" id="headingThree">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
            Do you have discounts?
          </button>
        </h2>
        <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#faqAccordion">
          <div class="accordion-body">
            Yes, we offer seasonal discounts and promotional offers. Please contact us to learn more about ongoing promotions.
          </div>
        </div>
      </div>

      <!-- Question 4 -->
      <div class="accordion-item">
        <h2 class="accordion-header" id="headingFour">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
            Are your specialists qualified?
          </button>
        </h2>
        <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#faqAccordion">
          <div class="accordion-body">
            Absolutely! All our specialists are highly qualified, with extensive experience and certifications to ensure top-quality service.
          </div>
        </div>
      </div>
      
    </div>
  </div>


<div class="container my-5">
  <div class="testimonial-box">
    <h2 class="text-center mb-4" style="color: white;">Testimonial</h2>
    <div id="testimonialCarousel" class="carousel slide" data-bs-ride="carousel">
      <div class="carousel-inner">

        <!-- Testimonial 1 -->
        <div class="carousel-item active">
          <div class="testimonial-card">
            <img src="img/team-1.jpg" alt="Client 1" class="testimonial-image">
            <p class="testimonial-text">
              "This is the best service I've ever used. Highly recommend to everyone! The team was super responsive and professional. I was able to get the help I needed in no time, and they really went above and beyond. I am beyond satisfied with my experience and will definitely be using them again in the future!"
            </p>
            <div class="rating">
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
              <i class="fas fa-star-half-alt"></i>
            </div>
            <div class="client-info">
              <h4>Jane Doe</h4>
              <p>Marketing Manager, Example Co.</p>
            </div>
          </div>
        </div>

        <!-- Testimonial 2 -->
        <div class="carousel-item">
          <div class="testimonial-card">
            <img src="https://via.placeholder.com/80" alt="Client 2" class="testimonial-image">
            <p class="testimonial-text">
              "Amazing experience! The team was very professional and helpful. They walked me through every step of the process and made sure all my questions were answered. The quality of work exceeded my expectations, and I’m so glad I decided to go with this company. I highly recommend their services to anyone in need of high-quality support!"
            </p>
            <div class="rating">
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
            </div>
            <div class="client-info">
              <h4>John Smith</h4>
              <p>CEO, Tech Solutions</p>
            </div>
          </div>
        </div>

        <!-- Testimonial 3 -->
        <div class="carousel-item">
          <div class="testimonial-card">
            <img src="https://via.placeholder.com/80" alt="Client 3" class="testimonial-image">
            <p class="testimonial-text">
              "Exceptional service and great value. I will definitely return! From the first point of contact, they made me feel comfortable and assured that I was in good hands. The team provided excellent support, and I couldn't have asked for a better experience. I will certainly recommend them to all my colleagues and friends."
            </p>
            <div class="rating">
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
              <i class="far fa-star"></i>
            </div>
            <div class="client-info">
              <h4>Susan Lee</h4>
              <p>Entrepreneur</p>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>
  </div>

  <div class="main-single-service-two">
    
<div class="container-fluid">
  <!-- Modern Search Bar -->
 <div class="container-fluid ">
    <div class="search-input mx-auto">
      <i class="bi bi-search icon"></i>
      <input type="text" class="form-control" placeholder="Search here...">
    </div>
  </div>
</div>
    <div class="main-single-service-two-categories">
    <h2>Blog Categories</h2>
    <div class="category-services-box">
        <?php
        // Database connection
        include('config/conn.php');

        // Fetch all categories
        $query = "SELECT * FROM categories ORDER BY name ASC";
        $result = $conn->query($query);

        // Check if categories exist
        if ($result->num_rows > 0) {
            // Loop through categories and display
            while ($row = $result->fetch_assoc()) {
                echo '<a href="blog-category.php?category_id=' . $row['id'] . '" class="service-link">' . htmlspecialchars($row['name']) . ' <span class="arrow">→</span></a>';
            }
        } else {
            echo '<p>No categories found.</p>';
        }
        ?>
    </div>
</div>

    <div class="main-single-service-two-booking">
      <h2>Electrical Service</h2>
      <span>Quick arriving in minutes</span>
      <span>24/7 Emergency services</span>
      <span>5 years guarantee</span>
      <button>Book Now</button>
    </div>
  </div>
</div>

<?php
include('include/footer.php');
?>