<?php
// Retrieve form data
$fname = $_POST['fname'];
$lname = $_POST['lname'];
$dob = $_POST['dob'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$address = $_POST['address'];

// Database connection (replace these with your database credentials)
$servername = "localhost";
$username = "username";
$password = "password";
$dbname = "your_database_name";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare SQL statement to insert data into the database
$sql = "INSERT INTO patients (first_name, last_name, dob, email, phone, address) 
        VALUES ('$fname', '$lname', '$dob', '$email', '$phone', '$address')";

// Execute SQL statement
if ($conn->query($sql) === TRUE) {
    echo "Patient record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Close connection
$conn->close();
?>
