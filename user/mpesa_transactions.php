<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>M-Pesa Transactions</title>
    <link rel="stylesheet" href="styles.css">
    <style>
     body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
}

header {
    background-color: #007bff; /* Header background color */
    color: #fff; /* Header text color */
    text-align: center;
    padding: 20px 0;
}

main {
    padding: 20px;
}

.transaction-history {
    background-color: #f9f9f9; /* Transaction history background color */
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Box shadow for card-like effect */
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

th, td {
    padding: 10px;
    border-bottom: 1px solid #ddd;
    text-align: left;
}

th {
    background-color: #f2f2f2; /* Table header background color */
}

footer {
    background-color: #007bff; /* Footer background color */
    color: #fff; /* Footer text color */
    text-align: center;
    padding: 10px 0;
    position: fixed;
    bottom: 0;
    width: 100%;
}
    </style>
</head>
<body>
    <header>
        <h1>M-Pesa Transactions</h1>
    </header>

    <main>
        <section class="transaction-history">
            <h2>Transaction History</h2>
            <!-- Transaction history content goes here -->
            <table>
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Amount</th>
                        <th>Type</th>
                        <th>Sender/Receiver</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Transaction rows dynamically generated here -->
                    <tr>
                        <td>2024-06-10</td>
                        <td>$50.00</td>
                        <td>Received</td>
                        <td>User123</td>
                    </tr>
                    <!-- More transaction rows -->
                </tbody>
            </table>
        </section>
    </main>

    <footer>
        <p>&copy; 2024 Your Company</p>
    </footer>
</body>
</html>
