<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the form fields are set

        // Retrieve form data
        $userId = $_POST['userId'];
        $phoneNumber = $_POST['phoneNumber'];
        $amountPaid = $_POST['amount'];

        // Insert payment details into the database
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "electronic_medical_system";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $stmt = $conn->prepare("INSERT INTO payment_details (user_id, phone_number, amount_paid) VALUES (?, ?, ?)");
        $stmt->bind_param("iss", $userId, $phoneNumber, $amountPaid);
        $stmt->execute();
        $stmt->close();
        $conn->close();

        // Redirect to index.php with success message
        header("Location: index.php?payment_success=true");
        exit();
    }
?>
