<?php
 session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Query Responses</title>
    <link rel="stylesheet" href="../css/style.css">
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
        /* Style for profile popup */
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
    </style>
</head>
<body style="padding:0;">
  <!-- Navbar -->
  <nav class="navbar">
            <a href="#" class="logo">EMR System</a>
            <ul class="nav-links"  id="navLinks">
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
                        // Start or resume session
                       

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
            <button onclick="openModal()">Signup</button>
            <button onclick="openLogin()">Login</button>
        </div>
       
    </nav>
<h2>Edit Query Responses</h2>

<?php
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

// Check if form is submitted and handle response update
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $query_id = $_POST['query_id'];
    $response_text = $_POST['response_text'];

    // SQL query to update response_text for the specified query_id
    $sql_update = "UPDATE user_queries SET response_text = '$response_text', response_date = CURRENT_TIMESTAMP WHERE query_id = $query_id";

    if ($conn->query($sql_update) === TRUE) {
        echo "Response updated successfully.";
    } else {
        echo "Error updating response: " . $conn->error;
    }
}

// SQL query to retrieve all user queries
$sql = "SELECT * FROM user_queries";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Display form for each query
    while ($row = $result->fetch_assoc()) {
        $query_id = $row["query_id"];
        $query_text = $row["query_text"];
        $response_text = $row["response_text"];

        echo "<form action='answerposts.php' method='post'>";
        echo "<input type='hidden' name='query_id' value='$query_id'>";
        echo "<label>Query Text:</label><br>";
        echo "<textarea name='query_text' rows='5' cols='50' disabled>$query_text</textarea><br><br>";
        echo "<label>Response Text:</label><br>";
        echo "<textarea name='response_text' rows='5' cols='50'>$response_text</textarea><br><br>";
        echo "<input type='submit' value='Update Response'>";
        echo "</form>";
        echo "<hr>"; // Add a horizontal line between each query form
    }
} else {
    echo "No queries found.";
}

// Close connection
$conn->close();
?>
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
