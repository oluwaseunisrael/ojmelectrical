<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login & Registration Form</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
  <div class="container-fluid d-flex justify-content-center align-items-center" style="height: 100vh;">
    <div class="col-md-6 col-lg-4">
      <div class="card shadow-lg">
        <div class="card-body">
          <!-- Toggle Buttons -->
          <ul class="nav nav-pills mb-3" id="formTabs" role="tablist">
            <li class="nav-item">
              <a class="nav-link active" id="login-tab" data-bs-toggle="pill" href="#login" role="tab" aria-controls="login" aria-selected="true">Login</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="register-tab" data-bs-toggle="pill" href="#register" role="tab" aria-controls="register" aria-selected="false">Register</a>
            </li>
          </ul>

          <!-- Tab Content -->
          <div class="tab-content" id="formTabsContent">
            <!-- Login Form -->
            <div class="tab-pane fade show active" id="login" role="tabpanel" aria-labelledby="login-tab">
              <form method="POST" action="customerlogin.php">
                <?php
                session_start();
                if (isset($_SESSION['message'])) {
                    echo '<div class="alert alert-info">' . $_SESSION['message'] . '</div>';
                    unset($_SESSION['message']);  // Clear message after displaying it
                }
                ?>
                <div class="form-group mb-3">
                  <label for="loginEmail">Email</label>
                  <input type="email" class="form-control" id="loginEmail" name="email" placeholder="Enter your email" required>
                </div>
                <div class="form-group mb-3">
                  <label for="loginPassword">Password</label>
                  <input type="password" class="form-control" id="loginPassword" name="password" placeholder="Enter your password" required>
                </div>
                
                <!-- Remember Me and Forgot Password -->
                <div class="form-check mb-3">
                  <input type="checkbox" class="form-check-input" id="rememberMe" name="remember">
                  <label class="form-check-label" for="rememberMe">Remember Me</label>
                </div>
                <div class="mb-3 text-end">
                  <a href="forgot_password.php">Forgot Password?</a>
                </div>
                
                <button type="submit" name="login" class="btn btn-primary w-100">Login</button>
              </form>
            </div>

            <!-- Registration Form -->
            <div class="tab-pane fade" id="register" role="tabpanel" aria-labelledby="register-tab">
              <form method="POST" action="customerregister.php">
                <?php
                if (isset($_SESSION['message'])) {
                    echo '<div class="alert alert-info">' . $_SESSION['message'] . '</div>';
                    unset($_SESSION['message']);  // Clear message after displaying it
                }
                ?>
                <div class="form-group mb-3">
                  <label for="name">Full Name</label>
                  <input type="text" class="form-control" id="name" name="name" placeholder="Enter your full name" required>
                </div>
                
                <div class="form-group mb-3">
                  <label for="registerEmail">Email</label>
                  <input type="email" class="form-control" id="registerEmail" name="email" placeholder="Enter your email" required>
                </div>
                
                <div class="form-group mb-3">
                  <label for="registerPassword">Password</label>
                  <input type="password" class="form-control" id="registerPassword" name="password" placeholder="Enter your password" required>
                </div>
                
                <div class="form-group mb-3">
                  <label for="confirmPassword">Confirm Password</label>
                  <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" placeholder="Confirm your password" required>
                </div>
                
                <button type="submit" name="register" class="btn btn-primary w-100">Register</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap JS and jQuery -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
