<?php
session_start(); // Start or resume session

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
    // Check if the user has paid their medical bills
    $sql = "SELECT COUNT(*) AS count FROM payment_details WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $payment_count = $row['count'];
    $stmt->close();

    // Retrieve disease details with approval status
    $sql = "SELECT COUNT(*) AS count FROM diseasedetails WHERE user_id = ? AND approval_status = 1";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $approval_count = $row['count'];
    $stmt->close();




}

// Function to sanitize treatment cost
function sanitizeTreatmentCost($cost) {
    preg_match('/[\d\.\,\$]+/', $cost, $matches);
    return $matches[0] ?? '';
}

// Function to calculate time difference
function timeAgo($datetime) {
    $current_time = new DateTime();
    $submission_time = new DateTime($datetime);
    $interval = $current_time->diff($submission_time);

    if ($interval->y > 0) {
        return $interval->y . ' years ago';
    } elseif ($interval->m > 0) {
        return $interval->m . ' months ago';
    } elseif ($interval->d > 0) {
        return $interval->d . ' days ago';
    } elseif ($interval->h > 0) {
        return $interval->h . ' hours ago';
    } elseif ($interval->i > 0) {
        return $interval->i . ' minutes ago';
    } else {
        return 'Just now';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medical Report</title>
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
        .modal-content.modale {
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
            background-color: #f9f9f9;
            color: #333;
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

        /* Table */
        .table-container {
            overflow-x: auto;
            width: 90%;
            margin: 0 auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 40px;
            font-size: 16px; /* Default font size */
        }

        table, th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        /* Adjust font size and padding for smaller screens */
        @media screen and (max-width: 600px) {
            table, th, td {
                font-size: 14px;
                padding: 8px;
                
            }
        }

        @media screen and (max-width: 400px) {
            table, th, td {
                font-size: 12px;
                padding: 6px;
            }
        }

        /* Footer */
        .footer {
            background-color: #007BFF;
            color: #fff;
            text-align: center;
            padding: 20px 0;
            position: relative;
            margin-top: 40px;
        }

        .social-links {
            list-style: none;
            padding: 0;
        }

        .social-links li {
            display: inline;
            margin-right: 10px;
        }

        .social-links a {
            color: #fff;
            font-size: 20px;
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
       padding: 10px;
       z-index: 100;
       width: 250px;
       border-radius: 5px;
       color: #0056b3;
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
   .glass-effect {
        display: inline-block;
        padding: 5px 10px;
        border-radius: 20px;
        background-color: rgba(255, 255, 255, 0.5); /* Transparent white background */
        box-shadow: 0 0 10px rgba(255, 255, 255, 0.5); /* Soft glow effect */
    }

    .disabled-link {
        color: gray; /* Change text color */
        text-decoration: none; /* Remove underline */
        cursor: not-allowed; /* Change cursor style */
    }
    </style>
</head>
<body style="padding:0px;">
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
                <p><strong>Treatment Details</strong></p>
                <?php foreach ($treatments as $treatment) { ?>
                    <p>
                        <span style="color:green;">Disease: <?php echo htmlspecialchars($treatment['disease_name']); ?></span>
                        <span style="color:black; font-weight:bold;">Treatment Cost: <?php echo htmlspecialchars(sanitizeTreatmentCost($treatment['treatment_cost'])); ?></span>
                    </p>
                <?php } ?>
                <p><strong>Total Cost: </strong><span id="totalCost" style="color:black; font-weight:bold;"><?php echo number_format($totalCost, 2); ?></span></p>
                <button onclick="calculateTotal()">Calculate Total</button>
            </div>
        </div>

        <script>
            function openBillingModal() {
                var billingModal = document.getElementById('billingModal');
                if (billingModal.style.display === 'block') {
                    billingModal.style.display = 'none';
                } else {
                    billingModal.style.display = 'block';
                }
            }

            function calculateTotal() {
                var totalCost = <?php echo json_encode(number_format($totalCost, 2)); ?>;
                alert("Total Treatment Cost: $" + totalCost);
            }
        </script>
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
<h2>Medical Report</h2>

<?php
// Initialize user_id variable
$user_id = '';

// Check if user session exists
if (isset($_SESSION['user'])) {
    $user_id = $_SESSION['user']['patient_id']; // Assuming user ID is stored in session after login
}
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "electronic_medical_system";
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL query to fetch details from diseasedetails table for the logged-in user
$sql = "SELECT symptoms, disease, prescription, submission_date FROM diseasedetails WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Display fetched data in a table
    echo "<div class='table-container'>";
    echo "<table>";
    echo "<tr><th>#</th><th>Symptoms Provided</th><th>Disease Diagnosed</th><th>Submission Date</th><th>View Receipt</th></tr>";

    $rowCounter = 1;
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $rowCounter . "</td>"; // Display row counter
        echo "<td>" . $row["symptoms"] . "</td>";
        echo "<td>" . $row["disease"] . "</td>";
        echo "<td>" . timeAgo($row["submission_date"]) . "</td>";
        
        // If both payment and approval status are met, enable "View Receipt" link
        if ($payment_count > 0 && $approval_count > 0) {
            // Display a link to view receipt for each record
            echo "<td><a href='medical_receipt.php?submission_date=" . $row["submission_date"] . "'>View Receipt</a></td>";
        } else {
            // Display a disabled link to view receipt with glass-like effect
            echo "<td><span class='glass-effect'><a href='#' class='disabled-link'>View Receipt</a></span></td>";
        }
        
        echo "</tr>";
        
        $rowCounter++; // Increment row counter
    }

    echo "</table>";
    echo "</div>";
} else {
    echo "<p style='text-align:center; margin-top:20px;'>No records found since no user has logged in.</p>";
}

// Close statement
$stmt->close();

// Close connection
$conn->close();

?>
<br>
<div class="disclaimer">
    <!-- <p style="text-align:center;">Please swipe or drag using right arrow key to the right to view more info</p> -->
</div>
  <div id="loginModal" class="modal modale">
    <div class="modal-content modale">
        <span class="close" onclick="closeLogin()">&times;</span>
        <!-- Include signup form here -->
        <?php include('login.php'); ?>
    </div>
</div>
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
</script>
</body>
</html>
