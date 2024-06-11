<?php

session_start();
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

// Process form submission to add medication
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['record_id'], $_POST['dosage_details'])) {
    $recordId = $_POST['record_id'];
    $medication = $_POST['dosage_details'];
    $pharmacistId = $_SESSION['pharmacist_id'];

    // Update medication and pharmacist_commented for the specified record ID
    $sql = "UPDATE diseasedetails SET medication = ?, pharmacist_commented = ? WHERE record_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $medication, $pharmacistId, $recordId);
    
    if ($stmt->execute()) {
        // Medication added successfully
        $message = "Medication has been inserted successfully.";
    } else {
        // Error adding medication
        $message = "Error adding medication.";
    }
}

// Retrieve records from the diseasedetails table if doctor is logged in
if (isset($_SESSION['doctor_id'])) {
    $sql = "SELECT * FROM diseasedetails";
    $result = $conn->query($sql);
} else {
    $message = "Pharmacist has not logged in.";
}

// Check if record ID is provided in the form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['record_id'])) {
    $recordId = $_POST['record_id'];

    // Retrieve disease name for the specified record ID
    $sql = "SELECT disease FROM diseasedetails WHERE record_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $recordId);
    $stmt->execute();
    $stmt->bind_result($diseaseName);
    $stmt->fetch();
    $stmt->close();

    // Retrieve dosage details from ailment_data table where disease matches
    $sql = "SELECT dosage FROM ailment_data WHERE disease_name = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $diseaseName);
    $stmt->execute();
    $stmt->bind_result($dosageDetails);
    $stmt->fetch();
    $stmt->close();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medication</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- Add your CSS styles here -->
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
        .table-container {
            overflow-x: scroll;
            width: 80%;
            margin-left: 10px;
            margin-inline: auto;
            margin-block:20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        th {
            background-color: #f2f2f2;
        }
        .table-container::-webkit-scrollbar {
            width: 5px; /* Adjust the width as needed */
            height: 5px; /* Adjust the height as needed */
            }

            /* Optionally, you can also style the scrollbar track and thumb */
            .table-container::-webkit-scrollbar-track {
            background-color: #f1f1f1; /* Change to desired color */
            }

            .table-container::-webkit-scrollbar-thumb {
            background-color: #888; /* Change to desired color */
            border-radius: 5px; /* Adjust the border radius as needed */
            }
        /* Medication Form Popup Styling */
.modal {
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

.modal-content {
  background-color: #fff;
  margin: 15% auto;
  padding: 20px;
  border-radius: 8px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  width: 80%;
  max-width: 600px;
  position: relative;
}

.close {
  color: #aaa;
  position: absolute;
  top: 10px;
  right: 10px;
  font-size: 20px;
}

.close:hover,
.close:focus {
  color: black;
  text-decoration: none;
  cursor: pointer;
}

#medicationForm label {
  margin-top: 10px;
  display: block;
}

#medicationForm input[type="text"],
#medicationForm textarea {
  width: calc(100% - 20px);
  padding: 10px;
  margin-top: 5px;
  border: 1px solid #ccc;
  border-radius: 4px;
  box-sizing: border-box;
}

#medicationForm textarea {
  resize: vertical;
}

#medicationForm button[type="submit"] {
  background-color: #007bff;
  color: #fff;
  border: none;
  padding: 10px 20px;
  border-radius: 4px;
  cursor: pointer;
  margin-top: 10px;
}

#medicationForm button[type="submit"]:hover {
  background-color: #0056b3;
}
    </style>
</head>
<body>
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

        $sql = "SELECT first_name, last_name, email, phone FROM pharmacist WHERE pharmacist_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $pharmacist_id);
        $stmt->execute();
        $stmt->bind_result($firstName, $lastName, $email, $phone);
        $stmt->fetch();
        $stmt->close();
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
        <button onclick="openLogin()">Login</button>
    </div>
</nav>

<h2 style="text-align:center;">Medication</h2>

