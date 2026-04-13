<?php

include("NavBar2.php");

// Check if form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $PatientID = trim($_POST['PatientID']);
    $StaffID = trim($_POST['StaffID']);
    $AppointmentDate = trim($_POST['AppointmentDate']);
    $PatientNotes = trim($_POST['PatientNotes']);

    // Validate input
    if (empty($PatientID) || empty($StaffID) || empty($AppointmentDate) || empty($PatientNotes)) {
        die("<p style='color: red;'>All fields are required!</p>");
    }

    // Connect to SQLite3 database
    $db = new SQLite3('wosp.db');

    // Create the Appointments table if it doesn't exist
    $db->exec("CREATE TABLE IF NOT EXISTS Appointment (
                AppointmentID INTEGER PRIMARY KEY AUTOINCREMENT,
                PatientID INTEGER NOT NULL,
                StaffID INTEGER NOT NULL,
                AppointmentDate TEXT NOT NULL,
                PatientNotes TEXT NOT NULL,
                FOREIGN KEY (PatientID) REFERENCES Patients(PatientID),
                FOREIGN KEY (StaffID) REFERENCES Staff(StaffID)
    )");

    // Prepare the SQL statement using parameterized queries
    $stmt = $db->prepare("INSERT INTO Appointment (PatientID, StaffID, AppointmentDate, PatientNotes) 
                          VALUES (:PatientID, :StaffID, :AppointmentDate, :PatientNotes)");

    // Bind the parameters
    $stmt->bindValue(':PatientID', $PatientID, SQLITE3_INTEGER);
    $stmt->bindValue(':StaffID', $StaffID, SQLITE3_INTEGER);
    $stmt->bindValue(':AppointmentDate', $AppointmentDate, SQLITE3_TEXT);
    $stmt->bindValue(':PatientNotes', $PatientNotes, SQLITE3_TEXT);

    // Execute the statement and check for success
    if ($stmt->execute()) {
        echo "<p style='color: green;'>The appointment has been created successfully!</p>";
    } else {
        echo "<p style='color: red;'>Failed to create appointment: " . $db->lastErrorMsg() . "</p>";
    }

    // Close the database connection
    $db->close();
}
?>
