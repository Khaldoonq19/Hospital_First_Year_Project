<?php
include("NavBar2.php");

// Connect to SQLite database
$db = new SQLite3('wosp.db');

$historyDetails = null;
$HistoryID = "";
$message = ""; // Store success or error messages
$clearFields = false; // Determines if fields should be cleared

// Check if a HistoryID is provided for confirmation
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['HistoryID']) && !isset($_POST['update'])) {
    $HistoryID = $_POST['HistoryID'];

    // Retrieve medical history details
    $checkStmt = $db->prepare("SELECT PatientID, PastIllnesses, PastSurgeries, PastAllergies, PastVaccinations FROM MedHistory WHERE HistoryID = :HistoryID");
    $checkStmt->bindValue(':HistoryID', $HistoryID, SQLITE3_INTEGER);
    $result = $checkStmt->execute()->fetchArray(SQLITE3_ASSOC);

    if ($result) {
        $historyDetails = $result;
    } else {
        $message = "<p style='color: red;'>No medical history found with ID $HistoryID.</p>";
    }
}

// If the user updates medical history details
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    $HistoryID = $_POST['HistoryID'];
    $PatientID = $_POST['PatientID'];
    $PastIllnesses = $_POST['PastIllnesses'];
    $PastSurgeries = $_POST['PastSurgeries'];
    $PastAllergies = $_POST['PastAllergies'];
    $PastVaccinations = $_POST['PastVaccinations'];

    // Prepare the update statement
    $updateStmt = $db->prepare("UPDATE MedHistory SET 
                                PatientID = :PatientID, 
                                PastIllnesses = :PastIllnesses, 
                                PastSurgeries = :PastSurgeries, 
                                PastAllergies = :PastAllergies, 
                                PastVaccinations = :PastVaccinations 
                                WHERE HistoryID = :HistoryID");

    // Bind values to the update statement
    $updateStmt->bindValue(':PatientID', $PatientID, SQLITE3_INTEGER);
    $updateStmt->bindValue(':PastIllnesses', $PastIllnesses, SQLITE3_TEXT);
    $updateStmt->bindValue(':PastSurgeries', $PastSurgeries, SQLITE3_TEXT);
    $updateStmt->bindValue(':PastAllergies', $PastAllergies, SQLITE3_TEXT);
    $updateStmt->bindValue(':PastVaccinations', $PastVaccinations, SQLITE3_TEXT);
    $updateStmt->bindValue(':HistoryID', $HistoryID, SQLITE3_INTEGER);

    // Execute the update statement
    if ($updateStmt->execute()) {
        $message = "<p style='color: green;'>Medical history updated successfully.</p>";
        $clearFields = true; // Clears form fields after update
        $historyDetails = null; // Reset form
    } else {
        $message = "<p style='color: red;'>Failed to update medical history.</p>";
    }
}

// Close the database connection
$db->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Medical History</title>
    <link rel="stylesheet" href="style.css" />
</head>

<body>

    <div>
        <h2 class="centered-header">Update Medical History</h2>
    </div>

    <!-- Display Messages -->
    <?= $message ?>

    <!-- History ID Confirmation Form -->
    <form method="POST" action="updateMedHistoryPage.php">
        <label for="HistoryID">Enter History ID:</label>
        <input type="number" name="HistoryID" required>
        <button type="submit">Confirm</button>
    </form>

    <?php if ($historyDetails && !$clearFields): ?>
        <h3>Medical History Details</h3>
        <form method="POST" action="updateMedHistoryPage.php">
            <input type="hidden" name="HistoryID" value="<?= htmlspecialchars($HistoryID) ?>">

            <label>Patient ID:</label>
            <input type="number" name="PatientID" value="<?= htmlspecialchars($historyDetails['PatientID']) ?>" required>

            <label>Past Illnesses:</label>
            <textarea name="PastIllnesses" required><?= htmlspecialchars($historyDetails['PastIllnesses']) ?></textarea>

            <label>Past Surgeries:</label>
            <textarea name="PastSurgeries" required><?= htmlspecialchars($historyDetails['PastSurgeries']) ?></textarea>

            <label>Past Allergies:</label>
            <textarea name="PastAllergies" required><?= htmlspecialchars($historyDetails['PastAllergies']) ?></textarea>

            <label>Past Vaccinations:</label>
            <textarea name="PastVaccinations" required><?= htmlspecialchars($historyDetails['PastVaccinations']) ?></textarea>

            <button type="submit" name="update">Update Medical History</button>
        </form>
    <?php endif; ?>

</body>

</html>

