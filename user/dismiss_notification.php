<?php
// Check if the query_id parameter is set
if(isset($_POST['query_id'])) {
    // Sanitize the input to prevent SQL injection
    $query_id = intval($_POST['query_id']);

    // Perform database update to set viewed_status field to 1 for the given query_id
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

    // Prepare and execute the update statement
    $sql = "UPDATE user_queries SET viewed_status = 1 WHERE query_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $query_id);
    $stmt->execute();
    $stmt->close();

    // Close the database connection
    $conn->close();

    // Send a success response
    http_response_code(200); // OK
    echo "Notification dismissed successfully.";
} else {
    // If query_id parameter is not set, send a bad request response
    http_response_code(400); // Bad Request
    echo "Bad request: query_id parameter is missing.";
}
?>