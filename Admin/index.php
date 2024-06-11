<?php
session_start(); // Start or resume session

// Initialize variables
$firstName = '';
$email = '';
$phone = '';
// Check if user session exists and retrieve user data
if (isset($_SESSION['user'])) {
    $user = $_SESSION['user'];
    // Assign user data to variables
    $firstName = $user['first_name'];
    $email = $user['email'];
    $phone = $user['phone'];
}

// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "electronic_medical_system";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch unchecked queries and response texts
$sql = "SELECT * FROM user_queries WHERE checked_status = 0";
$result = $conn->query($sql);
$notificationCount = $result->num_rows;
$notifications = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $notifications[] = $row;
    }
}

// Close connection
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EMR System - Admin Homepage</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <style>
          /* Modal Styling */
          .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.4);
        }
        

        .modal-content {
            background-color: #fff;
            margin: 15% auto;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            width: 80%;
            max-width: 600px;
        }
        .modal-content.modale{
            width: fit-content;
        }
        /* Close button */
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
        /* Reset default margin and padding */
body, h1, h2, h3, p, ul, li {
    margin: 0;
    padding: 0;
}

/* Global styles */
body {
    font-family: Arial, sans-serif;
    line-height: 1.6;
    background-color: #fff; /* Set a light background color for the body */
    color: #333; /* Set default text color */
}

.container {
    max-width: 960px;
    margin: 0 auto;
    padding: 0 20px;
}

