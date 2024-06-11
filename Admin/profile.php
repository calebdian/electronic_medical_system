<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php"); // Redirect to login page if not logged in
    exit();
}

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
    if (isset($_POST['update'])) {
        // Retrieve form data
        $admin_id = $_SESSION['admin_id'];
        $email = $_POST['email'];
        $password = $_POST['password']; // You might want to hash the password before storing it

        // Update admin details in the database
        $sql_update = "UPDATE admin SET email='$email', password='$password' WHERE admin_id='$admin_id'";
        if ($conn->query($sql_update) === TRUE) {
            $_SESSION['message'] = "Admin profile updated successfully."; // Set session message
            $_SESSION['message_type'] = "success"; // Set message type for styling
        } else {
            $_SESSION['message'] = "Error updating admin profile: " . $conn->error;
            $_SESSION['message_type'] = "error"; // Set message type for styling
        }
    } elseif (isset($_POST['dismiss'])) {
        // Dismiss changes, do nothing
    }
}

// Retrieve admin details from session
$admin_id = $_SESSION['admin_id'];
$email = $_SESSION['email'];

// Retrieve admin details from the database using admin_id
$sql_select = "SELECT * FROM admin WHERE admin_id='$admin_id'";
$result = $conn->query($sql_select);
$admin = $result->fetch_assoc();

// Close connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Profile</title>
    <link rel="stylesheet" href="css/style.css">
    <!-- Add your CSS styles here -->
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        .container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
            color: #666;
        }

        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            margin-bottom: 15px;
            box-sizing: border-box;
        }

        input[type="email"]:read-only,
        input[type="password"]:read-only {
            background-color: #f2f2f2;
            color: #666;
        }

        input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        .message {
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 5px;
        }

        .message.error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .message.success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
    </style>
</head>
<body>
    <!-- Display messages if any -->
    <?php if (isset($_SESSION['message'])): ?>
    <div class="message <?php echo $_SESSION['message_type']; ?>">
        <?php 
            echo $_SESSION['message'];
            unset($_SESSION['message']);
            unset($_SESSION['message_type']);
        ?>
    </div>
    <?php endif; ?>
    
    <!-- Profile form -->
<h2>Admin Profile</h2>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" style="display:flex; align-items:center; justify-content:center; flex-direction:column;">
    <div>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo $admin['email']; ?>" required>
    </div>
    <div>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" value="<?php echo $admin['password']; ?>" required>
    </div>
    <div>
        <input type="submit" name="update" value="Update Profile">
        <button type="button" onclick="dismissChanges()">Dismiss</button>
    </div>
</form>


    <!-- Add your JavaScript code here if needed -->
    <script>
   function dismissChanges() {
       // Reload the page to dismiss changes
       location.reload();
   }
</script>
</body>
</html>
