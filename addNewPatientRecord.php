<?php

include("NavBar3.php");

// Check if form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize form data
    $FirstName = trim($_POST['FirstName']);
    $LastName = trim($_POST['LastName']);
    $PhoneNumber = trim($_POST['PhoneNumber']);
    $PatientGender = trim($_POST['PatientGender']);
    $DateOfBirth = trim($_POST['DateOfBirth']);

    // Validate input
    if (empty($FirstName) || empty($LastName) || empty($PhoneNumber) || empty($PatientGender) || empty($DateOfBirth)) {
        die("<p style='color: red;'>All fields are required!</p>");
    }

    // Connect to SQLite3 database
    $db = new SQLite3('wosp.db');

    // Create the Patient table if it doesn't exist
    $db->exec("CREATE TABLE IF NOT EXISTS Patient (
        PatientID INTEGER PRIMARY KEY AUTOINCREMENT,
        FirstName TEXT NOT NULL,
        LastName TEXT NOT NULL,
        PhoneNumber TEXT NOT NULL,
        PatientGender TEXT NOT NULL,
        DateOfBirth TEXT NOT NULL
    )");

    // Prepare the SQL statement using parameterized queries
    $stmt = $db->prepare("INSERT INTO Patient (FirstName, LastName, PhoneNumber, PatientGender, DateOfBirth) 
                          VALUES (:FirstName, :LastName, :PhoneNumber, :PatientGender, :DateOfBirth)");

    // Bind the parameters
    $stmt->bindValue(':FirstName', $FirstName, SQLITE3_TEXT);
    $stmt->bindValue(':LastName', $LastName, SQLITE3_TEXT);
    $stmt->bindValue(':PhoneNumber', $PhoneNumber, SQLITE3_TEXT);
    $stmt->bindValue(':PatientGender', $PatientGender, SQLITE3_TEXT);
    $stmt->bindValue(':DateOfBirth', $DateOfBirth, SQLITE3_TEXT);

    // Execute the statement and check for success
    if ($stmt->execute()) {
        echo "<p style='color: green;'>A new patient record has been created successfully!</p>";
    } else {
        echo "<p style='color: red;'>Failed to create patient: " . $db->lastErrorMsg() . "</p>";
    }

    // Close the database connection
    $db->close();
}
?>
