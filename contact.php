<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
</head>
<body>

<h2>Contact Us</h2>

<!-- Display Previous Queries and Responses -->
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

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve query_text from POST data
    $query_text = $_POST['query_text'];

    // SQL query to insert the new query into user_queries table
    $sql_insert = "INSERT INTO user_queries (user_id, email, query_text) VALUES ('123456', 'user@example.com', '$query_text')";

    if ($conn->query($sql_insert) === TRUE) {
        echo "<p>Query submitted successfully.</p>";
    } else {
        echo "Error: " . $sql_insert . "<br>" . $conn->error;
    }
}

// SQL query to retrieve previous queries and responses
$sql = "SELECT query_text, response_text FROM user_queries";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<h3>Previous Queries and Responses:</h3>";
    echo "<ul>";
    while ($row = $result->fetch_assoc()) {
        $query_text = $row["query_text"];
        $response_text = $row["response_text"];
        echo "<li><strong>Query:</strong> $query_text <br><strong>Response:</strong> $response_text</li>";
    }
    echo "</ul>";
} else {
    echo "<p>No previous queries and responses found.</p>";
}

// Close connection
$conn->close();
?>

<!-- Query Submission Form -->
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <label for="query_text">Your Query:</label>
    <textarea id="query_text" name="query_text" rows="5" required></textarea><br><br>
    <input type="submit" value="Submit">
</form>

</body>
</html>
