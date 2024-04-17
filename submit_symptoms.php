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
$name = $_POST['name'];
$dob = $_POST['dob'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$symptoms = $_POST['symptoms'];

// SQL query to insert data into UserDetails table
$sql = "INSERT INTO UserDetails (name, dob, email, phone, symptoms) 
        VALUES ('$name', '$dob', '$email', '$phone', '$symptoms')";

if ($conn->query($sql) === TRUE) {
    echo "Record added successfully";

    // Additional processing (e.g., disease generation, prescription assignment) can be done here
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Close connection
$conn->close();
?>
