$(document).ready(function () {
    $('#subscribe-button').click(function () {
        var email = $('#email-input').val().trim(); // Trim to remove unnecessary spaces

        // Validate email input
        if (email === '') {
            $('#response-message').css('color', 'red').text('Please enter your email address.');
            return;
        }

        // AJAX request
        $.ajax({
            url: 'subscribe.php', // The backend script
            type: 'POST',
            dataType: 'json', // Expect JSON response from the server
            data: { email: email },
            success: function (response) {
                // Handle response
                if (response.success) {
                    // Success case: Set your desired color
                    $('#response-message').css('color', '#f3b612').text(response.message);
                    $('#email-input').val(''); // Clear input field
                } else {
                    // Error case: Use a different color
                    $('#response-message').css('color', 'red').text(response.message);
                }
            },
            error: function (xhr, status, error) {
                $('#response-message').css('color', 'red').text('An error occurred. Please try again.');
                console.error('Error:', error);
            }
        });
    });
});




/** ajax code for free estimation **/
$(document).ready(function () {
    $('#submit-appointment').click(function () {
        // Collect form data
        const formData = {
            name: $('#name').val().trim(),
            email: $('#email').val().trim(),
            phone: $('#phone').val().trim(),
            address: $('#address').val().trim(),
            service: $('#service').val(),
            visitDate: $('#visitDate').val(),
            comment: $('#comment').val().trim(),
        };

        // Basic validation
        if (!formData.name || !formData.email || !formData.address || !formData.visitDate) {
            $('#appointment-response').css('color', 'red').text('Please fill in all required fields.');
            return;
        }

        // AJAX request
        $.ajax({
            url: 'appointment.php', // Backend script
            type: 'POST',
            dataType: 'json', // Expect JSON response
            data: formData,
            success: function (response) {
                if (response.success) {
                    $('#appointment-response')
                        .css('color', '#f3b612')
                        .text(response.message);
                    $('#appointment-form')[0].reset(); // Clear form
                } else {
                    $('#appointment-response')
                        .css('color', 'red')
                        .text(response.message);
                }
            },
            error: function () {
                $('#appointment-response')
                    .css('color', 'red')
                    .text('An error occurred. Please try again later.');
            },
        });
    });
});
