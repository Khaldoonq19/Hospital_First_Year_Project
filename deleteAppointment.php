<?php
include("NavBar2.php");

// Connect to SQLite database
$db = new SQLite3('wosp.db');

$AppointmentDetails = null;
$AppointmentID = "";

// Check if a AppointmentID is provided for confirmation
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['confirmID'])) {
    $AppointmentID = $_POST['confirmID'];

    // Retrieve Appointment details
    $checkStmt = $db->prepare("SELECT PatientID, StaffID, AppointmentDate, PatientNotes FROM Appointment WHERE AppointmentID = :AppointmentID");
    $checkStmt->bindValue(':AppointmentID', $AppointmentID, SQLITE3_INTEGER);
    $result = $checkStmt->execute()->fetchArray(SQLITE3_ASSOC);

    if ($result) {
        $AppointmentDetails = $result;
    } else {
        echo "<p style='color: red;'>No Appointment found with ID $AppointmentID.</p>";
    }
}

// If the user clicks delete, remove the Appointment member immediately
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['deleteID'])) {
    $AppointmentID = $_POST['deleteID'];

    $stmt = $db->prepare("DELETE FROM Appointment WHERE AppointmentID = :AppointmentID");
    $stmt->bindValue(':AppointmentID', $AppointmentID, SQLITE3_INTEGER);

    if ($stmt->execute()) {
        echo "<p style='color: green;'>Appointment with ID $AppointmentID has been removed successfully.</p>";
    } else {
        echo "<p style='color: red;'>Failed to remove Appointment.</p>";
    }
}

// Close the database connection
$db->close();
?>

<!-- Staff ID Confirmation Form -->
<form method="POST" action="deleteAppointment.php">
    <label for="confirmID">Enter Appointment ID:</label>
    <input type="number" name="confirmID" required>
    <button type="submit">Confirm</button>
</form>

<?php if ($AppointmentDetails): ?>
    <h3>Appointment Details</h3>
    <p><strong>PatientID:</strong> <?= htmlspecialchars($AppointmentDetails['PatientID']) ?></p>
    <p><strong>StaffID:</strong> <?= htmlspecialchars($AppointmentDetails['StaffID']) ?></p>
    <p><strong>AppointmentDate:</strong> <?= htmlspecialchars($AppointmentDetails['AppointmentDate']) ?></p>
    <p><strong>PatientNotes:</strong> <?= htmlspecialchars($AppointmentDetails['PatientNotes']) ?></p>

    <!-- Delete Button (No Confirmation) -->
    <form method="POST" action="deleteAppointment.php">
        <input type="hidden" name="deleteID" value="<?= htmlspecialchars($AppointmentID) ?>">
        <button type="submit" style="color: red;">Delete Appointment</button>
    </form>
<?php endif; ?>

