<?php
header('Content-Type: application/json');

// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "electronic_medical_system";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die(json_encode(["status" => "error", "message" => "Connection failed: " . $conn->connect_error]));
}

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize POST data
    $query_id = intval($_POST['query_id']);
    $query_text = $conn->real_escape_string($_POST['query_text']);

    // SQL query to update the query_text in user_queries table
    $sql_update = "UPDATE user_queries SET query_text='$query_text' WHERE query_id=$query_id";

    if ($conn->query($sql_update) === TRUE) {
        echo json_encode(["status" => "success", "message" => "Query updated successfully"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Error: " . $sql_update . "<br>" . $conn->error]);
    }
}

// Close connection
$conn->close();
?>
