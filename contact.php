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
<div class="service-header">
  <h2>Contact Us</h2>
</div>
<!-- contact us -- one map -->
<div class="contact-one">
  <div class="map">
    <!-- Embed Google Map -->
    <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d15896.27051066039!2d7.3733494!3d5.0927678!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x10429f231b17a1c9%3A0x6e8c0e75fde485e9!2sOjm%20electrical%20company!5e0!3m2!1sen!2sng!4v1732095524727!5m2!1sen!2sng"
      width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
  </div>
</div>


<div class="contact-two">
    <h2>We are ready to answer all your questions</h2>
    <p>We’re here to help! Whether you have a quick question or need detailed assistance, our team is just a message or call away. Don’t hesitate to reach out – your satisfaction is our priority!</p>

    <div class="contact-two-divider">
        <head>
    <!-- Font Awesome CDN for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>

<div class="contact-two-divider-one">
    <div class="contact-info">
        <i class="fa fa-map-marker-alt"></i> <span>Visit us: 42 Okoro road, ABA, Abia state</span>
    </div>
    <div class="contact-info">
        <i class="fa fa-phone"></i> <span>Call us: +2348109494805</span>
    </div>
    <div class="contact-info">
        <i class="fa fa-envelope"></i> <span>Mail us: ojmelectrical@gmail.com</span>
    </div>
    <div class="contact-info">
        <!-- Correct Font Awesome class for WhatsApp -->
        <i class="fab fa-whatsapp"></i>
        <span>
            <a href="https://wa.me/2349028622243" target="_blank">Message us on WhatsApp</a>
        </span>
    </div>
</div>

  <div class="contact-two-divider-two">
  <form id="contact-form">
    <div class="form-row">
      <div class="form-group">
        <label for="name">Name</label>
        <input type="text" id="name" placeholder="Your name">
      </div>
      <div class="form-group">
        <label for="email">Email</label>
        <input type="email" id="email" placeholder="Your email">
      </div>
    </div>

    <div class="form-row">
      <div class="form-group">
        <label for="phone">Phone</label>
        <input type="text" id="phone" placeholder="Your phone">
      </div>
      <div class="form-group">
        <label for="subject">Subject</label>
        <input type="text" id="subject" placeholder="Your Subject">
      </div>
    </div>

    <div class="form-group">
      <label for="message">Message</label>
      <textarea id="message" placeholder="Write your message"></textarea>
    </div>
    <button type="button" id="submit-button" class="btn-submit">Send Message</button>

    <div id="form-response" style="margin-top: 10px;"></div>
  </form>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  $(document).ready(function () {
    $('#submit-button').click(function () {
      var name = $('#name').val().trim();
      var email = $('#email').val().trim();
      var phone = $('#phone').val().trim();
      var subject = $('#subject').val().trim();
      var message = $('#message').val().trim();

      // Validate required fields
      if (name === '' || email === '' || message === '' || phone === '' || subject === '') {
        $('#form-response').css('color', 'red').text('All required fields must be filled out.');
        return;
      }

      // Prepare form data for AJAX
      var formData = {
        name: name,
        email: email,
        phone: phone,
        subject: subject,
        message: message
      };

      // AJAX request
      $.ajax({
        url: 'contact-one.php', // PHP script to handle the form submission
        type: 'POST',
        dataType: 'json',
        data: formData,
        success: function (response) {
          // Handle success
          if (response.success) {
            $('#form-response').css('color', '#28a745').text(response.message); // Green color for success
            $('#contact-form')[0].reset(); // Reset form fields
          } else {
            $('#form-response').css('color', 'red').text(response.message); // Red color for error
          }
        },
        error: function (xhr, status, error) {
          $('#form-response').css('color', 'red').text('An error occurred. Please try again.');
          console.error('Error:', error);
        }
      });
    });
  });
</script>

</div>
</div>
 <!-- Newsletter Subscription Section -->
<div class="newsletter-section ">
    <h2 class="newsletter-title">Subscribe to Our Newsletter</h2>
    <p class="newsletter-subtitle">Get the latest updates and exclusive offers straight to your inbox. Join our community now!</p>

    <!-- Subscription Form -->
    <div class="input-group">
        <input type="email" id="email-input" class="form-control" placeholder="Your e-mail address" aria-label="Your e-mail address">
        <button class="btn btn-subscribe" id="subscribe-button" type="button">Subscribe</button>
    </div>

    <div id="response-message" style="margin-top: 10px; color: green;"></div>
</div>

   


<?php
include('include/footer.php');
?>