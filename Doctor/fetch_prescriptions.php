<?php
// Assuming you already have database connection established
// Database credentials
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
echo "executed";
// Check if record_id is set in POST data
if(isset($_POST['submit'])) {
    // Get the record_id from POST data
    $recordId = $_POST['record_id'];

    // Prepare SQL query to fetch disease and symptoms from diseasedetails table
    $sql = "SELECT disease, symptoms FROM diseasedetails WHERE record_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $recordId);
    $stmt->execute();
    $result = $stmt->get_result();

    // Fetch disease and symptoms
    if($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $disease = $row['disease'];
        $symptoms = $row['symptoms'];

        // Prepare SQL query to fetch cure from ailment_data table based on disease
        $sql = "SELECT cure FROM ailment_data WHERE disease_name = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $disease);
        $stmt->execute();
        $result = $stmt->get_result();

        // Fetch cure
        if($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $cure = $row['cure'];

            // Update prescription in diseasedetails table
            $sql = "UPDATE diseasedetails SET prescription = ? WHERE record_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("si", $cure, $recordId);
            if($stmt->execute()) {
                // Redirect to prescribe.php after updating prescription successfully
                header("Location: prescribe.php");
                exit(); // Ensure script stops execution after redirection
            } else {
                echo "Error updating prescription: " . $conn->error;
            }
        } else {
            echo "No cure found for the disease.";
        }
    } else {
        echo "Record not found.";
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
} else {
    echo "Record ID not provided.";
}
?>
<!-- I am having a problem on my side that my wife was pregnant  -->