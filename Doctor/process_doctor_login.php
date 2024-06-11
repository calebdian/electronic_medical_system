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

// Retrieve form data
$email = $_POST['email'];
$password_input = $_POST['password'];

// SQL query to retrieve user with matching email
$sql = "SELECT * FROM medics WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // User found, verify password
    $row = $result->fetch_assoc();
    if (password_verify($password_input, $row['password'])) {
        // Password is correct
        // Assigning values to variables
        $medic_id = $row['medic_id'];
        $first_name = $row['first_name'];
        $last_name = $row['last_name'];
        $specialization = $row['specialization'];
        
        // Storing data in session variables
        $_SESSION['doctor_id'] = $medic_id;
        $_SESSION['doctor_name'] = $first_name . ' ' . $last_name;
        $_SESSION['doctor_email'] = $email;
        $_SESSION['doctor_specialization'] = $specialization;
        
        // Redirect to dashboard page
        header("Location: index.php");
        exit();
    } else {
        // Incorrect password
        echo "Incorrect password. Please try again.";
    }
} else {
    // User not found
    echo "User not found. Please check your email and password.";
}

// Close connection
$conn->close();
?>
