<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Login - EMR System</title>
    <link rel="stylesheet" href="css/style.css"> <!-- Include your CSS file here -->
</head>
<body>


    <!-- Doctor Login Form Section -->
    <section class="login-form">
        <div class="container">
            <h2>Doctor Login</h2>
            <form action="process_doctor_login.php" method="post">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required><br><br>

                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required><br><br>

                <input type="submit" value="Login">
            </form>
        </div>
    </section>

</body>
</html>
