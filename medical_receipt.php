<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medical Receipt</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            padding: 20px;
        }
        .receipt {
            max-width: 600px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .receipt-header {
            text-align: center;
            margin-bottom: 20px;
        }
        .receipt-header h1 {
            color: #007bff;
        }
        .receipt-details {
            margin-bottom: 20px;
            padding: 10px;
            background-color: #f5f5f5;
            border-radius: 4px;
        }
        .receipt-details p {
            margin: 8px 0;
        }
        .receipt-items {
            border-collapse: collapse;
            width: 100%;
        }
        .receipt-items th,
        .receipt-items td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        .receipt-items th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>

<div class="receipt">
    <div class="receipt-header">
        <h1>Medical Receipt</h1>
    </div>

    <div class="receipt-details">
        <p><strong>Patient Name:</strong> John Doe</p>
        <p><strong>Date of Birth:</strong> 1985-10-15</p>
        <p><strong>Email:</strong> johndoe@example.com</p>
        <p><strong>Phone:</strong> +1234567890</p>
        <p><strong>Submission Date:</strong> 2022-04-25 09:30:00</p>
    </div>

    <table class="receipt-items">
        <thead>
            <tr>
                <th>Description</th>
                <th>Details</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Symptoms</td>
                <td>Fever, Headache, Cough</td>
            </tr>
            <tr>
                <td>Disease</td>
                <td>Common Cold</td>
            </tr>
            <tr>
                <td>Prescription</td>
                <td>
                    <ul>
                        <li>Paracetamol - 500mg (Take twice a day)</li>
                        <li>Cough syrup - 10ml (Before bedtime)</li>
                    </ul>
                </td>
            </tr>
        </tbody>
    </table>
</div>

</body>
</html>
