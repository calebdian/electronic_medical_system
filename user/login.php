<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
        }
        form {
            max-width: 400px;
            margin: 0 auto;
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        h2 {
            text-align: center;
            color: #333;
        }
        label {
            display: block;
            margin-bottom: 8px;
        }
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 12px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        input[type="submit"] {
            background-color: #007BFF;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
        }
        .group {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .forgot-password {
            text-align: right;
            margin-top: -10px;
        }
        .forgot-password a {
            color: #007BFF;
            text-decoration: none;
        }
        .forgot-password a:hover {
            text-decoration: underline;
        }
        .message {
            text-align: center;
            color: green;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <h2>Login</h2>
    <?php
    if (isset($_GET['reset']) && $_GET['reset'] == 'success') {
        echo '<div class="message">Password has been reset successfully.</div>';
    }
    ?>
    <form action="process_login.php" method="post">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br><br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br><br>

        <div class="forgot-password">
            <a href="forgot_password.php">Forgot Password?</a>
        </div>

        <input type="submit" value="Login">
    </form>
</body>
</html>
