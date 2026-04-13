<?php
include("NavBar3.php");

// Connect to SQLite database
$db = new SQLite3('wosp.db');

$patientDetails = null;
$PatientID = "";
$message = "";
$clearFields = false;

// Confirm PatientID
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['PatientID']) && !isset($_POST['update'])) {
    $PatientID = $_POST['PatientID'];

    // Retrieve patient details
    $checkStmt = $db->prepare("SELECT FirstName, LastName, PhoneNumber, PatientGender, DateOfBirth FROM Patient WHERE PatientID = :PatientID");
    $checkStmt->bindValue(':PatientID', $PatientID, SQLITE3_INTEGER);
    $result = $checkStmt->execute()->fetchArray(SQLITE3_ASSOC);

    if ($result) {
        $patientDetails = $result;
    } else {
        $message = "<p style='color: red;'>No patient found with ID $PatientID.</p>";
    }
}

// Handle update
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    $PatientID = $_POST['PatientID'];
    $FirstName = $_POST['FirstName'];
    $LastName = $_POST['LastName'];
    $PhoneNumber = $_POST['PhoneNumber'];
    $PatientGender = $_POST['PatientGender'];
    $DateOfBirth = $_POST['DateOfBirth'];

    $updateStmt = $db->prepare("UPDATE Patient SET 
                                FirstName = :FirstName, 
                                LastName = :LastName, 
                                PhoneNumber = :PhoneNumber, 
                                PatientGender = :PatientGender, 
                                DateOfBirth = :DateOfBirth 
                                WHERE PatientID = :PatientID");

    $updateStmt->bindValue(':FirstName', $FirstName, SQLITE3_TEXT);
    $updateStmt->bindValue(':LastName', $LastName, SQLITE3_TEXT);
    $updateStmt->bindValue(':PhoneNumber', $PhoneNumber, SQLITE3_TEXT);
    $updateStmt->bindValue(':PatientGender', $PatientGender, SQLITE3_TEXT);
    $updateStmt->bindValue(':DateOfBirth', $DateOfBirth, SQLITE3_TEXT);
    $updateStmt->bindValue(':PatientID', $PatientID, SQLITE3_INTEGER);

    if ($updateStmt->execute()) {
        $message = "<p style='color: green;'>Patient details updated successfully.</p>";
        $clearFields = true;
        $patientDetails = null;
    } else {
        $message = "<p style='color: red;'>Failed to update patient details.</p>";
    }
}

// Close DB
$db->close();
?>

<!-- Display message -->
<?= $message ?>

<!-- Patient ID confirmation -->
<form method="POST" action="updatePatientPage.php">
    <label for="PatientID">Enter Patient ID:</label>
    <input type="number" name="PatientID" required>
    <button type="submit">Confirm</button>
</form>

<?php if ($patientDetails && !$clearFields): ?>
    <h3>Patient Details</h3>
    <form method="POST" action="updatePatientPage.php">
        <input type="hidden" name="PatientID" value="<?= htmlspecialchars($PatientID) ?>">

        <label>First Name:</label>
        <input type="text" name="FirstName" value="<?= htmlspecialchars($patientDetails['FirstName']) ?>" required>

        <label>Last Name:</label>
        <input type="text" name="LastName" value="<?= htmlspecialchars($patientDetails['LastName']) ?>" required>

        <label>Phone Number:</label>
        <input type="text" name="PhoneNumber" value="<?= htmlspecialchars($patientDetails['PhoneNumber']) ?>" required>

        <label>Gender:</label>
        <input type="text" name="PatientGender" value="<?= htmlspecialchars($patientDetails['PatientGender']) ?>" required>

        <label>Date of Birth:</label>
        <input type="text" name="DateOfBirth" value="<?= htmlspecialchars($patientDetails['DateOfBirth']) ?>" required>

        <button type="submit" name="update">Update Patient</button>
    </form>
<?php endif; ?>
