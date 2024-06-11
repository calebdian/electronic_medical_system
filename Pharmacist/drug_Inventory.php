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

// Fetch drug data for display
$drugData = [];
$sql = "SELECT disease_name, dosage FROM ailment_data";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Extract the first word from the dosage
        $firstWord = explode(' ', trim($row['dosage']))[0];
        $drugData[] = [
            'disease_name' => $row['disease_name'],
            'dosage' => $firstWord // Store only the first word of the dosage
        ];
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Drug Inventory</title>
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
.container {
            max-width: 960px;
            margin: 0 auto;
            padding: 0 20px;
        }

        /* Centering styles */
        .center {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: start;
            
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
/* Popup Styling */
.popup {
    position: relative;
    display: inline-block;
    cursor: pointer;
}

.popup-content {
    visibility: hidden;
    width: 200px;
    background-color: #f9f9f9;
    color: #333;
    text-align: left;
    border-radius: 4px;
    padding: 10px;
    position: absolute;
    z-index: 1;
    bottom: 125%;
    left: 50%;
    margin-left: -100px;
    opacity: 0;
    transition: opacity 0.3s;
}

.popup-content.active {
    visibility: visible;
    opacity: 1;
}
.tooltip {
            display: none;
            position: absolute;
            background-color: #fff;
            border: 1px solid #ccc;
            padding: 10px;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
  /* Popup Styles */
  .popup-content {
        display: none;
        position: absolute;
        background-color: #fff;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        border-radius: 5px;
        padding: 10px;
        z-index: 1;
    }

    .popup-content.active {
        display: block;
    }

    .popup-disease,
    .popup-dosage {
        margin: 0;
    }

    .popup-divider {
        margin: 5px 0;
        border: 0;
        border-top: 1px solid #ccc;
    }
    /* Popup Styles */
.popup {
    position: relative;
    display: inline-block;
    cursor: pointer;
    transition: border-bottom 0.3s ease; /* Add transition effect */
}

.popup .drug-name:hover {
    border-bottom: 2px solid #007BFF; /* Add underline style */
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
    <?php if (isset($_SESSION['pharmacist_id'])): 
        $pharmacist_id = $_SESSION['pharmacist_id'];

        $conn = new mysqli($servername, $username, $password, $dbname);

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
    ?>
    <div class="profile-icon-container">
        <i class="fa fa-user-circle fa-lg"></i>
        <div class="profile-popup">
            <p><strong><?php echo $firstName . ' ' . $lastName; ?></strong></p>
            <p>Email: <?php echo $email; ?></p>
            <p>Phone: <?php echo $phone; ?></p>
            <button class="edit-profile-btn"><a href="profile.php">Edit Profile</a></button>
        </div>
    </div>
    <?php else: ?>
    <div class="profile-icon-container">
        <i class="fa fa-user-circle fa-lg"></i>
        <div class="profile-popup">
            <p><strong>Guest User</strong></p>
            <p>Please log in to view your profile details.</p>
        </div>
    </div>
    <?php endif; ?>
    <div class="logo">
        <button onclick="openLogin()">Login</button>
    </div>
</nav>

<div class="container center">
  <h1>Drug Inventory</h1>
<div class="drug-table-container">
    <div class="search-bar">
        <form id="search-form">
            <input type="text" id="search-input" placeholder="Search for drugs...">
            <button type="submit">Search</button>
        </form>
    </div>
    <div class="drug-list">
    
</div>
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
<script>
    // Declare drugList globally
    let drugList;

    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('search-input');
        drugList = document.querySelector('.drug-list'); // Remove 'let' keyword here

        searchInput.addEventListener('input', function(event) {
            const searchTerm = event.target.value.trim().toLowerCase();
            fetchDrugInfo(searchTerm); // Fetch drug information based on the search term
        });

        // Function to fetch drug information
        function fetchDrugInfo(searchTerm) {
            fetch('get_drug_info.php?term=' + searchTerm)
                .then(response => response.json())
                .then(drugInfo => {
                    // Clear previous drug list
                    drugList.innerHTML = '';

                    // Filter drug information based on search term
                    const filteredDrugs = drugInfo.filter(drug => {
                        return drug.drug_name.toLowerCase().startsWith(searchTerm);
                    });

                    // Create drug list items with popup for filtered drugs
                    filteredDrugs.forEach(drug => {
                        const listItem = document.createElement('div');
                        listItem.classList.add('popup');
                        listItem.style.display = 'block'; // Set display property to block
                        listItem.innerHTML = `
                        <a href="progress.php?drugName=${encodeURIComponent(drug.drug_name)}" class="drug-name">${drug.drug_name}</a>
                            <div class="popup-content">
                                <p class="popup-disease">Disease: ${drug.disease_name}</p>
                                <hr class="popup-divider">
                                <p class="popup-dosage">Dosage: ${drug.dosage}</p>
                            </div>
                        `;
                        drugList.appendChild(listItem);

                        // Attach event listeners to the newly created drug name
                        const drugName = listItem.querySelector('.drug-name');
                        drugName.addEventListener('mouseover', function() {
                            this.nextElementSibling.classList.add('active');
                        });

                        drugName.addEventListener('mouseout', function() {
                            this.nextElementSibling.classList.remove('active');
                        });
                    });
                })
                .catch(error => console.error('Error fetching drug info:', error));
        }
    });
</script>



</body>
</html>