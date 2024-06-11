<?php
// process_reset_password.php

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

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data with error checking
    $email = isset($_POST['email']) ? $_POST['email'] : null;
    $new_password = isset($_POST['new_password']) ? $_POST['new_password'] : null;
    $confirm_password = isset($_POST['confirm_password']) ? $_POST['confirm_password'] : null;

    // Validate form data
    if ($email && $new_password && $confirm_password) {
        if ($new_password === $confirm_password) {
            // No hashing, store password as plain text
            $plain_password = $new_password;

            // Update the user's password in the database
            $stmt = $conn->prepare("UPDATE patients SET password = ? WHERE email = ?");
            $stmt->bind_param("ss", $plain_password, $email);

            if ($stmt->execute()) {
                // Redirect to login.php with a success message
                header("Location: login.php?reset=success");
                exit();
            } else {
                echo "Error updating record: " . $conn->error;
            }

            $stmt->close();
        } else {
            echo "Passwords do not match.";
        }
    } else {
        echo "Error: Missing required form data.";
    }
} else {
    echo "Error: Form not submitted correctly.";
}

// Close connection
$conn->close();
?>
