<?php
include('include/header.php');

$sql = "SELECT id, title FROM services";  // Adjust your query as per the schema
$result = mysqli_query($conn, $sql);

// Fetch all services
$services = [];
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $services[] = $row; // Store each service as an array
    }
}

// Close connection
mysqli_close($conn);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Electrical Estimate Request</title>
    <link rel="stylesheet" href="styless.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- Include jQuery -->
    <style>
       
.form-container {
    background-color: white;
    padding: 20px;
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
    width: 100%
    border-radius: 8px;
    margin: 60px 0%;
}

h1 {
    text-align: center;
    margin-bottom: 20px;
    color: #333;
}

label {
    font-size: 14px;
    color: #333;
    margin-bottom: 6px;
    display: block;
}

input[type="text"], input[type="email"], select, textarea {
    width: 100%;
    padding: 10px;
    margin-bottom: 15px;
    border: 1px solid #ccc;
    border-radius: 4px;
    font-size: 14px;
}

textarea {
    resize: vertical;
}

.button-3 {
    background-color: #4CAF50;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 4px;
    font-size: 16px;
    width: 100%;
    cursor: pointer;
    transition: background-color 0.3s;
}

.button-3:hover {
    background-color: #45a049;
}

    </style>
</head>
<body>
    <div class="form-container">
        <h1>Free Estimate Request</h1>
        <form id="estimate-form" method="POST">
            <label for="name">Full Name:</label>
            <input type="text" id="name" name="name" required>

            <label for="email">Email Address:</label>
            <input type="email" id="email" name="email" required>

            <label for="phone">Phone Number:</label>
            <input type="text" id="phone" name="phone" required>

            <label for="address">Service Address:</label>
            <input type="text" id="address" name="address" required>

            <label for="service">Type of Service Needed:</label>
            <select id="service" name="service" required>
                <option value="">Select a Service</option>
                <?php
                // Populate the dropdown with services from the database
                foreach ($services as $service) {
                    echo "<option value='" . $service['id'] . "'>" . $service['title'] . "</option>";
                }
                ?>
            </select>

            <label for="details">Additional Details:</label>
            <textarea id="details" name="details" rows="4" placeholder="Provide any additional information..." required></textarea>

            <button type="submit" class="button-3">Submit Request</button>
        </form>

        <div id="response-message" style="display: none;"></div> <!-- For success/error message -->
    </div>

    <script>
        $(document).ready(function () {
            $('#estimate-form').on('submit', function (e) {
                e.preventDefault(); // Prevent the form from submitting the traditional way

                // Gather the form data
                var formData = $(this).serialize();

                // Send the form data using AJAX
                $.ajax({
                    type: 'POST',
                    url: 'submit_estimate.php',
                    data: formData,
                    success: function (response) {
                        // Display a success message or handle the response
                        $('#response-message').html(response).show();
                        $('#estimate-form')[0].reset(); // Reset the form
                    },
                    error: function () {
                        $('#response-message').html('An error occurred while submitting the form.').show();
                    }
                });
            });
        });
    </script>
</body>
</html>
<?php
include('include/footer.php');
?>