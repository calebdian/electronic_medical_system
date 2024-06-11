<?php
session_start();

// Initialize variables
$firstName = '';
$lastName = '';
$dateOfBirth = '';
$email = '';
$phone = '';
$address = '';
$signupDate = '';
$diseases = [];
$treatments = [];
$notifications = [];

// Check if user session exists and retrieve user data
if (isset($_SESSION['user'])) {
    $user = $_SESSION['user']; // Assuming user ID is stored in session after login
    $user_id = $user['patient_id']; // Extract patient_id from session data

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "electronic_medical_system";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Retrieve patient details
    $sql = "SELECT first_name, last_name, date_of_birth, email, phone, address, signup_date FROM patients WHERE patient_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result($firstName, $lastName, $dateOfBirth, $email, $phone, $address, $signupDate);
    $stmt->fetch();
    $stmt->close();

    // Retrieve disease information from diseasedetails table
    $sql = "SELECT disease FROM diseasedetails WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Fetch multiple records
    while ($row = $result->fetch_assoc()) {
        $diseases[] = $row['disease'];
    }

    $stmt->close();

    // Retrieve related treatment information from ailment_data table
    if (!empty($diseases)) {
        $placeholders = implode(',', array_fill(0, count($diseases), '?'));
        $sql = "SELECT disease_name, billing AS treatment_cost FROM ailment_data WHERE disease_name IN ($placeholders)";
        $stmt = $conn->prepare($sql);
        
        $types = str_repeat('s', count($diseases));
        $stmt->bind_param($types, ...$diseases);
        
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $treatments[] = $row;
        }
        $stmt->close();
    }

    // Calculate total treatment cost
    $totalCost = 0;
    foreach ($treatments as $treatment) {
        $cost = floatval(preg_replace('/[^\d.]/', '', $treatment['treatment_cost']));
        $totalCost += $cost;
    }

    // Fetch notifications with doctor's name
    $sql = "SELECT uq.query_id, uq.response_text, m.first_name 
    FROM user_queries uq 
    JOIN medics m ON uq.doctor_id = m.medic_id 
    WHERE uq.user_id = ? AND uq.checked_status = 1 AND uq.viewed_status != 1";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
    $notifications[] = $row;
    }
    $stmt->close();
 
    // Retrieve patient details including phone number
$sql = "SELECT first_name, last_name, date_of_birth, email, phone, address, signup_date FROM patients WHERE patient_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($firstName, $lastName, $dateOfBirth, $email, $phone, $address, $signupDate);
$stmt->fetch();
$stmt->close();
    $conn->close();
}

