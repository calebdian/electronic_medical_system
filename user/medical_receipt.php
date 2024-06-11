
<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

$user = $_SESSION['user']; // Assuming user data is stored in the session
$firstName = $user['first_name'];
$lastName = $user['last_name'];
$dateOfBirth = $user['date_of_birth'];
$email = $user['email'];
$phone = $user['phone'];

if (!isset($_GET['submission_date'])) {
    die("Submission date not provided.");
}

$submission_date = $_GET['submission_date'];

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "electronic_medical_system";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch disease details
$sql = "SELECT symptoms, disease, prescription FROM diseasedetails WHERE user_id = ? AND submission_date = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("is", $user['patient_id'], $submission_date);
$stmt->execute();
$stmt->bind_result($symptoms, $disease, $prescription);
$stmt->fetch();
$stmt->close();

// Fetch ailment data
$sql = "SELECT dosage, billing FROM ailment_data WHERE disease_name = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $disease);
$stmt->execute();
$stmt->bind_result($dosage, $billing);
$stmt->fetch();
$stmt->close();

if ($dosage) {
    $medication = strtok($dosage, " ");
} else {
    $medication = "N/A";
    $dosage = "N/A";
}

if (!$billing) {
    $billing = "N/A";
}

preg_match('/\d+/', $billing, $matches);
$totalCost = $matches[0] ?? 'N/A';

// Fetch doctor information
$docDetails = null;
$sql = "SELECT doc_commented FROM diseasedetails WHERE user_id = ? AND submission_date = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("is", $user['patient_id'], $submission_date);
$stmt->execute();
$stmt->bind_result($docCommentedId);
$stmt->fetch();
$stmt->close();

if ($docCommentedId) {
    $sql = "SELECT first_name, last_name, email, phone FROM medics WHERE medic_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $docCommentedId);
    $stmt->execute();
    $stmt->bind_result($docFirstName, $docLastName, $docEmail, $docPhone);
    $stmt->fetch();
    $docDetails = [
        'first_name' => $docFirstName,
        'last_name' => $docLastName,
        'email' => $docEmail,
        'phone' => $docPhone
    ];
    $stmt->close();
}

// Fetch pharmacist information
$pharmacistDetails = null;
$sql = "SELECT pharmacist_commented FROM diseasedetails WHERE user_id = ? AND submission_date = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("is", $user['patient_id'], $submission_date);
$stmt->execute();
$stmt->bind_result($pharmacistCommentedId);
$stmt->fetch();
$stmt->close();
echo $pharmacistCommentedId;

if ($pharmacistCommentedId) {
    $sql = "SELECT first_name, last_name, email, phone FROM pharmacist WHERE pharmacist_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $pharmacistCommentedId);
    $stmt->execute();
    $stmt->bind_result($pharmacistFirstName, $pharmacistLastName, $pharmacistEmail, $pharmacistPhone);
    $stmt->fetch();
    $pharmacistDetails = [
        'first_name' => $pharmacistFirstName,
        'last_name' => $pharmacistLastName,
        'email' => $pharmacistEmail,
        'phone' => $pharmacistPhone
    ];
    $stmt->close();
}

$conn->close();

