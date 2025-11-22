
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Dashboard</title>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
        <link href="assest/css/styles.css" rel="stylesheet" />
        <link href="css/css.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/boxicons/2.1.0/css/boxicons.min.css" integrity="sha512-pVCM5+SN2+qwj36KonHToF2p1oIvoU3bsqxphdOIWMYmgr4ZqD3t5DjKvvetKhXGc/ZG5REYTT6ltKfExEei/Q==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/MaterialDesign-Webfont/5.3.45/css/materialdesignicons.css" integrity="sha256-NAxhqDvtY0l4xn+YVa6WjAcmd94NNfttjNsDmNatFVc=" crossorigin="anonymous" />
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<style >
    /* General Styles */
body {
    font-family: Arial, sans-serif;
    background-color: #f8f9fa;
    margin: 0;
    padding: 0;
}

/* Header Styles */
.sb-topnav {
    background-color: #343a40;
    padding: 0.5rem 1rem;
}

.sb-topnav .navbar-brand {
    font-size: 1.5rem;
    color: #ffffff;
}

.sb-topnav .navbar-nav .nav-link {
    color: #ffffff;
}

.sb-topnav .navbar-nav .nav-link:hover {
    color: #adb5bd;
}

.sb-topnav .badge {
    font-size: 0.75rem;
    padding: 0.25rem 0.5rem;
    border-radius: 0.25rem;
}

/* Navbar Dropdown Styles */
.dropdown-menu {
    min-width: 12rem;
}

.dropdown-item {
    color: #495057;
}

.dropdown-item:hover {
    background-color: #e9ecef;
}

/* Sidebar Styles */
.sb-sidenav {
    background-color: #343a40;
    color: #ffffff;
}

.sb-sidenav .nav-link {
    color: #ffffff;
}

.sb-sidenav .nav-link:hover {
    color: #adb5bd;
    background-color: #495057;
}

.sb-nav-link-icon {
    margin-right: 0.5rem;
}

.sb-sidenav .collapse .nav-link {
    color: #e9ecef;
}

.sb-sidenav .collapse .nav-link:hover {
    color: #ffffff;
    background-color: #495057;
}

.sb-sidenav-collapse-arrow {
    font-size: 0.75rem;
    margin-left: 0.5rem;
}

/* Footer Styles */
footer {
    background-color: #e9ecef;
    color: #6c757d;
    padding: 1rem 0;
}

footer .text-muted {
    margin: 0;
}

footer a {
    color: #007bff;
}

footer a:hover {
    text-decoration: underline;
}

/* Additional Styles */
.container-fluid {
    padding: 0 1rem;
}

.d-flex {
    display: flex;
}

.align-items-center {
    align-items: center;
}

.justify-content-between {
    justify-content: space-between;
}

.mt-auto {
    margin-top: auto;
}

</style>
    </head>
    <body class="sb-nav-fixed">
    	<?php include('navbar.php')?>

    	<div id="layoutSidenav">

             <?php include('sidebar.php')?>

          <div id="layoutSidenav_content">
                <main>

    		
    	