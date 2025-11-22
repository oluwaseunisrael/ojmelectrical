<?php    

include 'includes/header.php';




?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Custom CSS -->
    <link href="css/dashboard.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script>
    <style>
        .greeting {
            font-size: 1.5rem;
            font-weight: bold;
            color: #333;
        }
        .greeting i {
            margin-right: 10px;
        }
        .clock {
            font-size: 2rem;
            color: #555;
            margin-left: 15px;
        }
    </style>
</head>
<body>
    <main>
        <div class="container-fluid">
            <h1 class="mt-4">Dashboard</h1>

            <!-- Cards for Summary -->
            <div class="row">
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-primary text-white mb-4">
                        <div class="card-body">Attendance</div>
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <span id="totalAttendance"></span>
                            <i class="fas fa-calendar-check"></i>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-success text-white mb-4">
                        <div class="card-body">Total Members</div>
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <span id="totalMembers"></span>
                            <i class="fas fa-users"></i>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-warning text-white mb-4">
                        <div class="card-body">Audio Management</div>
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <span id="audioManagement"></span>
                            <i class="fas fa-music"></i>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-danger text-white mb-4">
                        <div class="card-body">Book Management</div>
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <span id="bookManagement"></span>
                            <i class="fas fa-book"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Additional Summary Cards -->
            <div class="row">
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-info text-white mb-4">
                        <div class="card-body">Payment Summary</div>
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <span id="paymentSummary"></span>
                            <i class="fas fa-credit-card"></i>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-dark text-white mb-4">
                        <div class="card-body">Notifications</div>
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <span id="notifications"></span>
                            <i class="fas fa-bell"></i>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-secondary text-white mb-4">
                        <div class="card-body">Event Management</div>
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <span id="eventManagement"></span>
                            <i class="fas fa-calendar-alt"></i>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-primary text-white mb-4">
                        <div class="card-body">SMS Management</div>
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <span id="smsManagement"></span>
                            <i class="fas fa-sms"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts -->
            <div class="row">
                <div class="col-xl-6 col-lg-12">
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-calendar-week me-1"></i>
                            Monthly Attendance
                        </div>
                        <div class="card-body">
                            <canvas id="attendanceChart"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-12">
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-dollar-sign me-1"></i>
                            Monthly Payments
                        </div>
                        <div class="card-body">
                            <canvas id="paymentChart"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-12">
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-user-tag me-1"></i>
                            Member Categories
                        </div>
                        <div class="card-body">
                            <canvas id="memberChart"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-12">
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-calendar-day me-1"></i>
                            Monthly Birthdays
                        </div>
                        <div class="card-body">
                            <canvas id="birthdayChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- JavaScript and Chart.js Scripts -->
    <script>
        const ctxAttendance = document.getElementById('attendanceChart').getContext('2d');
        new Chart(ctxAttendance, {
            type: 'bar',
            data: {
                labels: [], // Replace with actual data
                datasets: [] // Replace with actual data
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Attendance Count'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Month'
                        }
                    }
                },
                plugins: {
                    legend: {
                        position: 'top'
                    },
                    title: {
                        display: true,
                        text: 'Monthly Attendance Breakdown'
                    }
                }
            }
        });
    </script>
</body>
</html>
<?php    

include 'includes/footer.php';




?>