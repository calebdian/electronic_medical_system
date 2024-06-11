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
    <title>EMR System - Patient Homepage</title>
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
            display: block;
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
       z-index:1;
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
    position: relative;
}

.hero h1 {
    font-size: 36px;
    margin-bottom: 20px;
}

.hero p {
    font-size: 18px;
    margin-bottom: 30px;
}

.hero .btn {
    display: inline-block;
    padding: 10px 20px;
    background-color: #007BFF;
    color: #fff;
    text-decoration: none;
    border-radius: 5px;
    transition: background-color 0.3s ease;
}

.hero .btn:hover {
    background-color: #0056b3;
}

.hero-image {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    z-index: -1;
}

.hero-image img {
    max-width: 100%;
    height: auto;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.btn:hover {
    background-color: #0056b3; /* Darker shade on hover */
}

/* Features Section */
.features {
    padding: 80px 0;
    text-align: center;
}
.feature-items {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap:10px;
}
.feature-item {
    margin-bottom: 40px;
    background-color: #fff;
    width: 300px; /* Adjust as needed */
    height: auto;
    text-align: center;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}
.feature-item h3 {
    margin-bottom: 10px;
 }
.feature-item p {
    font-size: 16px;
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
.profile-icon-container {
            position: relative;
            display: inline-block;
        }

        .profile-icon-container .fa-user-circle {
            font-size: 2em;
            cursor: pointer;
        }

        .profile-popup {
            display: none;
            position: absolute;
            top: 100%;
            left: 50%;
            transform: translateX(-50%);
            background-color: white;
            border: 1px solid #ccc;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            padding: 10px;
            z-index: 100;
            width: 250px;
            border-radius: 5px;
            color: #0056b3;
        }

        .profile-icon-container:hover .profile-popup {
            display: block;
        }

        .profile-popup p {
            margin: 0;
        }

        .profile-popup strong {
            display: block;
            margin-bottom: 10px;
        }
        
    </style>
</head>
<body style="padding:0">
 <!-- Navbar -->
 <nav class="navbar">
 <a href="#" class="logo">EMR System</a>
    <ul class="nav-links" id="navLinks">
        <li><a href="dashboard.php">Dashboard</a></li>
        <li><a href="index.php">Home</a></li>
        <li><a href="about.php">About</a></li>
        <li><a href="medication.php">Medication</a></li>
        <li><a href="drug_inventory.php">Drug_Search</a></li>
    </ul>
    <div class="menu-icon" onclick="toggleMenu()">
        <svg viewBox="0 0 100 80" width="40" height="40">
            <rect width="100" height="15"></rect>
            <rect y="30" width="100" height="15"></rect>
            <rect y="60" width="100" height="15"></rect>
        </svg>
    </div>
    <!-- User Profile Icon and Popup Container -->
    <?php

// Check if user session exists
if (isset($_SESSION['pharmacist_id'])) {
    // User already logged in
    $pharmacist_id = $_SESSION['pharmacist_id'];

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

    $sql = "SELECT first_name, last_name, email, phone FROM pharmacist WHERE pharmacist_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $pharmacist_id);
    $stmt->execute();
    $stmt->bind_result($firstName, $lastName, $email, $phone);
    $stmt->fetch();
    $stmt->close();
    $conn->close();
    ?>
    <div class="profile-icon-container">
        <i class="fa fa-user-circle fa-lg"></i>
        <div class="profile-popup">
            <p><strong><?php echo $firstName . ' ' . $lastName; ?></strong></p>
            <p>Email: <?php echo $email; ?></p>
            <p>Phone: <?php echo $phone; ?></p>
            <!-- Edit Profile Button -->
            <button class="edit-profile-btn"><a href="profile.php">Edit Profile</a></button>
        </div>
    </div>
    <?php
} else {
    ?>
    <div class="profile-icon-container">
        <i class="fa fa-user-circle fa-lg"></i>
        <div class="profile-popup">
            <p><strong>Guest User</strong></p>
            <p>Please log in to view your profile details.</p>
        </div>
    </div>
    <?php
}
?>


    <div class="logo">
            <button onclick="openModal()">Signup</button>
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
            <div class="hero-image">
                <img src="../Images/placeholder-image.jpg" alt="Placeholder Image">
            </div>
        </div>
    </div>
</section>
<!-- Features Section -->
<section id="features" class="features">
    <div class="container">
        <h2>Key Features</h2>
        <div class="feature-items">
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
            <p>Book and manage appointments online in faster and available.</p>
        </div>
        <div class="feature-item">
            <h3>Appointment Scheduling</h3>
            <p>Book and manage appointments online.</p>
        </div>
        </div>
    </div>
</section>
<!-- Signup Modal -->
<div id="loginModal" class="modal modale">
    <div class="modal-content modale">
        <span class="close" onclick="closeLogin()">&times;</span>
        <!-- Include signup form here -->
        <?php include('login.php'); ?>
    </div>
</div>

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
            <li><a href="contact.php">Contact Us</a></li>
        </ul>
    </div>
</footer>

<!-- Link Font Awesome Icons (Add to head section) -->

<!-- Signup Modal -->
<div id="signupModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <!-- Include signup form here -->
        <?php include('signup.php'); ?>
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
</script>

</body>
</html>
