<?php

include("NavBar2.php");

// Check if form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize form data
    $PatientID = trim($_POST['PatientID']);
    $PastIllnesses = trim($_POST['PastIllnesses']);
    $PastSurgeries = trim($_POST['PastSurgeries']);
    $PastAllergies = trim($_POST['PastAllergies']);
    $PastVaccinations = trim($_POST['PastVaccinations']);

    // Validate input
    if (empty($PatientID) || empty($PastIllnesses) || empty($PastSurgeries) || empty($PastAllergies) || empty($PastVaccinations)) {
        die("<p style='color: red;'>All fields are required!</p>");
    }

    // Connect to SQLite3 database
    $db = new SQLite3('wosp.db');

    // Create the MedHistory table if it doesn't exist
    $db->exec("CREATE TABLE IF NOT EXISTS MedHistory (
        HistoryID INTEGER PRIMARY KEY AUTOINCREMENT,
        PatientID INTEGER NOT NULL,
        PastIllnesses TEXT NOT NULL,
        PastSurgeries TEXT NOT NULL,
        PastAllergies TEXT NOT NULL,
        PastVaccinations TEXT NOT NULL,
        FOREIGN KEY (PatientID) REFERENCES Patient(PatientID)
    )");

    // Prepare the SQL statement using parameterized queries
    $stmt = $db->prepare("INSERT INTO MedHistory (PatientID, PastIllnesses, PastSurgeries, PastAllergies, PastVaccinations) 
                          VALUES (:PatientID, :PastIllnesses, :PastSurgeries, :PastAllergies, :PastVaccinations)");

    // Bind the parameters
    $stmt->bindValue(':PatientID', $PatientID, SQLITE3_INTEGER);
    $stmt->bindValue(':PastIllnesses', $PastIllnesses, SQLITE3_TEXT);
    $stmt->bindValue(':PastSurgeries', $PastSurgeries, SQLITE3_TEXT);
    $stmt->bindValue(':PastAllergies', $PastAllergies, SQLITE3_TEXT);
    $stmt->bindValue(':PastVaccinations', $PastVaccinations, SQLITE3_TEXT);

    // Execute the statement and check for success
    if ($stmt->execute()) {
        echo "<p style='color: green;'>Medical history has been recorded successfully!</p>";
    } else {
        echo "<p style='color: red;'>Failed to record medical history: " . $db->lastErrorMsg() . "</p>";
    }

    // Close the database connection
    $db->close();
}
?>

