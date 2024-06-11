<?php
session_start(); // Start or resume session

// Database connection (replace these with your database credentials)
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
$fname = $_POST['fname'];
$lname = $_POST['lname'];
$dob = $_POST['dob'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$address = $_POST['address'];
$password = $_POST['password']; // Add password field to retrieve password

// Prepare SQL statement to insert data into the database
$sql = "INSERT INTO patients (first_name, last_name, date_of_birth, email, phone, address, password) 
        VALUES ('$fname', '$lname', '$dob', '$email', '$phone', '$address', '$password')";

// Execute SQL statement
if ($conn->query($sql) === TRUE) {
    // Retrieve the entire user record from the database
    $getUserSQL = "SELECT * FROM patients WHERE email = '$email'";
    $result = $conn->query($getUserSQL);

    if ($result->num_rows > 0) {
        // Fetch user data
        $user = $result->fetch_assoc();

        // Store user data in a session variable
        $_SESSION['user'] = $user;

        // Redirect user to index.php or any other page
        header("Location: index.php");
        exit; // Ensure that no other code is executed after redirection
    } else {
        echo "User not found.";
    }
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Close connection
$conn->close();
?>
