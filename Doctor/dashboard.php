<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="../css/dashboard.css">
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }
        /* Sidebar Styling */
        .sidebar {
            height: 100vh;
            width: 150px;
            position: fixed;
            top: 0;
            left: 0;
            background-color: #2c3e50;
            padding-top: 60px; /* Adjust top padding for the top panel */
            color: #ecf0f1;
        }
        .sidebar h2 {
            text-align: center;
            color: #ecf0f1;
            margin-bottom: 30px;
        }
        .sidebar ul {
            list-style-type: none;
            padding: 0;
        }
        .sidebar ul li {
            margin-bottom: 20px;
        }
        .sidebar ul li a {
            color: #ecf0f1;
            text-decoration: none;
            display: flex;
            align-items: center;
            padding: 10px;
            transition: background-color 0.3s;
        }
        .sidebar ul li a:hover {
            background-color: #34495e;
            color: #ffcc00;
        }
        .sidebar ul li a .icon {
            margin-right: 10px;
        }
        /* Top Panel Styling */
        .top-panel {
            width: 100%;
            background-color: #34495e;
            padding: 15px;
            text-align: center;
            z-index: 1000; /* Ensure the top panel is above other content */
            color: #ecf0f1;
            position: fixed;
            top: 0;
            left: 0;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .top-panel h2 {
            margin: 0;
            font-size: 24px;
        }
        .top-panel p {
            margin: 0;
            font-size: 14px;
        }
        /* Main Content Styling */
        .main-content {
            margin-left: 200px; /* Adjust margin to accommodate the sidebar width */
            padding: 80px 20px 20px 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .main-content h1 {
            margin-top: 0;
            color: #2c3e50;
        }
        .feature-content h2 {
            margin-top: 0;
            color: #34495e;
        }
        .feature-content p {
            color: #7f8c8d;
        }
    </style>
</head>
<body>

<div class="top-panel">
  
    <h2>EMR System</h2>
</div>

<div class="sidebar">
    <br>
    <h2>EMR System</h2>
    <ul>
        <li><a href="dashboard.php" class="sidebar-link"><i class="fas fa-tachometer-alt icon"></i>Dashboard</a></li>
        <li><a href="index.php" class="sidebar-link"><i class="fas fa-home icon"></i>Home</a></li>
        <li><a href="about.php" class="sidebar-link"><i class="fas fa-home icon"></i>About</a></li>
        <li><a href="prescribe.php" class="sidebar-link"><i class="fas fa-prescription-bottle-alt icon"></i>Prescriptions</a></li>
        <li><a href="answerPosts.php" class="sidebar-link"><i class="fas fa-question-circle icon"></i>Answering Queries</a></li>
        <li><a href="profile.php" class="sidebar-link"><i class="fas fa-user icon"></i>Profile</a></li>
        <li><a href="login.php" class="sidebar-link"><i class="fas fa-sign-out-alt icon"></i>Logout</a></li>
    </ul>
</div>

<div class="main-content" id="main-content">
    <div class="tp">
        <h1>Welcome, Doctor!</h1>
        <p>Today's Date: <?php echo date('Y-m-d'); ?></p>
    </div>
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
                    <div class="tp">
                        <h1>Welcome, Doctor!</h1>
                        <p>Today's Date: ${new Date().toISOString().slice(0, 10)}</p>
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
