<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Signup - EMR System</title>
    <link rel="stylesheet" href="css/style.css"> <!-- Include your CSS file here -->
</head>
<body>

   

    <!-- Doctor Signup Form Section -->
    <section class="signup-form">
        <div class="container">
            <h2>Doctor Signup</h2>
            <form action="process_doctor_signup.php" method="post">
                <label for="name">Full Name:</label>
                <input type="text" id="name" name="name" required><br><br>

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required><br><br>

                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required><br><br>

                <label for="specialization">Specialization:</label>
                <input type="text" id="specialization" name="specialization" required><br><br>

                <input type="submit" value="Signup">
            </form>
        </div>
    </section>

</body>
</html>
