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
    <title>About Electronic Medical System</title>
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
.about {
    padding: 80px 0;
    text-align: center;
    background-color: #f9f9f9; /* Light background color */
}

.about h2 {
    margin-bottom: 40px;
    font-size: 36px; /* Larger font size for the heading */
    color: #007BFF; /* Heading color */
}

.about p {
    font-size: 18px;
    margin-bottom: 30px; /* Increased bottom margin for better spacing */
    color: #555; /* Darker text color */
    line-height: 1.6; /* Improved readability with increased line height */
}

/* Icon List Styling */
.icon-list {
    list-style-type: none;
    padding: 0;
    max-width: 600px;
    margin: 0 auto;
}

.icon-list li {
    margin-bottom: 20px; /* Increased spacing between list items */
    font-size: 18px; /* Font size for list items */
    color: #444; /* Text color for list items */
    display: flex;
    align-items: center;
}

.icon-list li i {
    margin-right: 10px;
    font-size: 24px; /* Icon size */
    color: #007BFF; /* Icon color */
}

.icon-list li span {
    color: #666; /* Text color */
    font-size: 16px; /* Font size */
}

/* Media Query for Responsive Design */
@media screen and (max-width: 798px) {
    .about h2 {
        font-size: 28px;
    }

    .about p {
        font-size: 16px;
    }

    .icon-list li {
        font-size: 16px;
        margin-left:20%;

    }
}
@media screen and (max-width: 520px){
    .icon-list li {
        font-size: 16px;
        margin-left:10%;
       

    }
}
@media screen and (max-width: 410px){
    .icon-list li {
        font-size: 16px;
        margin-left:0;
        margin-right: 5%;

    }
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
            <p><strong><?php echo "Admin"; ?></strong></p>
           
            <!-- Add more user details here -->
        </div>
        
    </div>
    <div class="logo">
            <button onclick="openLogin()">Login</button>
        </div>
</nav>

    <!-- About Section -->
    <section class="about">
    <div class="container">
        <h2>About Electronic Medical System</h2>
        <p>
            Our Electronic Medical System (EMR) is designed to revolutionize the way healthcare providers manage patient information. 
            We provide a secure and efficient platform for storing and accessing medical records, enabling better patient care and communication.
        </p>
        
        <ul class="icon-list">
        <p style="margin-right:60px;">
            With our EMR system, patients can:
        </p>
        <li><i class="fas fa-check-circle" style="color: green;"></i> Access their medical records anytime, anywhere.</li>
        <li><i class="fas fa-check-circle" style="color: green;"></i> Receive real-time updates on test results and treatment plans.</li>
        <li><i class="fas fa-check-circle" style="color: green;"></i> Book and manage appointments online.</li>
        <li><i class="fas fa-check-circle" style="color: green;"></i> Update personal information securely.</li>
        </ul>
        <p>
            Healthcare providers benefit from streamlined workflows, improved collaboration, and enhanced patient engagement.
        </p>
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
</script>

</body>
</html>