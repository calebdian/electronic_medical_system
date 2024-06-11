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

// Function to extract medication name from dosage details
function extractMedicationName($dosage) {
    $words = explode(' ', trim($dosage));
    return !empty($words) ? $words[0] : '';
}

// Check if record ID is provided
if (isset($_GET['record_id'])) {
    $recordId = $_GET['record_id'];

    // Retrieve disease name for the specified record ID
    $sql = "SELECT disease FROM diseasedetails WHERE record_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $recordId);
    $stmt->execute();
    $stmt->bind_result($diseaseName);
    $stmt->fetch();
    $stmt->close();

    if ($diseaseName) {
        // Retrieve dosage details from ailment_data table where disease matches
        $sql = "SELECT dosage FROM ailment_data WHERE disease_name = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $diseaseName);
        $stmt->execute();
        $stmt->bind_result($dosageDetails);
        $stmt->fetch();
        $stmt->close();

        if ($dosageDetails) {
            // Extract medication name from dosage details
            $medicationName = extractMedicationName($dosageDetails);

            // Dosage details found, include medication name
            echo json_encode(["success" => true, "dosageDetails" => $dosageDetails, "medicationName" => $medicationName]);
            exit;
        } else {
            // Dosage details not found
            echo json_encode(["success" => false, "message" => "Dosage details not found for the specified disease"]);
            exit;
        }
    } else {
        // Disease not found for the specified record ID
        echo json_encode(["success" => false, "message" => "Disease not found for the specified record ID"]);
        exit;
    }
} else {
    // Record ID not provided or incorrect request method
    echo json_encode(["success" => false, "message" => "Invalid request"]);
    exit;
}
?>
