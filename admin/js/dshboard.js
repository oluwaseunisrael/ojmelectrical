document.addEventListener('DOMContentLoaded', function() {
    // Monthly Attendance Chart
    var ctx1 = document.getElementById('attendanceChart').getContext('2d');
    new Chart(ctx1, {
        type: 'bar',
        data: {
            labels: ['January', 'February', 'March', 'April', 'May', 'June'],
            datasets: [{
                label: 'Attendance',
                data: [30, 45, 50, 60, 70, 85],
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Audio Categories Pie Chart
    var ctx2 = document.getElementById('audioCategoriesChart').getContext('2d');
    new Chart(ctx2, {
        type: 'pie',
        data: {
            labels: ['Rock', 'Pop', 'Jazz', 'Classical'],
            datasets: [{
                label: 'Audio Categories',
                data: [300, 150, 100, 50],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)'
                ],
                borderWidth: 1
            }]
        }
    });

    // Payment Trends Line Chart
    var ctx3 = document.getElementById('paymentTrendsChart').getContext('2d');
    new Chart(ctx3, {
        type: 'line',
        data: {
            labels: ['January', 'February', 'March', 'April', 'May', 'June'],
            datasets: [{
                label: 'Payments',
                data: [1000, 1200, 1100, 1500, 1700, 1600],
                backgroundColor: 'rgba(153, 102, 255, 0.2)',
                borderColor: 'rgba(153, 102, 255, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Book Categories Doughnut Chart
    var ctx4 = document.getElementById('bookCategoriesChart').getContext('2d');
    new Chart(ctx4, {
        type: 'doughnut',
        data: {
            labels: ['Fiction', 'Non-Fiction', 'Science', 'History'],
            datasets: [{
                label: 'Book Categories',
                data: [400, 250, 150, 100],
                backgroundColor: [
                    'rgba(255, 159, 64, 0.2)',
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(75, 192, 192, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 159, 64, 1)',
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(75, 192, 192, 1)'
                ],
                borderWidth: 1
            }]
        }
    });

    // Calendar Chart (Time-Based Visualization)
    var ctx5 = document.getElementById('calendarChart').getContext('2d');
    new Chart(ctx5, {
        type: 'line', // Use 'line' or 'bar' for better time-based visualization
        data: {
            datasets: [{
                label: 'Events',
                data: [
                    { x: '2024-09-01', y: 10 },
                    { x: '2024-09-15', y: 20 },
                    { x: '2024-09-30', y: 30 }
                ],
                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 2,
                pointRadius: 5
            }]
        },
        options: {
            scales: {
                x: {
                    type: 'time',
                    time: {
                        unit: 'day',
                        tooltipFormat: 'll', // Format for tooltips
                        displayFormats: {
                            day: 'MMM D'
                        }
                    },
                    title: {
                        display: true,
                        text: 'Date'
                    }
                },
                y: {
                    title: {
                        display: true,
                        text: 'Value'
                    }
                }
            }
        }
    });
});
