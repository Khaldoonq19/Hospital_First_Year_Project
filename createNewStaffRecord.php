<?php

include("NavBar.php");

// Check if form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $FirstName = trim($_POST['FirstName']);
    $LastName = trim($_POST['LastName']);
    $StaffRole = trim($_POST['StaffRole']);
    $UserName = trim($_POST['UserName']);
    $UserPassword = trim($_POST['UserPassword']);

    // Validate input
    if (empty($FirstName) || empty($LastName) || empty($StaffRole) || empty($UserName) || empty($UserPassword)) {
        die("<p style='color: red;'>All fields are required!</p>");
    }

    // Hash the password for security
    $hashedPassword = password_hash($UserPassword, PASSWORD_DEFAULT);

    // Connect to SQLite3 database
    $db = new SQLite3('wosp.db');

    // Create the Staff table if it doesn't exist
    $db->exec("CREATE TABLE IF NOT EXISTS Staff (
                StaffID INTEGER PRIMARY KEY AUTOINCREMENT,
                FirstName TEXT NOT NULL,
                LastName TEXT NOT NULL,
                StaffRole TEXT NOT NULL,
                UserName TEXT NOT NULL UNIQUE,
                UserPassword TEXT NOT NULL
    )");

    // Check if username already exists
    $checkUser = $db->prepare("SELECT * FROM Staff WHERE UserName = :UserName");
    $checkUser->bindValue(':UserName', $UserName, SQLITE3_TEXT);
    $result = $checkUser->execute();

    if ($result->fetchArray()) {
        die("<p style='color: red;'>Username already exists. Please choose another.</p>");
    }

    // Prepare the SQL statement using parameterized queries
    $stmt = $db->prepare("INSERT INTO Staff (FirstName, LastName, StaffRole, UserName, UserPassword) 
                          VALUES (:FirstName, :LastName, :StaffRole, :UserName, :UserPassword)");

    // Bind the parameters
    $stmt->bindValue(':FirstName', $FirstName, SQLITE3_TEXT);
    $stmt->bindValue(':LastName', $LastName, SQLITE3_TEXT);
    $stmt->bindValue(':StaffRole', $StaffRole, SQLITE3_TEXT);
    $stmt->bindValue(':UserName', $UserName, SQLITE3_TEXT);
    $stmt->bindValue(':UserPassword', $hashedPassword, SQLITE3_TEXT); // Store hashed password

    // Execute the statement and check for success
    if ($stmt->execute()) {
        echo "<p style='color: green;'>A new staff member has been created successfully!</p>";
    } else {
        echo "<p style='color: red;'>Failed to create staff: " . $db->lastErrorMsg() . "</p>";
    }

    // Close the database connection
    $db->close();
}
?>

