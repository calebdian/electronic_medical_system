<?php
session_start(); // Start or resume session

// Check if user session exists
if (!isset($_SESSION['user'])) {
    header('Location: login.php'); // Redirect to login page if user is not logged in
    exit();
}

// Get the user ID from session
$user_id = $_SESSION['user'];

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

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstName = $_POST['first_name'];
    $lastName = $_POST['last_name'];
    $dateOfBirth = $_POST['date_of_birth'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    // Update user data
    $sql = "UPDATE patients SET first_name = ?, last_name = ?, date_of_birth = ?, email = ?, phone = ?, address = ? WHERE patient_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssi", $firstName, $lastName, $dateOfBirth, $email, $phone, $address, $user_id);

    if ($stmt->execute()) {
        $_SESSION['message'] = "Profile updated successfully!";
        $_SESSION['message_type'] = "success";
    } else {
        $_SESSION['message'] = "Error updating profile: " . $conn->error;
        $_SESSION['message_type'] = "error";
    }

    $stmt->close();
}

$conn->close();

// Redirect to edit_profile.php with status message
header('Location: edit_profile.php');
exit();