// Function to sanitize treatment cost
function sanitizeTreatmentCost($cost) {
    preg_match('/[\d\.\,\$]+/', $cost, $matches);
    return $matches[0] ?? '';
}
$notificationCount = count($notifications);
if (isset($_GET['payment_success']) && $_GET['payment_success'] == 'true') {
    echo '<div style="background-color: lightgreen; text-align: center;">
              <p style="color: green;">Payment was inserted successfully!</p>
          </div>';
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
    white-space: nowrap;
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
.profile-icon-container {
            position: relative;
            display: inline-block;
        }

        .profile-icon-container .fa-user-circle {
            font-size: 2em;
            cursor: pointer;
        }

        .profile-popup,
        .billing-popup {
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

        .profile-icon-container:hover .profile-popup,
        .profile-icon-container:hover .billing-popup {
            display: block;
        }

        .profile-popup p {
            margin: 0;
        }

        .profile-popup strong {
            display: block;
            margin-bottom: 10px;
        }
        .billing-popup {
            display: none;
            position: absolute;
            top: 100%;
            left: 50%;
            transform: translateX(-50%);
            background-color: white;
            border: 1px solid #ccc;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            z-index: 100;
            width: 300px;
            border-radius: 5px;
            color: #0056b3;
            text-align: left;
        }

        .billing-popup p {
            margin: 0;
            padding: 10px 0;
            display: flex;
            justify-content: space-between;
            border-bottom: 1px solid #ccc; /* Add a bottom border to create a separating line */
        }

        .billing-popup p:last-child {
            border-bottom: none; /* Remove the border from the last item */
        }

        .billing-popup button {
            display: block;
            width: 100%;
            padding: 10px;
            margin-top: 10px;
            background-color: #007BFF;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        .billing-popup button:hover {
            background-color: #0056b3;
        }

        .billing-popup strong {
            display: block;
            margin-bottom: 10px;
        }

        .billing-popup span {
            display: inline-block;
            margin-bottom: 5px;
        }
        .billing-popup {
    display: none;
    position: absolute;
    top: 100%;
    left: 50%;
    transform: translateX(-50%);
    background-color: white;
    border: 1px solid #ccc;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    padding: 20px;
    z-index: 100;
    width: 350px;  /* Adjust width as needed */
    border-radius: 5px;
    color: #0056b3;
}

.billing-table {
    width: 100%;
    border-collapse: collapse;
}

.billing-table th,
.billing-table td {
    padding: 10px;
    text-align: left;
    border-bottom: 1px solid #ccc;
}

.billing-table th {
    background-color: #f2f2f2;
    border-top: 1px solid #ccc;
}

.billing-table tfoot td {
    border-top: 1px solid #ccc;
}

.billing-table td {
    vertical-align: top;
}

.billing-popup button {
    display: block;
    width: 100%;
    padding: 10px;
    margin-top: 10px;
    background-color: #007BFF;
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;
}

.billing-popup button:hover {
    background-color: #0056b3;
}
.notification-icon-container {
    position: relative;
    display: inline-block;
    margin-left: 20px;
}

.notification-icon-container .fa-bell {
    font-size: 1.5em;
    cursor: pointer;
}

.notification-count {
    position: absolute;
    top: -8px; /* Adjust as needed to align with the top of the bell icon */
    right: -8px; /* Adjust as needed to align with the right of the bell icon */
    background-color: red;
    color: white;
    border-radius: 50%;
    padding: 4px 6px;
    font-size: 12px;
}

        .notification-popup {
            display: none;
            position: absolute;
            top: 100%;
            right: 0;
            background-color: white;
            border: 1px solid #ccc;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            padding: 10px;
            z-index: 100;
            width: 300px;
            border-radius: 5px;
        }

        .notification-popup header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-bottom: 10px;
            border-bottom: 1px solid #ccc;
        }

        .notification-popup header p {
            margin: 0;
            font-weight: bold;
        }

        .notification-popup header .close-btn {
            background: none;
            border: none;
            cursor: pointer;
            font-size: 1.2em;
        }

        .notification-popup ul {
            list-style: none;
            padding: 0;
            margin: 10px 0 0 0;
        }

        .notification-popup li {
            display: flex;
            flex-direction: column; /* Stack items vertically */
            padding: 10px 0;
            border-bottom: 1px solid #ccc;
        }

        .notification-popup li span {
            color: black;
            margin-bottom: 5px; /* Space between response text and doctor's name */
        }
       .notification-popup li small{
        color: #3f3f3f;
       }
        .notification-popup li:last-child {
            border-bottom: none;
        }

        .notification-popup li:hover {
            background-color: #f1f1f1;
        }

        .notification-popup .actions {
            display: flex;
            gap: 10px;
        }

        .notification-popup .actions button {
            background-color: #0056b3;
            border: none;
            color: white;
            padding: 5px 10px;
            border-radius: 3px;
            cursor: pointer;
            font-size: 0.9em;
        }

        .notification-popup .actions button:hover {
            background-color: #003f7f;
        }
        /* Payment Modal Styling */
#paymentModal {
    display: none;
    position: fixed;
    z-index: 1000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0, 0, 0, 0.4);
}

#paymentModal .modal-content {
    background-color: #fff;
    margin: 15% auto;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    width: 80%;
    max-width: 600px;
}

#paymentModal .modal-content h2 {
    color: #128c7e; /* M-Pesa green color */
}

#paymentModal .modal-content label {
    color: #128c7e; /* M-Pesa green color */
}

