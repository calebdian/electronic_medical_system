<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Query Responses</title>
</head>
<body>

<h2>Edit Query Responses</h2>

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

// Check if form is submitted and handle response update
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $query_id = $_POST['query_id'];
    $response_text = $_POST['response_text'];

    // SQL query to update response_text for the specified query_id
    $sql_update = "UPDATE user_queries SET response_text = '$response_text', response_date = CURRENT_TIMESTAMP WHERE query_id = $query_id";

    if ($conn->query($sql_update) === TRUE) {
        echo "Response updated successfully.";
    } else {
        echo "Error updating response: " . $conn->error;
    }
}

// SQL query to retrieve all user queries
$sql = "SELECT * FROM user_queries";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Display form for each query
    while ($row = $result->fetch_assoc()) {
        $query_id = $row["query_id"];
        $query_text = $row["query_text"];
        $response_text = $row["response_text"];

        echo "<form action='answerposts.php' method='post'>";
        echo "<input type='hidden' name='query_id' value='$query_id'>";
        echo "<label>Query Text:</label><br>";
        echo "<textarea name='query_text' rows='5' cols='50' disabled>$query_text</textarea><br><br>";
        echo "<label>Response Text:</label><br>";
        echo "<textarea name='response_text' rows='5' cols='50'>$response_text</textarea><br><br>";
        echo "<input type='submit' value='Update Response'>";
        echo "</form>";
        echo "<hr>"; // Add a horizontal line between each query form
    }
} else {
    echo "No queries found.";
}

// Close connection
$conn->close();
?>

</body>
</html>
