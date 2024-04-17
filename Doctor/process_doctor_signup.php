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
$name = $_POST['name'];
$email = $_POST['email'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash password for security
$specialization = $_POST['specialization'];

// SQL query to insert data into Doctors table
$sql = "INSERT INTO Doctors (name, email, password, specialization) 
        VALUES ('$name', '$email', '$password', '$specialization')";

if ($conn->query($sql) === TRUE) {
    echo "Doctor account created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Close connection
$conn->close();
?>
<!-- create me a login page for doctor that would be used to compare credentials with that in the table in database -->