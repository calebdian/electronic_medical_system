<?php
session_start(); // Start or resume session

// Initialize variables
$firstName = '';
$email = '';
$phone = '';
$g = 'yes';
// Check if user session exists and retrieve user data
if (isset($_SESSION['user'])) {
    $user = $_SESSION['user'];
    // Assign user data to variables
    $firstName = $user['first_name'];
    $email = $user['email'];
    $phone = $user['phone'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="../css/dashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        /* Base styling */
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            display: flex;
            flex-direction: column;
        }

        .sidebar {
            height: 100vh;
            width: 200px;
            position: fixed;
            top: 0;
            left: 0;
            background-color: #007BFF;
            padding-top: 60px;
            color: #fff;
            display: flex;
            flex-direction: column;
            align-items: center;
            transition: width 0.3s;
        }

        .sidebar h2 {
            margin-bottom: 20px;
            font-size: 24px;
            font-weight: bold;
        }

        .sidebar ul {
            list-style-type: none;
            padding: 0;
            width: 100%;
        }

        .sidebar ul li {
            width: 100%;
        }

        .sidebar ul li a {
            color: #fff;
            text-decoration: none;
            display: flex;
            align-items: center;
            padding: 15px 20px;
            transition: background-color 0.3s, color 0.3s;
        }

        .sidebar ul li a:hover {
            background-color: #0056b3;
            color: #ffcc00;
        }

        .sidebar ul li a i {
            margin-right: 10px;
            transition: transform 0.3s;
        }

        .sidebar ul li a:hover i {
            transform: scale(1.2);
        }

        .main-content {
            margin-left: 250px;
            flex-grow: 1;
            padding-inline: 20px;
        }

        .feature-content {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .feature-content h2 {
            margin-top: 0;
        }

        .sidebar ul li.active a {
            background-color: #0056b3;
            color: #ffcc00;
        }

        /* Responsive styling */
        @media (max-width: 768px) {
            .sidebar {
                width: 200px;
            }
            .main-content {
                margin-left: 200px;
            }
        }

        @media (max-width: 480px) {
            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
            }
            .sidebar ul {
                display: flex;
                flex-wrap: wrap;
                justify-content: center;
            }
            .sidebar ul li {
                width: 50%;
            }
            .main-content {
                margin-left: 0;
                margin-top: 20px;
            }
        }

        @media (max-width: 425px) {
            .sidebar {
                width: 70px;
                align-items: center;
                padding-top: 10px;
            }

            .sidebar h2 {
                display: none;
            }

            .sidebar ul li a {
                justify-content: center;
                padding: 10px 0;
            }

            .sidebar ul li a span {
                display: none;
            }

            .main-content {
                margin-left: 70px;
            }
        }
    </style>
</head>
<body>

<div class="sidebar">
    <h2>EMR System</h2>
    <ul>
        <li class="active"><a href="dashboard.php" class="sidebar-link"><i class="fas fa-tachometer-alt"></i> <span>Dashboard</span></a></li>
        <li><a href="index.php" class="sidebar-link"><i class="fas fa-home"></i> <span>Home</span></a></li>
        <li><a href="about.php" class="sidebar-link"><i class="fas fa-file-medical"></i> <span>About</span></a></li>
        <li><a href="medication.php" class="sidebar-link"><i class="fas fa-receipt"></i> <span>Medication</span></a></li>
        <li><a href="drug_inventory.php" class="sidebar-link"><i class="fas fa-file-alt"></i> <span>Drug Search</span></a></li>
        <li><a href="profile.php" class="sidebar-link"><i class="fas fa-user"></i> <span>Profile</span></a></li>
        <li><a href="login.php" class="sidebar-link"><i class="fas fa-sign-out-alt"></i> <span>Logout</span></a></li>
    </ul>
</div>

<div class="main-content">
    <div class="feature-content">
        <h1>Welcome, <?php echo htmlspecialchars($firstName); ?>!</h1>
        <p>Today's Date: <?php echo date('Y-m-d'); ?></p>
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
                <div class="feature-content">
                    <h1>Welcome, <?php echo htmlspecialchars($firstName); ?>!</h1>
                    <p>Today's Date: <?php echo date('Y-m-d'); ?></p>
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
