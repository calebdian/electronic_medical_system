<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- Include your dashboard.css -->
    <link rel="stylesheet" href="../css/dashboard.css">
    <style>
        /* Sidebar Styling */
        .sidebar {
            height: 100vh;
            width: fit-content;
            position: fixed;
            top: 0;
            left: 0;
            background-color: #007BFF; /* Update navbar background color */
            padding-top: 60px; /* Adjust top padding for the top panel */
            color: #fff;
        }

        .sidebar ul {
            list-style-type: none;
            padding: 0;
        }

        .sidebar ul li {
            margin-bottom: 10px; /* Add margin between each sidebar tab */
        }

        .sidebar ul li a {
            color: #fff;
            text-decoration: none;
            display: block;
        }

        .sidebar ul li a:hover {
            color: #ffcc00;
        }
        /* Top Panel Styling */
        .top-panel {
            width: 100%;
            background-color: #222;
            padding: 10px;
            text-align: center;
            margin-bottom: 0;
            z-index: 1000; /* Ensure the top panel is above other content */
        }

        .top-panel h2 {
            margin: 0;
            padding: 0;
            font-size: 24px;
        }

        .top-panel p {
            margin: 0;
            padding: 0;
            font-size: 14px;
        }

        /* Main Content Styling */
        .main-content {
            margin-left: 200px; /* Adjust margin to accommodate the sidebar width */
            overflow: hidden;
            padding: 0;
        }

        /* Feature Content Styling */
        .feature-content {
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .feature-content h2 {
            font-size: 20px;
            margin-bottom: 10px;
        }

        .feature-content p {
            font-size: 16px;
            line-height: 1.6;
        }
    </style>
</head>
<body>

<div class="top-panel" style="color:white;">
    <h2>EMR System</h2>
</div>
<div class="body-content">
    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Top Panel -->
        <h2>EMR System</h2>

        <ul>
            <li><a href="dashboard.php" class="sidebar-link"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
            <li><a href="index.php" class="sidebar-link"><i class="fas fa-home"></i> Home</a></li>
            <li><a href="about.php" class="sidebar-link"><i class="fas fa-info-circle"></i> About</a></li>
            <li><a href="approval.php" class="sidebar-link"><i class="fas fa-check-circle"></i> Approved Records</a></li>
            <li><a href="checkQueries.php" class="sidebar-link"><i class="fas fa-search"></i> Check Queries</a></li>
            <li><a href="profile.php" class="sidebar-link"><i class="fas fa-user"></i> Profile</a></li>
            <li><a href="login.php" class="sidebar-link"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Top Panel -->
        <div class="tp-panel">
            <h1>Welcome, Admin!</h1>
            <p>Today's Date: <?php echo date('Y-m-d'); ?></p>
        </div>
        <!-- Feature Content Area -->
     <div class="feature-content">
        <h2>Medical Records</h2>
        <p>Your medical records will be displayed here.</p>
    </div>
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
                <div class="main-content" style='text-align:left;'>
                <!-- Top Panel -->
                <div class="tp-panel">
                    <h1>Welcome, Admin!</h1>
                    <p>Today's Date: <?php echo date('Y-m-d'); ?></p>
                </div>
                <!-- Feature Content Area -->
                <div class="feature-content">
                    <h2>Medical Records</h2>
                    <p>Your medical records will be displayed here.</p>
                </div>
            </div>
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