#paymentModal .modal-content input[type="text"],
#paymentModal .modal-content input[type="number"] {
    width: calc(100% - 20px); /* Adjust input width */
    padding: 10px;
    margin-bottom: 10px;
    border: 1px solid #128c7e; /* M-Pesa green color */
    border-radius: 5px;
}

#paymentModal .modal-content button[type="submit"] {
    display: block;
    width: 100%;
    padding: 10px;
    background-color: #128c7e; /* M-Pesa green color */
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;
}

#paymentModal .modal-content button[type="submit"]:hover {
    background-color: #0a6e5f; /* Darker shade of M-Pesa green color on hover */
}

#paymentModal .modal-content .close {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
    cursor: pointer;
}

#paymentModal .modal-content .close:hover,
#paymentModal .modal-content .close:focus {
    color: black;
    text-decoration: none;
    cursor: pointer;
}
.mpesa-payment-button {
    display: inline-block;
    position: relative;
}

.mpesa-payment-button .button {
    background-color: rgba(#00FF00,#00FF00,#00FF00,0.7);
    color: transparent;
    position: relative;
    text-decoration: none;
    font-size: 18px;
    margin-right: 30px;
    font-weight: bold;
    padding-bottom: 10px;
    transition: background-color 0.3s ease;
}

.mpesa-payment-button .button:hover {
    background-color: #008000; /* Darker green on hover */
}
.mpesa-payment-button .button::before,
.mpesa-payment-button .button::after {
    content: attr(data-text);
    position: absolute;
    top: 0;
    left: 0;
    overflow: hidden;
}

.mpesa-payment-button .button::before {
    color: #00FF00; /* Green color */
    clip-path: polygon(0% 0%, 50% 0%, 50% 100%, 0% 100%);
   
}

.mpesa-payment-button .button::after {
    color: #FFFFFF; /* White color */
    clip-path: polygon(50% 0%, 100% 0%, 100% 100%, 50% 100%);
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
        <li><a href="medical_form.php">Medical Form</a></li>
        <li><a href="contact.php">User Queries</a></li>
    </ul>
    <div class="mpesa-payment-button">
    <a href="mpesa_transactions.php" class="button" data-text="MPesa">Mpesa</a>
</div>
    <div class="menu-icon" onclick="toggleMenu()">
        <svg viewBox="0 0 100 80" width="40" height="40">
            <rect width="100" height="15"></rect>
            <rect y="30" width="100" height="15"></rect>
            <rect y="60" width="100" height="15"></rect>
        </svg>
    </div>
    <!-- User Profile Icon and Popup Container -->
    <?php if (isset($_SESSION['user'])) { ?>
        <div class="profile-icon-container">
            <i class="fa fa-user-circle fa-lg"></i>
            <div class="profile-popup">
                <p><strong><?php echo htmlspecialchars($firstName . ' ' . $lastName); ?></strong></p>
                <p>Date of Birth: <?php echo htmlspecialchars($dateOfBirth); ?></p>
                <p>Email: <?php echo htmlspecialchars($email); ?></p>
                <p>Phone: <?php echo htmlspecialchars($phone); ?></p>
                <p>Address: <?php echo htmlspecialchars($address); ?></p>
                <p>Signup Date: <?php echo htmlspecialchars($signupDate); ?></p>
            </div>
        </div>
        <div class="profile-icon-container">
            <i class="fa fa-file-invoice-dollar fa-lg" onclick="openBillingModal()"></i>
            <div id="billingModal" class="billing-popup">
                <table class="billing-table">
                    <thead>
                        <tr>
                            <th>Disease</th>
                            <th>Treatment Cost</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($treatments as $treatment) { ?>
                            <tr>
                                <td><?php echo htmlspecialchars($treatment['disease_name']); ?></td>
                                <td><?php echo htmlspecialchars(sanitizeTreatmentCost($treatment['treatment_cost'])); ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td><strong>Total Cost:</strong></td>
                            <td><strong id="totalCost"><?php echo number_format($totalCost, 2); ?></strong></td>
                        </tr>
                    </tfoot>
                </table>
                <button onclick="calculateTotal()">Pay for Treatment Cost</button>
            </div>
        </div>
        <div class="notification-icon-container">
            <i class="fa fa-bell" onclick="toggleNotifications()">
        <?php if ($notificationCount > 0): ?>
            <span class="notification-count"><?php echo $notificationCount; ?></span>
        <?php endif; ?>
           </i>
            <div class="notification-popup" id="notification-popup">
                <header>
                    <p>Notifications</p>
                    <button class="close-btn" onclick="closeNotifications()">&times;</button>
                </header>
                <ul>
                    <?php foreach ($notifications as $notification) { ?>
                        <li id="notification-<?php echo $notification['query_id']; ?>">
                            <span><?php echo htmlspecialchars($notification['response_text']); ?></span>
                            <small>From: Dr. <?php echo htmlspecialchars($notification['first_name']); ?></small>
                            <div class="actions">
                                <button onclick="viewNotification(<?php echo $notification['query_id']; ?>, '<?php echo addslashes($notification['response_text']); ?>')">View</button>
                                <button onclick="dismissNotification(<?php echo $notification['query_id']; ?>)">Dismiss</button>
                            </div>
                        </li>
                    <?php } ?>
                </ul>
            </div>
        </div>

 
    <?php } else { ?>
        <div class="profile-icon-container">
            <i class="fa fa-user-circle fa-lg"></i>
            <div class="profile-popup">
                <p><strong>Guest User</strong></p>
                <p>Please log in to view your profile details.</p>
            </div>
        </div>
    <?php } ?>
    <div class="logo">
        <!-- Add onclick attributes to the buttons -->          
        <button onclick="openModal()">Signup</button>
        <button onclick="openLogin()">Login</button>
    </div>
</nav>


<!-- Signup Modal -->
<div id="loginModal" class="modal modale">
    <div class="modal-content modale">
        <span class="close" onclick="closeLogin()">&times;</span>
        <!-- Include signup form here -->
        <?php include('login.php'); ?>
    </div>
</div>
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
            <li><a href="contact.php">Contact Us</a></li>
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
    function openBillingModal() {
    document.getElementById('billingModal').style.display = 'block';
}

function closeBillingModal() {
    document.getElementById('billingModal').style.display = 'none';
}

window.onclick = function(event) {
    var modal = document.getElementById('billingModal');
    if (event.target == modal) {
        closeBillingModal();
    }
}
    function toggleNotifications() {
            var popup = document.getElementById('notification-popup');
            popup.style.display = popup.style.display === 'block' ? 'none' : 'block';
        }

        function closeNotifications() {
            document.getElementById('notification-popup').style.display = 'none';
        }

        function viewNotification(queryId) {
            // Implement the view action (e.g., redirect to a detail page or open a modal)
            console.log('View notification:', queryId);
        }

        function dismissNotification(queryId) {
        fetch('dismiss_notification.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: new URLSearchParams({
                'query_id': queryId
            })
        })
        .then(response => {
            if (response.ok) {
                // Successfully updated, now remove the notification from the list
                document.getElementById('notification-' + queryId).style.display = 'none';
            } else {
                console.error('Network response was not ok.');
            }
        })
        .catch(error => {
            console.error('There was a problem with the fetch operation:', error);
        });
    }

        document.addEventListener('click', function(event) {
            var isClickInside = document.querySelector('.notification-icon-container').contains(event.target);
            if (!isClickInside) {
                document.getElementById('notification-popup').style.display = 'none';
            }
        });
        function viewNotification(queryId, responseText) {
    // Redirect to contact.php with query_id and notification_text parameters
    window.location.href = `contact.php?query_id=${queryId}&notification_text=${encodeURIComponent(responseText)}`;
}
    function updateViewedStatus(queryId) {
        const xhr = new XMLHttpRequest();
        xhr.open("POST", "update_viewed_status.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                console.log("Notification status updated successfully");
            }
        };
        xhr.send("query_id=" + queryId);
    }
    function calculateTotal() {
    document.getElementById('paymentModal').style.display = 'block';
    }

    function closePaymentModal() {
        document.getElementById('paymentModal').style.display = 'none';
    }
    
</script>


</body>
</html>