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

// Retrieve form data
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$email = $_POST['email'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash password for security
$specialization = $_POST['specialization'];

// SQL query to insert data into medics table
$sql = "INSERT INTO medics (first_name, last_name, email, password, specialization) 
        VALUES ('$first_name', '$last_name', '$email', '$password', '$specialization')";

if ($conn->query($sql) === TRUE) {
    // Start a session
    session_start();

    // Store doctor details in session variables
    $_SESSION['doctor_name'] = $first_name . ' ' . $last_name;
    $_SESSION['doctor_email'] = $email;
    $_SESSION['doctor_specialization'] = $specialization;

    // Redirect to index.php
    header('Location: index.php');
    exit; // Make sure to exit after redirection
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Close connection
$conn->close();
?>
