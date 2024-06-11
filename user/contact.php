<?php
session_start();

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

// Fetch notification parameters
$query_id = isset($_GET['query_id']) ? $_GET['query_id'] : '';
$notification_text = isset($_GET['notification_text']) ? $_GET['notification_text'] : '';

// Check if user is logged in
if (!isset($_SESSION['user'])) {
    echo "<p style='color:red;'>User has not logged in.</p>";
} else {
    // If query_id is provided, update the viewed_status
    if ($query_id) {
        $update_status_sql = "UPDATE user_queries SET viewed_status = 1 WHERE query_id = ?";
        $stmt = $conn->prepare($update_status_sql);
        $stmt->bind_param("i", $query_id);
        $stmt->execute();
        $stmt->close();
    }

    // Handle form submission
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $query_text = $_POST['query_text'];
        $user_id = $_SESSION['user']['patient_id'];
        $email = $_SESSION['user']['email'];

        $sql_insert = "INSERT INTO user_queries (user_id, email, query_text) VALUES ('$user_id', '$email', '$query_text')";
        if ($conn->query($sql_insert) === TRUE) {
            $_SESSION['message'] = "Query submitted successfully.";
            $_SESSION['message_type'] = "success";
            header("Location: index.php");
            exit();
        } else {
            $_SESSION['message'] = "Error submitting query: " . $conn->error;
            $_SESSION['message_type'] = "error";
            header("Location: index.php");
            exit();
        }
    }

    // SQL query to retrieve previous queries and responses
    $sql = "SELECT query_id, query_text, response_text FROM user_queries WHERE user_id = '".$_SESSION['user']['patient_id']."'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<br>";
        echo "<h3>Previous Queries and Responses:</h3>";
        echo "<ul>";
        while ($row = $result->fetch_assoc()) {
            $query_id = $row["query_id"];
            $query_text = $row["query_text"];
            $response_text = $row["response_text"];

            // Check if response text matches notification text
            $highlight_class = '';
            if ($notification_text && strpos($response_text, $notification_text) !== false) {
                $highlight_class = 'highlight-response';
            }

            echo "<div class='query-response-container'>";
            echo "<textarea rows='5' class='editable-query' readonly data-query-id='$query_id'>$query_text</textarea>";
            echo "<button class='edit-button' onclick='editQuery(this, $query_id)'>&#9998;</button>";
            echo "<textarea rows='5' class='response $highlight_class' readonly>";
            echo "Response: $response_text";
            echo "</textarea>";
            echo "</div>";
        }
        echo "</ul>";
    } else {
        echo "<p>No previous queries and responses found.</p>";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        /* Modal Styling */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.4);
        }
        .modal-content {
            background-color: #fff;
            margin: 15% auto;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            width: 80%;
            max-width: 600px;
        }
        .modal-content.modale {
            width: fit-content;
        }
        /* Close button */
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }
        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
        /* Footer */
        .footer {
            background-color: #007BFF; /* Update footer background color */
            color: #fff;
            text-align: center;
            padding: 30px 0;
        }
        .social-links {
            list-style: none;
            padding: 0;
            display: flex;
            justify-content: center;
        }
        .social-links li {
            margin-right: 10px;
        }
        .social-links a {
            color: #fff;
            font-size: 24px;
            text-decoration: none;
        }
        .footer-links {
            list-style: none;
            padding: 0;
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }
        .footer-links li {
            margin-right: 20px;
        }
        .footer-links a {
            color: #fff;
            text-decoration: none;
            font-weight: bold;
            transition: color 0.3s ease;
        }
        .footer-links a:hover {
            color: #00bcd4;
        }
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
        textarea {
            width: 100%;
            padding: 10px;
            box-sizing: border-box;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            resize: none; /* Allow vertical resizing */
        }
        /* Style for readonly textareas */
        textarea[readonly] {
            background-color: #f2f2f2; /* Light gray background for readonly */
            color: #666; /* Dim text color for readonly */
            cursor: not-allowed; /* Change cursor to not-allowed */
        }
        .query-response-container {
            position: relative;
            margin-bottom: 90px;
        }
        .editable-query {
            width: 50%;
        }
        .response {
            position: absolute;
            top: 100%;
            left: 40%;
            transform: translate(-50%, -50%);
            width: 50%;
            color: white;
            background-color: #f2f2f2; /* Change background color */
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 10px;
        }
        .highlight {
            background-color: yellow; /* Highlight background color */
            color: red; /* Highlight text color */
        }
        .highlight-response {
            background-color: yellow; /* Background color for highlighted response */
            color: red; /* Text color for highlighted response */
        }
        .edit-button {
            position: absolute;
            right: 50%;
            top: 0;
            transform: translateX(50%);
        }
        form {
            width: 50%; /* Match the width of the query-response container */
            margin: 0 auto; /* Center the form horizontally */
        }
        body {
            background-color: #f8f9fa; /* Light gray background color */
            font-family: Arial, sans-serif; /* Use a common font style */
        }
        h2 {
            font-size: 36px;
            color: #007BFF; /* Blue color for the header */
            text-align: center;
            margin-top: 30px;
        }
        form {
            width: 60%;
            margin: 0 auto;
            margin: 0 auto;
            background-color: #fff; /* White background for the form */
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1); /* Add shadow for depth */
        }
        label {
            font-weight: bold;
        }
        input[type="text"],
        textarea {
            width: 100%;
            padding: 10px;
            box-sizing: border-box;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            resize: none;
        }
        input[type="submit"] {
            background-color: #007BFF;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
        }
        footer {
            background-color: #007BFF;
            color: #fff;
            text-align: center;
            padding: 30px 0;
        }
        .social-links li {
            margin: 0 10px;
        }
        .social-links a {
            color: #fff;
            font-size: 24px;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <!-- Back button -->
    <button class="back-button" onclick="goBack()">Back</button>
   
    <h2>Contact Us</h2>
    <p style="text-align:center; text-shadow:2px 2px 3px rgba(0,0,0,0.3);">Give us your query and we will answer you back</p>

    <!-- Display Previous Queries and Responses -->
    <?php
    if (isset($_SESSION['message'])) {
        $message = $_SESSION['message'];
        $message_type = $_SESSION['message_type'];
        echo "<div class='message {$message_type}'>{$message}</div>";
        unset($_SESSION['message']);
        unset($_SESSION['message_type']);
    }
    ?>

    <!-- Query Submission Form -->
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <label for="query_text">Your Query:</label>
        <textarea id="query_text" name="query_text" rows="5" required></textarea><br><br>
        <input type="submit" value="Submit">
    </form>

    <!-- Footer -->
    <footer id="contact" class="footer">
        <div class="container">
            <p>&copy; 2024 EMR System. All rights reserved.</p>
            <ul class="social-links">
                <li><a href="#"><i class="fab fa-facebook"></i></a></li>
                <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                <li><a href="#"><i class="fab fa-linkedin"></i></a></li>
                <li><a href="#"><i class="fab fa-instagram"></i></a></li>
                <li><a href="#"><i class="fab fa-youtube"></i></a></li>
            </ul>
            <ul class="footer-links">
                <li><a href="#">Terms of Service</a></li>
                <li><a href="#">Privacy Policy</a></li>
                <li><a href="#">Accessibility</a></li>
                <li><a href="contact.php">Contact Us</a></li>
            </ul>
        </div>
    </footer>

    <!-- Signup Modal -->
    <div id="signupModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <?php include('signup.php'); ?>
        </div>
    </div>

    <!-- Login Modal -->
    <div id="loginModal" class="modal modale">
        <div class="modal-content modale">
            <span class="close" onclick="closeLogin()">&times;</span>
            <?php include('login.php'); ?>
        </div>
    </div>

    <!-- JavaScript to handle modal and query editing -->
    <script>
        function goBack() {
            window.history.back();
        }
        function openModal() {
            document.getElementById('signupModal').style.display = 'block';
        }
        function closeModal() {
            document.getElementById('signupModal').style.display = 'none';
        }
        function openLogin() {
            document.getElementById('loginModal').style.display = 'block';
        }
        function closeLogin() {
            document.getElementById('loginModal').style.display = 'none';
        }
        function editQuery(button, queryId) {
            var parentDiv = button.parentElement;
            var readonlyTextarea = parentDiv.querySelector('.editable-query');
            var isEditable = !readonlyTextarea.hasAttribute('readonly');
            if (isEditable) {
                readonlyTextarea.setAttribute('readonly', true);
                readonlyTextarea.style.width = '50%';
                button.innerHTML = '&#9998;';
                var saveButton = parentDiv.querySelector('.save-button');
                if (saveButton) {
                    saveButton.remove();
                }
            } else {
                readonlyTextarea.removeAttribute('readonly');
                readonlyTextarea.style.width = '50%';
                readonlyTextarea.focus();
                button.innerHTML = '&#x2716;';
                var saveButton = document.createElement('button');
                saveButton.textContent = 'Save';
                saveButton.className = 'save-button';
                saveButton.onclick = function() {
                    var newQueryText = readonlyTextarea.value;

                    fetch('update_query.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded'
                        },
                        body: new URLSearchParams({
                            'query_id': queryId,
                            'query_text': newQueryText
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === "success") {
                            alert(data.message);
                            readonlyTextarea.setAttribute('readonly', true);
                            readonlyTextarea.style.width = '50%';
                            button.innerHTML = '&#9998;';
                            saveButton.remove();
                        } else {
                            alert('Error updating query: ' + data.message);
                        }
                    })
                    .catch(error => {
                        alert('Network error. Please try again later.');
                    });
                };
                parentDiv.appendChild(saveButton);
            }
        }
    </script>
</body>
</html>