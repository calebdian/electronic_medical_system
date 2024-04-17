<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medical Report</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>

<h2>Medical Report</h2>

<?php
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

// SQL query to fetch details from diseasedetails table
$sql = "SELECT symptoms, disease, prescription, submission_date FROM diseasedetails";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Display fetched data in a table
    echo "<table>";
    echo "<tr><th>#</th><th>Symptoms</th><th>Disease</th><th>Prescription</th><th>Submission Date</th><th>View Receipt</th></tr>";

    $rowCounter = 1;
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $rowCounter . "</td>"; // Display row counter
        echo "<td>" . $row["symptoms"] . "</td>";
        echo "<td>" . $row["disease"] . "</td>";
        echo "<td>" . $row["prescription"] . "</td>";
        echo "<td>" . $row["submission_date"] . "</td>";
        
        // Display a link to view receipt (medical_receipt.php) for each record
        echo "<td><a href='medical_receipt.php?submission_date=" . $row["submission_date"] . "'>View Receipt</a></td>";
        
        echo "</tr>";
        
        $rowCounter++; // Increment row counter
    }

    echo "</table>";
} else {
    echo "No records found.";
}

// Close connection
$conn->close();
?>

</body>
</html>
