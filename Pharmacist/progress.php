<?php
session_start();

// Simulate the drug testing process
function testDrug($drugName) {
    // Add your logic to test the drug (e.g., querying a database or an API)
    // For the sake of this example, we will randomly determine if the drug is safe or not
    $isSafe = rand(0, 1) ? true : false;
    return $isSafe;
}

$drugName = isset($_GET['drugName']) ? $_GET['drugName'] : 'Unknown';
$isSafe = testDrug($drugName);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Drug Testing - <?php echo htmlspecialchars($drugName); ?></title>
    <style>
        .progress-container {
            width: 80%;
            background-color: #f3f3f3;
            margin: 50px auto;
            padding: 10px;
            border-radius: 4px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .progress-bar {
            width: 0;
            height: 30px;
            background-color: #4caf50;
            text-align: center;
            line-height: 30px;
            color: white;
            border-radius: 4px;
            transition: width 2s;
        }

        .result {
            text-align: center;
            margin-top: 20px;
            font-size: 18px;
        }
    </style>
</head>
<body>
    <div class="progress-container">
        <div class="progress-bar" id="progressBar">0%</div>
    </div>
    <div class="result" id="result"></div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var progressBar = document.getElementById('progressBar');
            var result = document.getElementById('result');
            var width = 0;
            var isSafe = <?php echo json_encode($isSafe); ?>;

            var interval = setInterval(function() {
                if (width >= 100) {
                    clearInterval(interval);
                    // Display the result based on the PHP variable
                    result.textContent = isSafe ? 'The drug is safe for use.' : 'The drug is not safe for use.';
                    setTimeout(function() {
                        window.location.href = 'drug_inventory.php'; // Redirect back to the previous page
                    }, 2000); // Wait 2 seconds before redirecting
                } else {
                    width++;
                    progressBar.style.width = width + '%';
                    progressBar.textContent = width + '%';
                }
            }, 20); // Adjust speed as needed
        });
    </script>
</body>
</html>
