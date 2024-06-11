<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Check Queries</title>
    <style>
        /* Add your CSS styles here */
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            position: relative; /* Set position relative for absolute positioning */
        }
        .query-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 40px;
            margin-bottom: 80px;
            position: relative; /* Set position relative for absolute positioning */
            cursor: pointer; /* Add cursor pointer for better UX */
        }
        textarea {
            width: 45%;
            height: 100px;
            padding: 8px;
            resize: none;
        }
        .response-text {
            position: absolute;
            top: 50%;
            right: 50%; /* Adjust right position to align next to query text */
            transform: translateX(50%); /* Center the response text horizontally */
            width: 45%;
            height: 100px;
            padding: 8px;
            resize: none;
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            z-index: 1; /* Initial z-index for response text */
            /* Hide response text by default */
        }
        .checked-button {
            padding: 5px 10px;
            cursor: pointer;
        }
        .checked {
            color: green;
            font-size: 24px;
        }
        /* Styling for the back button */
        .back-button {
            position: absolute;
            top: 20px;
            left: 20px;
            padding: 10px 15px;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            background-color: #007bff;
            color: #fff;
            cursor: pointer;
        }
        .back-button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<!-- Back button -->
<button class="back-button" onclick="goBack()">Back</button>

<h2 style="text-align:center;">Check Queries</h2>

<?php
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

// Process checked button click
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["query_id"])) {
    $queryId = $_POST["query_id"];

    // Update checked_status to 1 for the specified query ID
    $sql = "UPDATE user_queries SET checked_status = 1 WHERE query_id = $queryId";

    if ($conn->query($sql) === TRUE) {
        echo "<p>Query with ID $queryId has been checked.</p>";
    } else {
        echo "Error updating checked status: " . $conn->error;
    }
}

// Retrieve queries from the database
$sql = "SELECT * FROM user_queries";
$result = $conn->query($sql);

// Display queries if there are any
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $queryId = $row["query_id"];
        $queryText = $row["query_text"];
        $responseText = $row["response_text"];
        $checkedStatus = $row["checked_status"];

        echo "<div class='query-container' onclick='toggleZIndex(this)'>";
        echo "<textarea readonly>$queryText</textarea>";

        // Display response text with absolute positioning
        echo "<textarea readonly class='response-text'>$responseText</textarea>";

        // Display checked button based on checked_status
        if ($checkedStatus == 0) {
            echo "<form method='post'>";
            echo "<input type='hidden' name='query_id' value='$queryId'>";
            echo "<button type='submit' class='checked-button'>Check</button>";
            echo "</form>";
        } else {
            echo "<span class='checked'>&#10004;&#10004;</span>"; // Display double green tick
        }

        echo "</div>";
    }
} else {
    echo "<p>No queries found.</p>";
}

// Close connection
$conn->close();
?>

<script>
// JavaScript function to go back to the previous page
function goBack() {
    window.history.back();
}

function toggleZIndex(container) {
    // Get the response textarea inside the clicked query-container
    var responseTextarea = container.querySelector('.response-text');

    // Toggle z-index values based on the current state of the response textarea
    if (responseTextarea.style.zIndex === "-1") {
        responseTextarea.style.zIndex = "1"; // Bring response text to the front
    } else {
        responseTextarea.style.zIndex = "-1"; // Send response text to the back
    }
}
</script>

</body>
</html>
