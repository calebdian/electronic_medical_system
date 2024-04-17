<?php
// Database connection details
$servername = "localhost";
$username = "your_username";
$password = "your_password";
$dbname = "your_database_name";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve form data
$email = $_POST['email'];
$password = $_POST['password'];

// SQL query to retrieve user with matching email
$sql = "SELECT * FROM Medics WHERE email = '$email'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // User found, verify password
    $row = $result->fetch_assoc();
    if (password_verify($password, $row['password'])) {
        // Password is correct, redirect to dashboard or desired page
        echo "Login successful. Redirecting to dashboard...";
        // Redirect to dashboard page
        header("Location: doctor_dashboard.php");
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
