<?php
session_start();

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

// Fetch drug information based on the search term
if (isset($_GET['term'])) {
    $term = $_GET['term'];

    // Prepare and execute SQL query to fetch drug information
    $stmt = $conn->prepare("SELECT disease_name, SUBSTRING_INDEX(dosage, ' ', 1) AS drug_name, dosage FROM ailment_data WHERE dosage LIKE CONCAT('%', ?, '%')");
    $stmt->bind_param("s", $term);
    $stmt->execute();
    $result = $stmt->get_result();

    // Fetch drug information as an associative array
    $drugInfo = [];
    while ($row = $result->fetch_assoc()) {
        $drugInfo[] = $row;
    }

    // Return drug information as JSON
    echo json_encode($drugInfo);
}

$conn->close();
?>
