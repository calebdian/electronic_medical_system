<?php
session_start(); // Start or resume session

// Include database connection file
require_once 'db_connection.php';

// Check if user is logged in
if (!isset($_SESSION['user'])) {
    header("Location: login.php"); // Redirect to login page if not logged in
    exit;
}

// Fetch user details from database
$userID = $_SESSION['user']['patient_id'];

// Retrieve user data from the database
$stmt = $pdo->prepare("SELECT * FROM patients WHERE patient_id = ?");
$stmt->execute([$userID]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Handle form submission for updating user details
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Process form data
    $firstName = $_POST['first_name'];
    $lastName = $_POST['last_name'];
    $dateOfBirth = $_POST['date_of_birth'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    // Update user details in the database
    $stmt = $pdo->prepare("UPDATE patients SET first_name = ?, last_name = ?, date_of_birth = ?, email = ?, phone = ?, address = ? WHERE patient_id = ?");
    $stmt->execute([$firstName, $lastName, $dateOfBirth, $email, $phone, $address, $userID]);

    // Redirect back to profile page with a success message
    header("Location: profile.php?updated=1");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <link rel="stylesheet" href="css/style.css"> <!-- Include your CSS file -->
</head>
<body>
    <div class="container">
        <h1>Edit Profile</h1>
        <?php if (isset($_GET['updated']) && $_GET['updated'] == 1) : ?>
            <p style="color: green;">Profile updated successfully!</p>
        <?php endif; ?>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label for="first_name">First Name:</label>
            <input type="text" id="first_name" name="first_name" value="<?php echo htmlspecialchars($user['first_name']); ?>" required><br><br>

            <label for="last_name">Last Name:</label>
            <input type="text" id="last_name" name="last_name" value="<?php echo htmlspecialchars($user['last_name']); ?>" required><br><br>

            <label for="date_of_birth">Date of Birth:</label>
            <input type="date" id="date_of_birth" name="date_of_birth" value="<?php echo htmlspecialchars($user['date_of_birth']); ?>" required><br><br>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required><br><br>

            <label for="phone">Phone:</label>
            <input type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($user['phone']); ?>" required><br><br>

            <label for="address">Address:</label>
            <textarea id="address" name="address" required><?php echo htmlspecialchars($user['address']); ?></textarea><br><br>

            <input type="submit" value="Save Changes">
        </form>
        <br>
        <a href="dashboard.php">Back to Dashboard</a>
    </div>
</body>
</html>
