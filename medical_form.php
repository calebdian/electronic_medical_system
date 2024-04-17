<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medical Symptom Form</title>
    <link rel="stylesheet" href="css/style.css"> <!-- Include your CSS file here -->
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar">
        <div class="container">
            <a href="#" class="logo">EMR System</a>
            <ul class="nav-links">
                <li><a href="about.php">Dashboard</a></li>
                <li><a href="index.html">home</a></li>
                <li><a href="about.php">About</a></li>
                <li><a href="medical_form.php">medicalForm</a></li>
                <li><a href="contact">UserQueries</a></li>
            </ul>
            <div class="logo">
                <a href="signup.php"><button>Signup</button></a>
                <a href="login.php"><button>login</button></a>
            </div>
        </div>
    </nav>

    <!-- Medical Symptom Form Section -->
    <section class="medical-form">
        <div class="container">
            <h2>Medical Symptom Form</h2>
            <form action="submit_symptoms.php" method="post">
                <label for="name">Your Name:</label>
                <input type="text" id="name" name="name" required><br><br>

                <label for="dob">Date of Birth:</label>
                <input type="date" id="dob" name="dob" required><br><br>

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required><br><br>

                <label for="phone">Phone:</label>
                <input type="text" id="phone" name="phone" required><br><br>

                <label for="symptoms">Describe Your Symptoms:</label>
                <textarea id="symptoms" name="symptoms" rows="5" required></textarea><br><br>

                <input type="submit" value="Submit">
            </form>
        </div>
        <a href="medical_report.php">View medical report</a>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <p>&copy; 2024 EMR System. All rights reserved.</p>
            <ul class="social-links">
                <li><a href="#">Facebook</a></li>
                <li><a href="#">Twitter</a></li>
                <li><a href="#">LinkedIn</a></li>
            </ul>
        </div>
    </footer>

</body>
</html>
