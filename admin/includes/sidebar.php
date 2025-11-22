<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">
                <!-- Dashboard -->
                <a class="nav-link" href="index.php">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Dashboard
                </a>

                <!-- Admin Management -->
                <div class="sb-sidenav-menu-heading">Interface</div>
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#memberLayouts" aria-expanded="false" aria-controls="memberLayouts">
                    <div class="sb-nav-link-icon"><i class="fas fa-user-shield"></i></div>
                    Admin
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="memberLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link" href="admin-table.php">View Admin</a>
                        <a class="nav-link" href="add-admin.php">Add Admin</a>
                    </nav>
                </div>

                <!-- Student Management -->
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#blogcatetagLayouts" aria-expanded="false" aria-controls="blogcatetagLayouts">
                    <div class="sb-nav-link-icon"><i class="fas fa-user-graduate"></i></div>
                    Blog Categories & tags
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="blogcatetagLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link" href="categoryblogtag.php">View Both</a>
                        <a class="nav-link" href="add-tags.php">Add Tags</a>
                         <a class="nav-link" href="categories.php">Add Categories</a>
                    </nav>
                </div>

                <!-- Blog Management -->
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#blogLayouts" aria-expanded="false" aria-controls="blogLayouts">
                    <div class="sb-nav-link-icon"><i class="fas fa-newspaper"></i></div>
                    Blog Management
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="blogLayouts" aria-labelledby="headingThree" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link" href="blogtable.php">View Blog</a>
                        <a class="nav-link" href="add_blog_form.php">Add Blog</a>
                    </nav>
                </div>

                <!-- Blog Header Management -->
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#serviceLayout" aria-expanded="false" aria-controls="serviceLayout">
                    <div class="sb-nav-link-icon"><i class="fas fa-heading"></i></div>
                    Service Management
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="serviceLayout" aria-labelledby="headingFour" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link" href="service-table.php">View Service</a>
                        <a class="nav-link" href="add_service.php">Add Service</a>
                    </nav>
                </div>

                <!-- Blog Slider Management -->
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#blogLayoutSlider" aria-expanded="false" aria-controls="blogLayoutSlider">
                    <div class="sb-nav-link-icon"><i class="fas fa-images"></i></div>
                    Product Management
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="blogLayoutSlider" aria-labelledby="headingFive" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link" href="product-table-sale.php">View Products</a>
                        <a class="nav-link" href="add-product-sale.php">Add Product Sale</a>
                        <a class="nav-link" href="add_category.php">Add Product Category</a>
                        <a class="nav-link" href="product_category_table.php">View Product Category</a>
                    </nav>
                </div>

                <!-- Customer Management -->
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#CustomerLayouts" aria-expanded="false" aria-controls="CustomerLayouts">
                    <div class="sb-nav-link-icon"><i class="fas fa-music"></i></div>
                    Customer Management
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="CustomerLayouts" aria-labelledby="headingSix" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link" href="customer-table.php">View Customer</a>
                        
                    </nav>
                </div>

                <!-- Video Management -->
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#videoLayouts" aria-expanded="false" aria-controls="videoLayouts">
                    <div class="sb-nav-link-icon"><i class="fas fa-video"></i></div>
                    Video Management
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="videoLayouts" aria-labelledby="headingSeven" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link" href="video.php">Add Video</a>
                        <a class="nav-link" href="video-table.php">View Video</a>
                    </nav>
                </div>

                <!-- Courses Management -->
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#courseLayouts" aria-expanded="false" aria-controls="courseLayouts">
                    <div class="sb-nav-link-icon"><i class="fas fa-book"></i></div>
                    Courses Management
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="courseLayouts" aria-labelledby="headingEight" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link" href="courses-table.php">Courses</a>
                        <a class="nav-link" href="faculty-table.php">Faculty</a>
                        <a class="nav-link" href="department-table.php">Department</a>
                    </nav>
                </div>

                <!-- Addons Section -->
                <div class="sb-sidenav-menu-heading">Addons</div>
                <a class="nav-link" href="services-order.php">
                    <div class="sb-nav-link-icon"><i class="fas fa-sms"></i></div>
                   Service Orders
                </a>
                <a class="nav-link" href="notification.php">
                    <div class="sb-nav-link-icon"><i class="fas fa-bell"></i></div>
                    Notification
                </a>
                <a class="nav-link" href="message.php">
                    <div class="sb-nav-link-icon"><i class="fas fa-bullhorn"></i></div>
                    Messages
                </a>
                <a class="nav-link" href="gallery-table.php">
                    <div class="sb-nav-link-icon"><i class="fas fa-image"></i></div>
                    Gallery Uploads
                </a>
                <a class="nav-link" href="view-estimates.php">
                    <div class="sb-nav-link-icon"><i class="fas fa-calendar-check"></i></div>
                    Estimation
                </a>
            </div>
        </div>
    </nav>
</div>
