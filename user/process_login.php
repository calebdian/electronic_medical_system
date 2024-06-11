<?php
session_start(); // Start or resume session
// Retrieve form data
$email = $_POST['email'];
$password = $_POST['password'];

// Database connection (replace these with your database credentials)
$servername = "localhost";
$username = "root";
$password_db = "";
$dbname = "electronic_medical_system";

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
    if ($password == $row['password'])  {
        echo "Login successful!";
        // Perform additional actions (e.g., session management)
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
        }
    } else {
        echo "Incorrect password. Please try again.";
    }
} else {
    echo "User not found. Please check your email.";
}

// Close connection
$conn->close();
?>