/* Navbar */
.navbar {
    background-color: #007BFF; /* Update navbar background color */
    color: #fff;
    padding: 15px 20px; /* Adjust padding for navbar */
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.nav-links {
    display: flex;
    list-style: none;
    padding: 0;
    margin: 0;
}

.nav-links li {
    margin-right: 20px;
}

.nav-links a {
    color: #fff;
    text-decoration: none;
    font-weight: bold;
    transition: color 0.3s ease;
}

.nav-links a:hover {
    color: #00bcd4;
}

.logo {
    font-size: 24px;
    font-weight: bold;
    text-decoration: none;
    color: #fff;
}

/* Hamburger Icon for Mobile */
.menu-icon {
    display: none; /* Initially hide on larger screens */
    cursor: pointer;
}

/* Media Query for Responsive Navbar */
@media screen and (max-width: 768px) {
    .nav-links {
        display: none; /* Hide nav links by default on smaller screens */
        flex-direction: column;
        align-items: flex-start;
        position: absolute;
        top: 60px;
        left: 0;
        width: 100%;
        background-color: #007BFF; /* Update background color for mobile nav */
        padding: 10px 20px;
        z-index: 1000;
    }

    .nav-links.show {
        display: flex; /* Show nav links when menu icon is clicked */
    }

    .nav-links li {
        margin-right: 0;
        margin-bottom: 10px;
    }

    .menu-icon {
        display: block; /* Show menu icon on smaller screens */
    }
}

/* Hero Section */
.hero {
    background-color: #f9f9f9;
    padding: 100px 0;
    text-align: center;
}

.hero h1 {
    font-size: 36px;
    margin-bottom: 20px;
}
.hero p {
    font-size: 18px;
    margin-bottom: 30px;
}

.btn {
    display: inline-block;
    padding: 10px 20px;
    background-color: #007BFF; /* Update button background color */
    color: #fff;
    text-decoration: none;
    border-radius: 5px;
    transition: background-color 0.3s ease;
}

.btn:hover {
    background-color: #0056b3; /* Darker shade on hover */
}
.hero-image img {
    max-width: 100%;
    height: auto;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}
/* Features Section */
.features {
    padding: 80px 0;
    text-align: center;
}

.feature-item {
    margin-bottom: 40px;
}

/* FAQ Section */
.faq {
    background-color: #f9f9f9;
    padding: 80px 0;
    text-align: center;
}

.faq-item {
    margin-bottom: 40px;
    border-bottom: 1px solid #ccc;
    padding-bottom: 20px;
 }
 .faq-item h3 {
     cursor: pointer;
 }
 .faq-item p {
     display: none;
}

/* Footer */
.footer {
    background-color: #007BFF; /* Update footer background color */
    color: #fff;
    text-align: center;
    padding: 30px 0;
}

.social-links {
    list-style: none;
    padding: 0;
    display: flex;
    justify-content: center;
}

.social-links li {
    margin-right: 10px;
}

.social-links a {
    color: #fff;
    font-size: 24px;
    text-decoration: none;
}

.footer-links {
    list-style: none;
    padding: 0;
    display: flex;
    justify-content: center;
    margin-top: 20px;
}

.footer-links li {
    margin-right: 20px;
}

.footer-links a {
    color: #fff;
    text-decoration: none;
    font-weight: bold;
    transition: color 0.3s ease;
}

.footer-links a:hover {
    color: #00bcd4;
}
.notification-container {
    position: relative;
}

.notification-icon {
    position: relative;
    cursor: pointer;
    font-size: 26px;
}

.notification-count {
    position: absolute;
    top: -8px;
    right: -8px;
    background-color: red;
    color: white;
    border-radius: 50%;
    padding: 4px 8px;
    font-size: 12px;
}

.notification-popup {
    display: none;
    position: absolute;
    top: 100%;
    right: 0;
    width: 300px;
    background-color: #fff;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    border-radius: 4px;
    padding: 10px;
    z-index: 1000;
    color: black;
}

.notification-popup.show {
    display: block;
}

.notification-popup h3 {
    margin-bottom: 10px;
}

.notification-popup ul {
    list-style: none;
    padding: 0;
}

.notification-popup ul li {
    margin-bottom: 10px;
}

.notification-popup ul li strong {
    font-weight: bold;
}
    </style>
</head>
<body>
 <!-- Navbar -->
 <nav class="navbar">
    <a href="#" class="logo">EMR System</a>
    <ul class="nav-links" id="navLinks">
        <li><a href="dashboard.php">Dashboard</a></li>
        <li><a href="index.php">Home</a></li>
        <li><a href="about.php">About</a></li>
        <li><a href="approval.php">Approval</a></li>
        <li><a href="checkQueries.php">User Queries</a></li>
    </ul>
    <div class="menu-icon" onclick="toggleMenu()">
        <svg viewBox="0 0 100 80" width="40" height="40">
            <rect width="100" height="15"></rect>
            <rect y="30" width="100" height="15"></rect>
            <rect y="60" width="100" height="15"></rect>
        </svg>
    </div>

    <!-- User Profile Icon and Popup Container -->
    <div class="profile-icon-container">
        <i class="fas fa-user-circle fa-lg"></i>
        <div class="profile-popup">
            <p><strong><?php echo "admin";?></strong></p>
           
            <!-- Add more user details here -->
        </div>
        
    </div>

     <!-- Notification icon with popup -->
<div class="notification-container">
    <div class="notification-icon" onclick="toggleNotifications()" onmouseover="toggleNotifications()">
        <i class="fas fa-bell" style="font-size: 24px;"></i>
        <?php if ($notificationCount > 0): ?>
            <span class="notification-count"><?php echo $notificationCount; ?></span>
        <?php endif; ?>
    </div>
   <!-- Updated notification popup -->
<div class="notification-popup" id="notificationPopup" onmouseout="closeNotifications()">
    <?php if ($notificationCount > 0): ?>
        <h3>Unchecked Queries</h3>
        <ul>
            <?php foreach ($notifications as $notification): ?>
                <li>
                    <strong>Query:</strong> <?php echo $notification['query_text']; ?><br>
                    <strong>Response:</strong> <?php echo $notification['response_text']; ?>
                    <!-- Add view and dismiss buttons -->
                    <div>
                        <button onclick="viewNotification(<?php echo $notification['query_id']; ?>)">View</button>
                        <button onclick="dismissNotification(<?php echo $notification['query_id']; ?>)">Dismiss</button>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>No unchecked queries.</p>
    <?php endif; ?>
    <!-- Close button -->
    <span class="close" onclick="closeNotifications()">&times;</span>
</div>
</div>

    <div class="logo">
            <button onclick="openLogin()">Login</button>
        </div>
</nav>



<!-- Hero Section -->
<section class="hero">
    <div class="container">
        <div class="hero-content">
            <div class="hero-text">
                <h1>Welcome to Our Electronic Medical Records System</h1>
                <p>Manage your health records securely and efficiently.</p>
                <a href="#features" class="btn">Learn More</a>
            </div>
           \
        </div>
    </div>
</section>

<!-- Features Section -->
<section id="features" class="features">
    <div class="container">
        <h2>Key Features</h2>
        <div class="feature-item">
            <h3>Secure Access Anytime, Anywhere</h3>
            <p>Access your medical records securely from any device.</p>
        </div>
        <div class="feature-item">
            <h3>Real-time Updates</h3>
            <p>Receive real-time updates on your health status and treatments.</p>
        </div>
        <div class="feature-item">
            <h3>Appointment Scheduling</h3>
            <p>Book and manage appointments online.</p>
        </div>
    </div>
</section>

<!-- FAQ Section -->
<section id="faq" class="faq">
<div class="container">
        <h2>Frequently Asked Questions</h2>
        <div class="faq-item">
            <h3 onmouseover="toggleAnswer(this)" onmouseout="closeAnswer(this)">How do I access my medical records?</h3>
            <p>You can log in to our system using your email and password to access your records.</p>
        </div>
        <div class="faq-item">
            <h3 onmouseover="toggleAnswer(this)" onmouseout="closeAnswer(this)">Is my data secure?</h3>
            <p>Yes, we use advanced security measures to protect your health information.</p>
        </div>
        <div class="faq-item">
            <h3 onmouseover="toggleAnswer(this)" onmouseout="closeAnswer(this)">Can I update my personal information?</h3>
            <p>Yes, you can update your information through your account settings.</p>
        </div>
    </div>
</section>

<!-- Footer -->
<footer id="contact" class="footer">
    <div class="container">
        <p>&copy; 2024 EMR System. All rights reserved.</p>
        <ul class="social-links">
            <li><a href="#"><i class="fab fa-facebook"></i></a></li>
            <li><a href="#"><i class="fab fa-twitter"></i></a></li>
            <li><a href="#"><i class="fab fa-linkedin"></i></a></li>
            <li><a href="#"><i class="fab fa-instagram"></i></a></li>
            <li><a href="#"><i class="fab fa-youtube"></i></a></li>
        </ul>
        <ul class="footer-links">
            <li><a href="#">Terms of Service</a></li>
            <li><a href="#">Privacy Policy</a></li>
            <li><a href="#">Accessibility</a></li>
            <li><a href="#">Contact Us</a></li>
        </ul>
    </div>
</footer>

<!-- Link Font Awesome Icons (Add to head section) -->
<script src="https://kit.fontawesome.com/a076d05399.js"></script>

<!-- Signup Modal -->
<div id="signupModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <!-- Include signup form here -->
        <?php include('signup.php'); ?>
    </div>
</div>
<!-- Signup Modal -->
<div id="loginModal" class="modal modale">
    <div class="modal-content modale">
        <span class="close" onclick="closeLogin()">&times;</span>
        <!-- Include signup form here -->
        <?php include('login.php'); ?>
    </div>
</div>

<!-- JavaScript to handle modal -->
<script>
    function toggleMenu() {
        var navLinks = document.getElementById("navLinks");
        navLinks.classList.toggle("show");
    }

    function openModal() {
        document.getElementById('signupModal').style.display = 'block';
    }

    function closeModal() {
        document.getElementById('signupModal').style.display = 'none';
    }

    function openLogin() {
        document.getElementById('loginModal').style.display = 'block';
    } 

    function closeLogin() {
        document.getElementById('loginModal').style.display = 'none';
    }

    function toggleAnswer(element) {
        var answer = element.nextElementSibling;
        answer.style.display = "block"; // Display the answer when hovering over the question
    }

    function closeAnswer(element) {
        var answer = element.nextElementSibling;
        answer.style.display = "none"; // Hide the answer when mouse leaves the question
    }
        // Function to toggle notification popup
    
    // JavaScript to handle modal and notification
document.addEventListener("DOMContentLoaded", function() {
    // Add click event listener to the notification icon
    var notificationIcon = document.querySelector('.notification-icon');
    notificationIcon.addEventListener('click', function(event) {
        event.stopPropagation(); // Prevent event from bubbling up to the window
        toggleNotifications(); // Toggle notification popup
    });

    // Add click event listener to close notification popup when clicking outside of it
    window.addEventListener('click', function(event) {
        if (!event.target.matches('.notification-icon') && !event.target.closest('.notification-popup')) {
            closeNotifications(); // Close notification popup
        }
    });

    // Add click event listener to close notification popup when clicking on close button
    var closeButton = document.querySelector('.notification-popup .close');
    closeButton.addEventListener('click', function(event) {
        event.stopPropagation(); // Prevent event from bubbling up to the window
        closeNotifications(); // Close notification popup
    });
});

// Function to toggle notification popup
function toggleNotifications() {
    var notificationPopup = document.getElementById("notificationPopup");
    if (notificationPopup.style.display === "none") {
        notificationPopup.style.display = "block";
    } else {
        notificationPopup.style.display = "none";
    }
}

// Function to close notification popup
function closeNotifications() {
    var notificationPopup = document.getElementById("notificationPopup");
    notificationPopup.style.display = "none";
}

</script>

</body>
</html>
