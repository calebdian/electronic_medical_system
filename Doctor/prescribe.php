<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prescription Details</title>
    <style>
        /* Add your CSS styles here */
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        th {
            background-color: #f2f2f2;
        }
        .edit-btn {
            padding: 5px 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            cursor: pointer;
        }
    </style>
</head>
<body>

<h2>Prescription Details</h2>

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

// SQL query to retrieve prescription details from diseasedetails table
$sql = "SELECT * FROM diseasedetails";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Display table header
    echo "<table>";
    echo "<tr><th>User ID</th><th>Name</th><th>Date of Birth</th><th>Email</th><th>Phone</th><th>Symptoms</th><th>Disease</th><th>Prescription</th><th>Submission Date</th><th>Actions</th></tr>";

    // Output data of each row
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["user_id"] . "</td>";
        echo "<td>" . $row["name"] . "</td>";
        echo "<td>" . $row["dob"] . "</td>";
        echo "<td>" . $row["email"] . "</td>";
        echo "<td>" . $row["phone"] . "</td>";
        echo "<td>" . $row["symptoms"] . "</td>";
        echo "<td>" . $row["disease"] . "</td>";
        echo "<td id='prescription-" . $row["user_id"] . "'>" . $row["prescription"] . "</td>";
        echo "<td>" . $row["submission_date"] . "</td>";
        echo "<td><button class='edit-btn' onclick='editPrescription(" . $row["user_id"] . ")'>Edit</button></td>";
        echo "</tr>";
    }

    echo "</table>";
} else {
    echo "No prescription details found.";
}

// Close connection
$conn->close();
?>

<script>
function editPrescription(userId) {
    var newPrescription = prompt("Enter new prescription:");
    if (newPrescription !== null) {
        // Update the prescription in the table cell
        var prescriptionCell = document.getElementById('prescription-' + userId);
        if (prescriptionCell) {
            prescriptionCell.textContent = newPrescription;

            // TODO: Implement backend logic to update prescription in the database using AJAX or form submission
            // Example:
            // var formData = new FormData();
            // formData.append('user_id', userId);
            // formData.append('new_prescription', newPrescription);
            // fetch('update_prescription.php', {
            //     method: 'POST',
            //     body: formData
            // })
            // .then(response => {
            //     if (!response.ok) {
            //         throw new Error('Network response was not ok');
            //     }
            //     return response.text();
            // })
            // .then(data => {
            //     console.log('Prescription updated successfully:', data);
            // })
            // .catch(error => {
            //     console.error('Error updating prescription:', error);
            // });
        }
    }
}
</script>

</body>
</html>
