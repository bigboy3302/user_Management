    // Show the full-screen image modal
    document.getElementById('imageClick').onclick = function() {
        document.getElementById('imageModal').style.display = 'flex';
    };

    // Close the image modal
    function closeModal() {
        document.getElementById('imageModal').style.display = 'none';
    }

    // Validate form data
    function validateForm() {
        let phone = document.querySelector('input[name="phone"]').value;
        let personalCode = document.querySelector('input[name="personalCode"]').value;

        // Check phone length (assuming it's 8 digits)
        if (phone.length !== 8 || isNaN(phone)) {
            alert("Phone number must be exactly 8 digits.");
            return false;
        }

        // Check personal code length (assuming it's 11 digits)
        if (personalCode.length !== 11 || isNaN(personalCode)) {
            alert("Personal Code must be exactly 11 digits.");
            return false;
        }

        return true;
    }

    // Rotate the page when the button is clicked
    function rotatePage() {
        const table = document.querySelector('table'); // Select the table element
        if (table) {
            table.style.animation = 'rotateTable 2s linear'; // Apply the rotation animation
            table.style.transformOrigin = 'center'; // Ensure rotation happens around the center

            setTimeout(() => {
                table.style.animation = ''; // Reset the animation after it completes
            }, 2000);
        } else {
            console.error('Table element not found.');
        }
    }

    // Fetch and display temperature
    fetch('https://api.open-meteo.com/v1/forecast?latitude=57.31&longitude=25.27&current_weather=true')
        .then(response => response.json())
        .then(data => {
            if (data.current_weather && data.current_weather.temperature) {
                document.getElementById('temperature').textContent = `Temperature: ${data.current_weather.temperature} °C`;
            } else {
                console.error('Temperature data not found in response:', data);
                document.getElementById('temperature').textContent = 'Temperature data not available.';
            }
        })
        .catch(error => {
            console.error('Error fetching temperature:', error);
            document.getElementById('temperature').textContent = 'Error fetching temperature.';
        });

        // Handle delete user form submission
document.getElementById('deleteUserForm').addEventListener('submit', function(event) {
    event.preventDefault();  // Prevent the default form submission

    var formData = new FormData(this);

    // AJAX request to delete_user.php
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'delete_user.php', true);
    xhr.onload = function() {
        if (xhr.status === 200) {
            if (xhr.responseText.trim() === 'success') {
                alert('User deleted successfully!');
                location.reload();  // Reload the page after successful deletion
            } else {
                alert('Error: ' + xhr.responseText);
            }
        } else {
            alert('Request failed. Returned status of ' + xhr.status);
        }
    };
    xhr.send(formData);
});
