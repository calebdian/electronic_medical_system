<?php
session_start(); // Start the session

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

// Helper function to get POST data safely
function getPostData($key) {
    return isset($_POST[$key]) ? $_POST[$key] : '';
}

// Retrieve form data
$email = getPostData('email');
$password = getPostData('password');

// Check if email and password are not empty
if (empty($email) || empty($password)) {
    die("Email and password are required.");
}

// SQL query to retrieve the pharmacist's details by email
$sql = "SELECT pharmacist_id, first_name, last_name, email, password FROM pharmacist WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    // Verify the password
    if (password_verify($password, $row['password'])) {
        // Set session variables
        $_SESSION['pharmacist_id'] = $row['pharmacist_id'];
        $_SESSION['pharmacist_name'] = $row['first_name'] . ' ' . $row['last_name'];
        $_SESSION['pharmacist_email'] = $row['email'];

        // Redirect to index.php
        header("Location: index.php");
        exit();
    } else {
        die("Invalid email or password.");
    }
} else {
    die("Invalid email or password.");
}

?>
