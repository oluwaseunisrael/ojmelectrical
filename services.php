<?php
include('include/header.php');
?>
<style>
  .service-header {
    background: url('img/bulb.jpg');
    text-align: center;
    background-repeat: no-repeat;
    height: 500px;
    display: flex;
    justify-content: center;
    align-items: center;
    background-position: center;
    color: white;
    background-size: cover;
    position: relative;
}
</style>

<?php
include "config/conn.php";

// Number of services per page
$servicesPerPage = 5;

// Get the current page from the URL, default to page 1 if not set
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $servicesPerPage;

// Fetch total number of services to calculate total pages
$totalQuery = "SELECT COUNT(*) AS total FROM services";
$totalResult = mysqli_query($conn, $totalQuery);
$totalRow = mysqli_fetch_assoc($totalResult);
$totalServices = $totalRow['total'];

// Calculate total pages
$totalPages = ceil($totalServices / $servicesPerPage);

// Fetch services for the current page
$query = "SELECT * FROM services ORDER BY id ASC LIMIT $servicesPerPage OFFSET $offset";
$result = mysqli_query($conn, $query);
?>

<div class="service-header">
  <h2>Our Services</h2>
</div>

<div class="our-services-home">
  <div class="our-services-home-divider">
    <?php
    $serviceNumber = $offset + 1; // Initialize service number to match the page offset
    while ($row = mysqli_fetch_assoc($result)): 
    ?>
    <div class="our-services-home-box">
      <div class="our-services-home-box-image">
        <img src="uploads/<?php echo htmlspecialchars($row['firstimage']); ?>" alt="Service Image" style="height: 300px;width: 100%; object-fit: cover;">
        <div class="service-number"><?php echo str_pad($serviceNumber++, 2, "0", STR_PAD_LEFT); ?></div>
      </div>
      <div class="our-services-home-box-content">
        <h3><?php echo htmlspecialchars($row['title']); ?></h3>
        <p><?php echo htmlspecialchars($row['subtitle']); ?></p>
        <a href="single-service.php?id=<?php echo $row['id']; ?>">
          <i class="fa fa-arrow-right"></i> Learn more
        </a>
      </div>
    </div>
    <?php endwhile; ?>
  </div>
</div>

<!-- Pagination -->
<div class="modern-pagination-container d-flex justify-content-center mt-5">
  <ul class="modern-pagination">
    <!-- Previous Page -->
    <?php if ($page > 1): ?>
    <li><a href="?page=<?php echo $page - 1; ?>"><i class="bi bi-chevron-left"></i></a></li>
    <?php endif; ?>

    <!-- Page Numbers -->
    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
    <li><a href="?page=<?php echo $i; ?>" class="<?php echo $i == $page ? 'active' : ''; ?>"><?php echo $i; ?></a></li>
    <?php endfor; ?>

    <!-- Next Page -->
    <?php if ($page < $totalPages): ?>
    <li><a href="?page=<?php echo $page + 1; ?>"><i class="bi bi-chevron-right"></i></a></li>
    <?php endif; ?>
  </ul>
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

<?php
include('include/footer.php');
?>
