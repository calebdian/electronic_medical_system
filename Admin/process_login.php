<?php
session_start();

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

// Process login form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Prepare SQL statement to fetch admin details by email
    $sql = "SELECT * FROM admin WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        // Admin found, verify password
        $admin = $result->fetch_assoc();
        if ($password == $admin['password']) {
            // Password is correct, set session variables
            $_SESSION["admin_id"] = $admin["admin_id"];
            $_SESSION["email"] = $admin["email"];

            // Redirect to admin dashboard or desired page
            header("Location: index.php");
            exit();
        } else {
            // Invalid password
            echo "Invalid password";
        }
    } else {
        // Admin not found
        echo "Admin not found";
    }
}

// Close connection
$conn->close();
?>
