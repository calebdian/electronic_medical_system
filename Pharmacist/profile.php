<?php
session_start(); // Start or resume session

// Include database connection file
require_once 'db_connection.php';

// Check if user is logged in
if (!isset($_SESSION['pharmacist_id'])) {
    header("Location: login.php"); // Redirect to login page if not logged in
    exit;
}

// Fetch pharmacist details from database
$pharmacistID = $_SESSION['pharmacist_id'];

// Retrieve pharmacist data from the database
$stmt = $pdo->prepare("SELECT * FROM pharmacist WHERE pharmacist_id = ?");
$stmt->execute([$pharmacistID]);
$pharmacist = $stmt->fetch(PDO::FETCH_ASSOC);

// Handle form submission for updating pharmacist details
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Process form data
    $firstName = $_POST['first_name'];
    $lastName = $_POST['last_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];

    // Check if a new password was provided
    if (!empty($password)) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("UPDATE pharmacist SET first_name = ?, last_name = ?, email = ?, phone = ?, password = ? WHERE pharmacist_id = ?");
        $stmt->execute([$firstName, $lastName, $email, $phone, $hashedPassword, $pharmacistID]);
    } else {
        $stmt = $pdo->prepare("UPDATE pharmacist SET first_name = ?, last_name = ?, email = ?, phone = ? WHERE pharmacist_id = ?");
        $stmt->execute([$firstName, $lastName, $email, $phone, $pharmacistID]);
    }

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
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }
        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            width: 100%;
        }
        h1 {
            text-align: center;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        label {
            margin: 10px 0 5px;
        }
        input[type="text"], input[type="email"], input[type="password"], textarea {
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px;
            border-radius: 5px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
        }
        a {
            display: block;
            text-align: center;
            margin-top: 10px;
            color: #007bff;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
        .success-message {
            color: green;
            text-align: center;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Edit Profile</h1>
        <?php if (isset($_GET['updated']) && $_GET['updated'] == 1) : ?>
            <p class="success-message">Profile updated successfully!</p>
        <?php endif; ?>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label for="first_name">First Name:</label>
            <input type="text" id="first_name" name="first_name" value="<?php echo htmlspecialchars($pharmacist['first_name']); ?>" required>

            <label for="last_name">Last Name:</label>
            <input type="text" id="last_name" name="last_name" value="<?php echo htmlspecialchars($pharmacist['last_name']); ?>" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($pharmacist['email']); ?>" required>

            <label for="phone">Phone:</label>
            <input type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($pharmacist['phone']); ?>" required>

            <label for="password">New Password (leave blank if not changing):</label>
            <input type="password" id="password" name="password">

            <input type="submit" value="Save Changes">
        </form>
        <a href="dashboard.php">Back to Dashboard</a>
    </div>
</body>
</html>
