<?php
session_start();

if (isset($_POST['query_id'])) {
    $query_id = intval($_POST['query_id']);

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "electronic_medical_system";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "UPDATE user_queries SET viewed_status = 1 WHERE query_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $query_id);

    if ($stmt->execute()) {
        echo "Success";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "No query ID provided";
}
?>