<!-- Display existing records if doctor is logged in -->
<?php if (isset($_SESSION['doctor_id'])): ?>
    <div class="table-container">
        <table>
            <tr>
                <th>Record ID</th>
                <th>Name</th>
                <th>Symptoms</th>
                <th>Disease</th>
                <th>Prescription</th>
                <th>Medication</th>
                <th>Action</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['record_id']; ?></td>
                <td><?php echo $row['name']; ?></td>
                <td><?php echo $row['symptoms']; ?></td>
                <td><?php echo $row['disease']; ?></td>
                <td><?php echo $row['prescription']; ?></td>
                <td><?php echo $row['medication']; ?></td>
                <td>
                <?php if (!empty($row['medication'])): ?>
                    <button class="edit-medication-btn" data-record-id="<?php echo $row['record_id']; ?>">Edit Medication</button>
                <?php else: ?>
                    <button class="add-medication-btn" data-record-id="<?php echo $row['record_id']; ?>">Add Medication</button>
                <?php endif; ?>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>
<?php else: ?>
    <p style="text-align: center; color: blue;"><?php echo $message; ?></p>
<?php endif; ?>

<!-- Form for adding medication -->
<div id="addMedicationPopup" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeAddMedicationPopup()">&times;</span>
        <h3>Add Medication</h3>
        <!-- Update the form action to submit to the same file -->
        <form id="medicationForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <!-- Use a hidden input field to store the record_id -->
            <input type="hidden" id="recordIdInput" name="record_id">
            <label for="medicationInput">Medication:</label>
            <input type="text" id="medicationInput" name="medication">
            <label for="dosageDetails">Dosage Details:</label>
            <textarea id="dosageDetails" name="dosage_details" readonly></textarea>
            <button type="submit">Submit</button>
        </form>
    </div>
</div>

<footer id="contact" class="footer">
    <div class="container">
        <p>&copy; 2024 EMR System. All rights reserved.</p>
        <ul class="social-links">
            <li><a href="#"><i class="fab fa-facebook"></i></a></li>
            <li><a href="#"><i class="fab fa-twitter"></i></a></li>
            <li><a href="#"><i class="fab fa-linkedin"></i></a></li>
            <li><a href="#"><i class="fab fa-instagram"></i></a></li>
            <li><a href="#"><i class="fab fa-instagram"></i></a></li>
        </ul>
    </div>
</footer>

<script>
    // Toggle menu for small screens
    function toggleMenu() {
        var navLinks = document.getElementById("navLinks");
        navLinks.classList.toggle("show");
    }

    // Open login popup
    function openLogin() {
        window.location.href = 'login.php';
    }

    // Open Add Medication Popup
    function openAddMedicationPopup(recordId) {
        document.getElementById('recordIdInput').value = recordId;
        document.getElementById('addMedicationPopup').style.display = 'block';

        // Fetch dosage details based on record ID
        fetchDosageDetails(recordId);
    }

    // Close Add Medication Popup
    function closeAddMedicationPopup() {
        document.getElementById('addMedicationPopup').style.display = 'none';
    }

    // Fetch dosage details based on record ID
    function fetchDosageDetails(recordId) {
    fetch(`fetch_dosage_details.php?record_id=${recordId}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById('dosageDetails').value = data.dosageDetails;
                document.getElementById('medicationInput').value = data.medicationName;
            } else {
                alert(data.message);
            }
        })
        .catch(error => {
            console.error('Error fetching dosage details:', error);
        });
}
    // Add event listener for Add Medication buttons
    document.querySelectorAll('.add-medication-btn').forEach(button => {
        button.addEventListener('click', function() {
            var recordId = this.getAttribute('data-record-id');
            openAddMedicationPopup(recordId);
        });
    });

    // Add event listener for Edit Medication buttons
    document.querySelectorAll('.edit-medication-btn').forEach(button => {
        button.addEventListener('click', function() {
            var recordId = this.getAttribute('data-record-id');
            openAddMedicationPopup(recordId);
        });
    });

    // Close modal when clicking outside of it
    window.onclick = function(event) {
        var modal = document.getElementById('addMedicationPopup');
        if (event.target == modal) {
            modal.style.display = 'none';
        }
    }
</script>

</body>
</html>


