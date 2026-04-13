<?php
include("NavBar2.php");

// Connect to SQLite database
$db = new SQLite3('wosp.db');

$appointmentDetails = null;
$AppointmentID = "";
$message = ""; // Store success or error messages
$clearFields = false; // Determines if fields should be cleared

// Check if an AppointmentID is provided for confirmation
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['AppointmentID']) && !isset($_POST['update'])) {
    $AppointmentID = $_POST['AppointmentID'];

    // Retrieve appointment details
    $checkStmt = $db->prepare("SELECT PatientID, StaffID, AppointmentDate, PatientNotes FROM Appointment WHERE AppointmentID = :AppointmentID");
    $checkStmt->bindValue(':AppointmentID', $AppointmentID, SQLITE3_INTEGER);
    $result = $checkStmt->execute()->fetchArray(SQLITE3_ASSOC);

    if ($result) {
        $appointmentDetails = $result;
    } else {
        $message = "<p style='color: red;'>No appointment found with ID $AppointmentID.</p>";
    }
}

// If the user updates appointment details
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    $AppointmentID = $_POST['AppointmentID'];
    $PatientID = $_POST['PatientID'];
    $StaffID = $_POST['StaffID'];
    $AppointmentDate = $_POST['AppointmentDate'];
    $PatientNotes = $_POST['PatientNotes'];

    // Prepare the update statement
    $updateStmt = $db->prepare("UPDATE Appointment SET 
                                PatientID = :PatientID, 
                                StaffID = :StaffID, 
                                AppointmentDate = :AppointmentDate, 
                                PatientNotes = :PatientNotes 
                                WHERE AppointmentID = :AppointmentID");

    // Bind values to the update statement
    $updateStmt->bindValue(':PatientID', $PatientID, SQLITE3_INTEGER);
    $updateStmt->bindValue(':StaffID', $StaffID, SQLITE3_INTEGER);
    $updateStmt->bindValue(':AppointmentDate', $AppointmentDate, SQLITE3_TEXT);
    $updateStmt->bindValue(':PatientNotes', $PatientNotes, SQLITE3_TEXT);
    $updateStmt->bindValue(':AppointmentID', $AppointmentID, SQLITE3_INTEGER);

    // Execute the update statement
    if ($updateStmt->execute()) {
        $message = "<p style='color: green;'>Appointment updated successfully.</p>";
        $clearFields = true; // Clears form fields after update
        $appointmentDetails = null; // Reset form
    } else {
        $message = "<p style='color: red;'>Failed to update appointment.</p>";
    }
}

$db->close();
?>

<?= $message ?>

<form method="POST" action="updateAppointmentPage.php">
    <label for="AppointmentID">Enter Appointment ID:</label>
    <input type="number" name="AppointmentID" required>
    <button type="submit">Confirm</button>
</form>

<?php if ($appointmentDetails && !$clearFields): ?>
    <h3>Appointment Details</h3>
    <form method="POST" action="updateAppointmentPage.php">
        <input type="hidden" name="AppointmentID" value="<?= htmlspecialchars($AppointmentID) ?>">

        <label>Patient ID:</label>
        <input type="number" name="PatientID" value="<?= htmlspecialchars($appointmentDetails['PatientID']) ?>" required>

        <label>Staff ID:</label>
        <input type="number" name="StaffID" value="<?= htmlspecialchars($appointmentDetails['StaffID']) ?>" required>

        <label>Appointment Date:</label>
        <input type="datetime-local" name="AppointmentDate" value="<?= htmlspecialchars($appointmentDetails['AppointmentDate']) ?>" required>

        <label>Patient Notes:</label>
        <textarea name="PatientNotes" required><?= htmlspecialchars($appointmentDetails['PatientNotes']) ?></textarea>

        <button type="submit" name="update">Update Appointment</button>
    </form>
<?php endif; ?>
