<?php
include "config/conn.php";
?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
       <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<link rel="stylesheet" type="text/css" href="css/footers.css">

<link rel="stylesheet" type="text/css" href="css/main.css">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
 <link
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"
        rel="stylesheet"
    />

<!-- Font Awesome CDN -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">


    <title>OJMELECTRICAL COMPANY</title>
    <style >
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
            <button><a href="booknow.php">Book Us Now</a></button>
            <div class="hamburger" onclick="toggleMenu()">
                <div></div>
                <div></div>
                <div></div>
            </div>
        </div>
    </header>