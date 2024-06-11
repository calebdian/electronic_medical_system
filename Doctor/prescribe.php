<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prescription Details</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
    /* Body and table styles */
    body {
        font-family: Arial, sans-serif;
        margin: 0px;
    }

    .table-container {
        overflow-x: scroll;
        width: 90%;
        margin-inline: auto;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    table, th, td {
        border: 1px solid #ddd;
        padding: 8px;
    }
    td{
        padding: 20px;
    }
    th {
        background-color: #f2f2f2;
        text-align: left; /* Align headings to the left */
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

    /* Edit button and modal styles */
    .edit-btn {
        padding: 5px 10px;
        background-color: #007bff;
        color: #fff;
        border: none;
        cursor: pointer;
    }

    .modal {
        display: none;
        position: fixed;
        z-index: 1;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0,0,0,0.4);
        padding-top: 60px;
    }

    .modal-content {
        background-color: #fefefe;
        margin: auto;
        padding: 20px;
        border: 1px solid #888;
        width: 60%; /* Adjust the width as needed */
        max-width: 600px; /* Set a maximum width for responsiveness */
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }

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

    /* Textarea and button inside modal */
    #editTextArea {
        width: 100%;
        height: 150px; /* Adjust height as needed */
        resize: vertical;
        padding: 8px;
        font-size: 14px;
        border: 1px solid #ddd;
        border-radius: 4px;
        box-sizing: border-box;
    }

    #editTextArea:focus {
        outline: none;
        border-color: #007bff; /* Highlight border on focus */
    }

    button[type="submit"] {
        background-color: #007bff;
        color: #fff;
        border: none;
        padding: 8px 12px;
        cursor: pointer;
        border-radius: 4px;
        font-size: 16px;
    }

    button[type="submit"]:hover {
        background-color: #0056b3; /* Darker shade on hover */
    }
    .profile-popup {
            display: none;
            position: absolute;
            left: 60%;
            background-color: #f9f9f9;
            min-width: 160px;
            box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2);
            z-index: 1;
            padding: 12px;
            border-radius: 5px;
            color:aqua;
        }
        .profile-icon-container:hover .profile-popup{
            display: block;
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
.autogenerate-container {
    position: relative; /* Set position to relative */
}

#autogenerateForm {
    position: absolute; /* Set position to absolute */
    top: -100%; /* Adjust top position as needed */
    right: 0; /* Adjust right position as needed */
}

/* Media Query for Responsive Navbar */
@media screen and (max-width: 968px) {
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
</style>
</head>
<body style="padding:0;">

<nav class="navbar">
        <a href="#" class="logo">EMR System</a>
        <ul class="nav-links" id="navLinks">
            <li><a href="dashboard.php">Dashboard</a></li>
            <li><a href="index.php">Home</a></li>
            <li><a href="about.php">About</a></li>
            <li><a href="prescribe.php">Prescription</a></li>
            <li><a href="answerPosts.php">Answerposts</a></li>
        </ul>
        <div class="menu-icon" onclick="toggleMenu()">
        <svg viewBox="0 0 100 80" width="40" height="40">
            <rect width="100" height="15"></rect>
            <rect y="30" width="100" height="15"></rect>
            <rect y="60" width="100" height="15"></rect>
        </svg>
    </div>
            <div class="profile-icon-container">
                <i class="fas fa-user-circle fa-lg"></i>
                <div class="profile-popup" id="profilePopup">
                    <!-- Display doctor's details directly using PHP -->
                    <?php
                        // Check if doctor session exists
                        if (isset($_SESSION['doctor_name'], $_SESSION['doctor_email'], $_SESSION['doctor_specialization'])) {
                            $doctor_name = $_SESSION['doctor_name'];
                            $doctor_email = $_SESSION['doctor_email'];
                            $doctor_specialization = $_SESSION['doctor_specialization'];

                            // Output doctor information
                            echo "<p>Name: $doctor_name</p>";
                            echo "<p>Email: $doctor_email</p>";
                            echo "<p>Specialization: $doctor_specialization</p>";
                            echo '<a href="profile.php">Edit Profile</a><br>';
                            echo '<a href="logout.php">Logout</a>';
                        } else {
                            echo "Please log in as a doctor to access this page.";
                        }
                    ?>
                </div>
            </div>
            <div class="logo">
            <button onclick="openModalz()">Signup</button>
            <button onclick="openLogin()">Login</button>
        </div>
</nav>

<h2 style="text-align:center;">Prescription Details</h2>

<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "electronic_medical_system";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Step 3: Process Form Data
    if (isset($_POST['record_id']) && isset($_POST['new_prescription'])) {
        $userId = $_POST['record_id'];
        $newPrescription = $_POST['new_prescription'];
        $doctorId = $_SESSION['doctor_id'];

        // Step 5: Update Prescription and Pharmacy Commented field
        $sql = "UPDATE diseasedetails SET prescription='$newPrescription', doc_commented='$doctorId' WHERE record_id=$userId";

        if ($conn->query($sql) === TRUE) {
            echo "Prescription updated successfully";
        } else {
            echo "Error updating prescription: " . $conn->error;
        }
    }
}

