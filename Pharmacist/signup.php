<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pharmacist Signup</title>
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
        input[type="text"],
        input[type="email"],
        input[type="date"],
        input[type="password"],
        textarea {
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
        .group{
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
    </style>
</head>
<body>
    <h2>Pharmacist Signup</h2>
    <form action="process_signup.php" method="post">
        <div class="field">
             <label for="fname">First Name:</label>
             <input type="text" id="fname" name="fname" required><br><br>
        </div>
         <div class="field">
             <label for="lname">Last Name:</label>
             <input type="text" id="lname" name="lname" required><br><br>
         </div>
        
        <div class="field">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required><br><br>
        </div>
        <div class="field">
            <label for="phone">Phone:</label>
            <input type="text" id="phone" name="phone" required><br><br>
        </div>
        <div class="field">
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required><br><br>
        </div>
        <div class="field">
            <label for="confirmPassword">Confirm Password:</label>
            <input type="password" id="confirmPassword" name="confirmPassword" required><br><br>
        </div>
        <input type="submit" value="Submit">
    </form>
</body>
</html>
