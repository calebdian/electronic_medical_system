<?php
session_start(); // Start or resume session

// Check if user session exists
if (!isset($_SESSION['user'])) {
    header('Location: login.php'); // Redirect to login page if user is not logged in
    exit();
}

// Get the user ID from session
$user_id = $_SESSION['user'];

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

// Initialize variables
$firstName = '';
$lastName = '';
$dateOfBirth = '';
$email = '';
$phone = '';
$address = '';

// Fetch user data
$sql = "SELECT first_name, last_name, date_of_birth, email, phone, address FROM patients WHERE patient_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($firstName, $lastName, $dateOfBirth, $email, $phone, $address);
$stmt->fetch();
$stmt->close();

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<style>
body {
    font-family: Arial, sans-serif;
    background-color: #f2f2f2;
    margin: 0;
    padding: 0;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    height: 100vh;
}

.profile-icon {
    font-size: 150px;
    color: #333;
    margin-bottom: 20px;
}

h2 {
    text-align: center;
    margin-bottom: 20px;
    color: #333;
}

form {
    background-color: #fff;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    width: 100%;
    max-width: 400px;
}

label {
    display: block;
    font-weight: bold;
    margin-bottom: 5px;
    color: #333;
}

input[type="text"],
input[type="email"],
input[type="date"],
textarea {
    width: 100%;
    padding: 10px;
    margin-bottom: 20px;
    border: 1px solid #ccc;
    border-radius: 5px;
    box-sizing: border-box;
    font-size: 16px;
}

textarea {
    height: 100px;
}

.button-container {
    display: flex;
    justify-content: space-between;
}

button {
    width: 48%;
    padding: 10px;
    background-color: #4CAF50;
    border: none;
    border-radius: 5px;
    color: white;
    font-size: 16px;
    cursor: pointer;
}

button.dismiss {
    background-color: #f44336;
}

button:hover {
    background-color: #45a049;
}

button.dismiss:hover {
    background-color: #e53935;
}

.notification {
    padding: 10px;
    margin-bottom: 20px;
    border-radius: 5px;
    width: 100%;
    max-width: 400px;
    text-align: center;
}

.notification.success {
    background-color: #4CAF50;
    color: white;
}

.notification.error {
    background-color: #f44336;
    color: white;
}
</style>
<body>
    <div class="profile-icon" style="text-align:center; margin-top:50px;">
        <i class="fas fa-user-circle"></i>
    </div>
    <h2>Edit Profile</h2>

    <?php if (isset($_SESSION['message'])): ?>
    <div class="notification <?php echo $_SESSION['message_type']; ?>">
        <?php echo $_SESSION['message']; unset($_SESSION['message'], $_SESSION['message_type']); ?>
    </div>
    <?php endif; ?>

    <form method="post" action="update_profile.php">
        <label for="first_name">First Name:</label>
        <input type="text" id="first_name" name="first_name" value="<?php echo htmlspecialchars($firstName); ?>" required><br><br>

        <label for="last_name">Last Name:</label>
        <input type="text" id="last_name" name="last_name" value="<?php echo htmlspecialchars($lastName); ?>" required><br><br>

        <label for="date_of_birth">Date of Birth:</label>
        <input type="date" id="date_of_birth" name="date_of_birth" value="<?php echo htmlspecialchars($dateOfBirth); ?>" required><br><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required><br><br>

        <label for="phone">Phone:</label>
        <input type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($phone); ?>" required><br><br>

        <label for="address">Address:</label>
        <textarea id="address" name="address" required><?php echo htmlspecialchars($address); ?></textarea><br><br>

        <div class="button-container">
            <button type="submit">Update Profile</button>
            <button type="button" class="dismiss" onclick="window.location.href='dashboard.php'">Dismiss</button>
        </div>
    </form>
</body>
</html>
