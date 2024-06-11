<?php
session_start(); // Ensure session is started

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

// Function to extract keywords from a symptom string
function extract_keywords($text) {
    $stopWords = ['i', 'have', 'that', 'is', 'the', 'a', 'an', 'and', 'or', 'to', 'of', 'with', 'it', 'in', 'on', 'for', 'by', 'this', 'that', 'at', 'which', 'be', 'am', 'are', 'was', 'were', 'can', 'could', 'should', 'would', 'may', 'might', 'will', 'shall', 'not', 'so', 'if', 'as', 'but', 'just', 'too', 'very'];
    $text = strtolower($text);
    $text = preg_replace('/[^a-z0-9\s,]/', '', $text); // Allow commas in the text
    $words = explode(',', $text); // Explode using commas

    $words = array_diff($words, ['coma']);

    $keywords = [];
    foreach ($words as $word) {
        $word = trim($word);
        $word_keywords = explode(' ', $word); // Explode each word to handle multiple words separated by spaces
        $keywords = array_merge($keywords, $word_keywords);
    }
    
    $keywords = array_diff($keywords, $stopWords);
    return array_unique($keywords);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data with error checking
    $name = isset($_POST['name']) ? $_POST['name'] : null;
    $dob = isset($_POST['dob']) ? $_POST['dob'] : null;
    $email = isset($_POST['email']) ? $_POST['email'] : null;
    $phone = isset($_POST['phone']) ? $_POST['phone'] : null;
    $symptoms = isset($_POST['symptoms']) ? $_POST['symptoms'] : null;
    $patient_id = isset($_POST['patient_id']) ? $_POST['patient_id'] : null; // Retrieve patient_id from the form

    // Retrieve user_id from session


    // Validate form data
    if ($name && $dob && $email && $phone && $symptoms && $patient_id) {
        // SQL query to insert data into diseasedetails table using prepared statement
        $stmt = $conn->prepare("INSERT INTO diseasedetails (user_id, name, dob, email, phone, symptoms) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("isssss", $patient_id, $name, $dob, $email, $phone, $symptoms);

        if ($stmt->execute()) {
            // Get the ID of the last inserted row
            $lastId = $stmt->insert_id;

            // Fetch all ailments and their symptoms from the ailment_data table
            $sql = "SELECT disease_name, symptoms FROM ailment_data";
            $result = $conn->query($sql);

            $identifiedDisease = "Unknown"; // Default value if no disease is identified
            $maxMatchScore = 0; // To keep track of the maximum match score found

            if ($result->num_rows > 0) {
                // Loop through each ailment to find the best match
                while ($row = $result->fetch_assoc()) {
                    $ailmentSymptoms = $row['symptoms'];
                    $ailmentKeywords = extract_keywords($ailmentSymptoms);
                    $userKeywords = extract_keywords($symptoms);

                    // Calculate match score
                    $matchScore = 0;
                    foreach ($userKeywords as $keyword) {
                        if (in_array($keyword, $ailmentKeywords)) {
                            // Assign a weight to each matched keyword
                            $matchScore += 1; // You can adjust the weight based on relevance/importance
                        }
                    }

                    // Update the identified disease if the match score is higher
                    if ($matchScore > $maxMatchScore) {
                        $maxMatchScore = $matchScore;
                        $identifiedDisease = $row['disease_name'];
                    }
                }
            }

            // Update the diseasedetails table with the identified disease using the last inserted ID
            $updateStmt = $conn->prepare("UPDATE diseasedetails SET disease = ? WHERE record_id = ?");
            $updateStmt->bind_param("si", $identifiedDisease, $lastId);

            if ($updateStmt->execute()) {
                echo "Disease type updated successfully";
            } else {
                echo "Error updating record: " . $conn->error;
            }

            $updateStmt->close();
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Error: Missing required form data.";
    }
} else {
    echo "Error: Form not submitted correctly.";
}

// Close connection
$conn->close();

// Redirect to medical_form.php with disease name
header("Location: medical_form.php?disease=$identifiedDisease");
exit();
?>
