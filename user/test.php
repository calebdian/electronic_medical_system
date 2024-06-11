<?php
// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "electronic_medical_system";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to extract keywords from a symptom string
function extract_keywords($text) {
    $stopWords = ['i', 'have', 'that', 'is', 'the', 'a', 'an', 'and', 'or', 'to', 'of', 'with', 'it', 'in', 'on', 'for', 'by', 'this', 'that', 'at', 'which', 'be', 'am', 'are', 'was', 'were', 'can', 'could', 'should', 'would', 'may', 'might', 'will', 'shall', 'not', 'so', 'if', 'as', 'but', 'just', 'too', 'very'];
    $text = strtolower($text);
    $text = preg_replace('/[^a-z0-9\s,]/', '', $text); // Allow commas in the text
    $words = explode(',', $text); // Explode using commas

    $words = array_diff($words, ['coma']);

    $keywords = [];
    foreach ($words as $word) {
        $word = trim($word);
        $word_keywords = explode(' ', $word); // Explode each word to handle multiple words separated by spaces
        $keywords = array_merge($keywords, $word_keywords);
    }
    
    $keywords = array_diff($keywords, $stopWords);
    return array_unique($keywords);
}

// Example Symptom Statements
$symptom_statement1 = "I have headache and vomiting";
$symptom_statement2 = "fever,chills,sweating,headache,nausea,vomiting";

// Extract keywords and count occurrences for Symptom Statement 1
$keywords1 = extract_keywords($symptom_statement1);
$keyword_counts1 = array_count_values($keywords1);

// Extract keywords and count occurrences for Symptom Statement 2
$keywords2 = extract_keywords($symptom_statement2);
$keyword_counts2 = array_count_values($keywords2);

// Find matching symptoms based on similar number of keywords
$matching_symptoms = [];
foreach ($keyword_counts1 as $keyword => $count1) {
    if (isset($keyword_counts2[$keyword]) && $keyword_counts2[$keyword] === $count1) {
        $matching_symptoms[] = $keyword;
    }
}

// Echo output for matching symptoms
echo "Matching symptoms based on similar number of keywords: ";
echo "</br>";
foreach ($matching_symptoms as $symptom) {
    echo "$symptom";
    echo "</br>";
}

// Close connection
$conn->close();
?>
