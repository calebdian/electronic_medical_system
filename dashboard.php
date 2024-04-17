<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="css/dashboard.css">
</head>
<body>

<!-- Sidebar -->
<div class="sidebar">
    <h2>EMR System</h2>
    <ul>
        <li><a href="dashboard.php" class="sidebar-link">Dashboard</a></li>
        <li><a href="index.html" class="sidebar-link">Home</a></li>
        <li><a href="medical_report.php" class="sidebar-link">Medical Records</a></li>
        <li><a href="medical_receipt.php" class="sidebar-link">Prescriptions</a></li>
        <li><a href="medical_form.php" class="sidebar-link">Appointments</a></li>
        <li><a href="profile.php" class="sidebar-link">Profile</a></li>
        <li><a href="login.php" class="sidebar-link">Logout</a></li>
    </ul>
</div>

<!-- Main Content -->
<div class="main-content" id="main-content">
    <!-- Top Panel -->
    <div class="top-panel">
        <h1>Welcome, User!</h1>
        <p>Today's Date: <?php echo date('Y-m-d'); ?></p>
    </div>

    <!-- Feature Content Area -->
    <div class="feature-content">
        <h2>Medical Records</h2>
        <p>Your medical records will be displayed here.</p>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Get all sidebar links
    var sidebarLinks = document.querySelectorAll('.sidebar-link');

    // Attach click event listeners to each sidebar link
    sidebarLinks.forEach(function(link) {
        link.addEventListener('click', function(event) {
            event.preventDefault(); // Prevent default link behavior (page navigation)

            var pageUrl = this.getAttribute('href'); // Get the href attribute of the clicked link

            if (pageUrl === 'dashboard.php') {
                // Handle special case for Dashboard link
                // Reset the main content area to its original content
                var originalContent = `
                    <div class="top-panel">
                        <h1>Welcome, User!</h1>
                        <p>Today's Date: <?php echo date('Y-m-d'); ?></p>
                    </div>
                    <div class="feature-content">
                        <h2>Medical Records</h2>
                        <p>Your medical records will be displayed here.</p>
                    </div>
                `;
                document.querySelector('.main-content').innerHTML = originalContent;
            } else {
                // Fetch content from the specified URL using AJAX
                fetch(pageUrl)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.text();
                    })
                    .then(data => {
                        // Update the main content area with the fetched content
                        document.querySelector('.main-content').innerHTML = data;
                    })
                    .catch(error => {
                        console.error('Error fetching content:', error);
                    });
            }
        });
    });
});
</script>

</body>
</html>

</body>
</html>