// Generate a unique serial number (e.g., based on current timestamp and user ID)
$serialNumber = "SN" . time() . $user['patient_id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medical Billing Invoice</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: 'Helvetica Neue', Arial, sans-serif;
            background-color: #f1f1f1;
            margin: 0;
            padding: 20px;
        }
        .invoice {
            position: relative;
            max-width: 800px;
            margin: 0 auto;
            background-color: #fff;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }
        .invoice-header, .invoice-section {
            margin-bottom: 30px;
        }
        .invoice-header h1 {
            display: flex;
            align-items: center;
            color: #007bff;
        }
        .invoice-header h1 i {
            margin-right: 10px;
            color: #28a745;
        }
        .invoice-details, .invoice-section {
            margin-bottom: 30px;
        }
        .invoice-details p, .invoice-section p {
            margin: 5px 0;
        }
        .invoice-items {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }
        .invoice-items th, .invoice-items td {
            border: 1px solid #ddd;
            padding: 12px;
            width: 50%;
        }
        .invoice-items th {
            background-color: #007bff;
            color: #fff;
        }
        .row {
            display: flex;
            justify-content: space-between;
        }
        .col {
            flex: 1;
            padding: 0 10px;
        }
        .col h2 {
            color: #28a745;
        }
        .col p {
            margin: 5px 0;
        }
        .total {
            font-size: 1.5em;
            text-align: right;
            font-weight: bold;
        }
        .approved-stamp {
            text-align: center;
            margin-top: 20px;
        }
        .approved-stamp img {
            width: 100px;
        }
        .doctor-signature {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-direction: row-reverse;
            margin-top: 40px;
        }
        .doctor-details {
            text-align: left;
        }
        .doctor-details p {
            margin: 5px 0;
        }
        .qr-code {
            text-align: center;
            margin-bottom: 50px;
        }
        .qr-code img {
            width: 150px;
            height: 150px;
        }
        .billing-info {
            text-align: right;
        }
        .serial-number {
            text-align: right;
            font-weight: bold;
            margin-bottom: 20px;
        }
        .watermark {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 4em;
            color: rgba(0, 0, 0, 0.05);
            pointer-events: none;
            user-select: none;
        }
    </style>
</head>
<body>

<div class="invoice">
    <div class="watermark">Medical Receipt</div>
    <div class="invoice-header">
        <h1><i class="fas fa-file-medical-alt"></i> Medical Receipt</h1>
        <div class="serial-number">
            <p>Serial Number: <?php echo htmlspecialchars($serialNumber); ?></p>
        </div>
        <div class="billing-info">
            <h2>Billing Information</h2>
            <p><strong>Total Cost:</strong> $<?php echo htmlspecialchars($totalCost); ?></p>
        </div>
    </div>

    <div class="invoice-details">
        <div class="row">
            <div class="col">
                <h2>Patient Information</h2>
                <p><strong>Name:</strong> <?php echo htmlspecialchars($firstName . ' ' . $lastName); ?></p>
                <p><strong>Date of Birth:</strong> <?php echo htmlspecialchars($dateOfBirth); ?></p>
                <p><strong>Email:</strong> <?php echo htmlspecialchars($email); ?></p>
                <p><strong>Phone:</strong> <?php echo htmlspecialchars($phone); ?></p>
            </div>
            <?php if ($pharmacistDetails): ?>
                <div class="col">
                    <h2>Pharmacist's Information</h2>
                    <?php echo htmlspecialchars($pharmacistDetails['first_name'] . ' ' . $pharmacistDetails['last_name']); ?></p>
                    <p><strong>Email:</strong> <?php echo htmlspecialchars($pharmacistDetails['email']); ?></p>
                    <p><strong>Phone:</strong> <?php echo htmlspecialchars($pharmacistDetails['phone']); ?></p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <table class="invoice-items">
        <thead>
            <tr>
                <th>Item</th>
                <th>Description</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Symptoms</td>
                <td><?php echo htmlspecialchars($symptoms); ?></td>
            </tr>
            <tr>
                <td>Disease</td>
                <td><?php echo htmlspecialchars($disease); ?></td>
            </tr>
            <tr>
                <td>Prescription</td>
                <td><?php echo htmlspecialchars($prescription); ?></td>
            </tr>
            <tr>
                <td>Dosage</td>
                <td><?php echo htmlspecialchars($dosage); ?></td>
            </tr>
            <tr>
                <td>Medication</td>
                <td><?php echo htmlspecialchars($medication); ?></td>
            </tr>
        </tbody>
    </table>

    <div class="doctor-signature">
        <div class="doctor-details">
            <?php if ($docDetails): ?>
                <h2>Doctor Details</h2>
                <p><strong>Doctor:</strong> <?php echo htmlspecialchars($docDetails['first_name'] . ' ' . $docDetails['last_name']); ?></p>
                <p><strong>Email:</strong> <?php echo htmlspecialchars($docDetails['email']); ?></p>
                <p><strong>Phone:</strong> <?php echo htmlspecialchars($docDetails['phone']); ?></p>
            <?php endif; ?>
        </div>
        <div class="signature-date">
            <p><strong>Date:</strong> <?php echo date("d.m.Y"); ?></p>
        </div>
    </div>

    <div class="qr-code">
        <img src="../Images/qr-code.png" alt="QR Code">
        <p>Scan QR Code for details</p>
    </div>
</div>

</body>
</html>
