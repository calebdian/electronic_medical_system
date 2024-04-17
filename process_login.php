<?php
// Retrieve form data
$email = $_POST['email'];
$password = $_POST['password'];

// Database connection (replace these with your database credentials)
$servername = "localhost";
$username = "your_username";
$password_db = "your_password";
$dbname = "your_database_name";

// Create connection
$conn = new mysqli($servername, $username, $password_db, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare SQL statement to retrieve user from database
$sql = "SELECT * FROM Patients WHERE email = '$email' LIMIT 1";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // User found, check password
    $row = $result->fetch_assoc();
    $stored_password = $row['password']; // Assuming password is stored in the 'password' column

    // Verify password
    if (password_verify($password, $stored_password)) {
        echo "Login successful!";
        // Perform additional actions (e.g., session management)
    } else {
        echo "Incorrect password. Please try again.";
    }
} else {
    echo "User not found. Please check your email.";
}

// Close connection
$conn->close();
?>
