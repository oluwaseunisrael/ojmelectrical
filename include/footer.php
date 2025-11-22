  <!-- Footer Section -->
  <style >
      
  </style>
    <div class="footer">
     
        <div class="footer-lower">
            <div class="footer-lower-one">
                <div class="logo">
                    <img src="img/logo1.png">
                </div>
                <p>Our company specializes in electrical wiring and repair. We carry out any projects with our hearts and are not afraid of difficulties.</p>
                <div class="icon">
                    <a href="https://www.facebook.com/Ojmelectricalcompany?mibextid=ZbWKwL
"><i class="fab fa-facebook"></i></a>
                <a href="https://x.com/ojmelectrical
">    <i class="fab fa-twitter"></i></a>
                 <a href="https://youtube.com/@ojmelectricalcompany?si=FxZhvlxCVw694O24 ">   <i class="fab fa-youtube"></i></a>
           <a href="https://www.instagram.com/ojmelectrical/profilecard/?igsh=bnMwMXBsN3l1azMz
">         <i class="fab fa-instagram"></i></a>
  <a href="https://bit.ly/contact_ojm 
">         <i class="fab fa-whatsapp"></i></a>
                </div>
            </div>
            <div class="footer-lower-two">
                
                <div class="ul">
                    <ul>
                        <h2>Site Navigation</h2>
                        <li><i class="fas fa-circle"></i> <a href="#">Home</a></li>
                        <li><i class="fas fa-circle"></i> <a href="#">About</a></li>
                        <li><i class="fas fa-circle"></i> <a href="#">Services</a></li>
                        <li><i class="fas fa-circle"></i> <a href="#">Blog</a></li>
                        <li><i class="fas fa-circle"></i> <a href="#">Shop</a></li>
                        <li><i class="fas fa-circle"></i> <a href="#">Contact</a></li>
                    </ul>
                </div>
            </div>
            <div class="footer-lower-three">
                
                <div class="ul">
                    <ul>
                        <h2>Useful Links</h2>
                        <li><i class="fas fa-circle"></i> <a href="#">Privacy & Policy</a></li>
                        <li><i class="fas fa-circle"></i> <a href="#">Testimonial</a></li>
                        <li><i class="fas fa-circle"></i> <a href="#">Gallery</a></li>
                        <li><i class="fas fa-circle"></i> <a href="#">FAQ</a></li>
                        <li><i class="fas fa-circle"></i> <a href="#">Terms</a></li>
                        <li><i class="fas fa-circle"></i> <a href="#">Book Now</a></li>
                    </ul>
                </div>
            </div>
           <?php
include "config/conn.php";
$query = "
    SELECT b.id, b.title, b.image, b.content, b.post_category, t.name as tag_name, b.created_at 
    FROM blogposts b 
    LEFT JOIN tags t ON b.post_tags = t.id 
    ORDER BY b.id DESC LIMIT 3";
$result = mysqli_query($conn, $query);
?>
<div class="footer-lower-four">
    <h2>Latest News</h2>
    <div class="blog-detail">
        <?php if (mysqli_num_rows($result) > 0): ?>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <div class="blog-detail-box">
                <!-- Blog Image -->
                <div class="img" style="width: 80px; height: 80px; overflow: hidden;">
                    <img src="uploads/<?php echo htmlspecialchars($row['image']); ?>" 
                         alt="Blog Image" 
                         style="width: 100%; height: 100%; object-fit: cover;">
                </div>
                <!-- Blog Content -->
                <div class="blog-detail-content">
                    <p><?php echo htmlspecialchars($row['title']); ?></p>
                    <span><?php echo date('F d, Y', strtotime($row['created_at'])); ?></span>
                </div>
            </div>
            <?php endwhile; ?>
        <?php else: ?>
            <!-- Display a message if no news is available -->
            <p>No latest news available. Check back soon!</p>
        <?php endif; ?>
    </div>


</div>
</div>

        <div class="footer-main-lower">
            <p style="font-size: 17px;">© 2020 All rights reserved. Developed at OJM.</p>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
 <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
   
     <script src="js/ajax.js"></script>
     <script src="js/mains.js"></script>
      <script src="js/major.js"></script>
      <script src="js/scripts.js"></script>

  </body>
</html>