$sql = "SELECT * FROM diseasedetails";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<div class='table-container'>";
    echo "<table>";
    echo "<tr><th>Record ID</th><th>Name</th><th>Symptoms</th><th>Disease</th><th>Prescription</th><th>Actions</th></tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["record_id"] . "</td>";
        echo "<td>" . $row["name"] . "</td>";
        echo "<td>" . $row["symptoms"] . "</td>";
        echo "<td>" . $row["disease"] . "</td>";
        echo "<td class='prescription' id='prescription-" . $row["record_id"] . "'>" . $row["prescription"] . "</td>";
        echo "<td><button class='edit-btn' onclick='openModal(" . $row["record_id"] . ")'>Edit</button></td>";
        echo "</tr>";
    }

    echo "</table>";
    echo "</div>";
} else {
    echo "No prescription details found.";
}

$conn->close();
?>
<br>

<!-- Modal -->
<div id="myModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <form id="prescriptionForm" method="post" action="prescribe.php"> <!-- Updated form action -->
            <input type="hidden" id="userIdInput" name="record_id">
            <textarea id="editTextArea" name="new_prescription" class="edit-area"></textarea>
            <div class="flex" style="display:flex; justify-content: space-between; ">
                <button type="submit">Update</button>
            </div>
        </form>
        <!-- New form for autogenerate button -->
        <div class="autogenerate-container">
            <form id="autogenerateForm" action="fetch_prescriptions.php" method="post">
                <input type="hidden" id="userIdInput2" name="record_id"> <!-- Add record_id input field -->
                <button type="submit" name="submit">Autogenerate</button> <!-- Added name attribute -->
            </form>
        </div>        
    </div>
</div>
<div id="signupModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModale()">&times;</span>
        <!-- Include signup form here -->
        <?php include('signup.php'); ?>
    </div>
</div>
<!-- Signup Modal -->
<div id="loginModal" class="modal modale">
    <div class="modal-content modale">
        <span class="close" onclick="closeLogin()">&times;</span>
        <!-- Include login form here -->
        <?php include('login.php'); ?>
    </div>
</div>
<script>
function openModal(userId) {
    var prescriptionCell = document.getElementById('prescription-' + userId);
    var editTextArea = document.getElementById('editTextArea');
    var userIdInput = document.getElementById('userIdInput');
    var userIdInput2 = document.getElementById('userIdInput2');
    userIdInput2.value = userId;
    if (prescriptionCell && editTextArea && userIdInput) {
        var currentPrescription = prescriptionCell.textContent.trim();
        editTextArea.value = currentPrescription;
        userIdInput.value = userId;
        document.getElementById('myModal').style.display = 'block';
    }
}

function closeModal() {
    document.getElementById('myModal').style.display = 'none';
}
function toggleMenu() {
    var navLinks = document.getElementById("navLinks");
    navLinks.classList.toggle("show");
}

function openModalz() {
    document.getElementById('signupModal').style.display = 'block';
}

function closeModale() {
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

