<?php
include("NavBar.php");

// Connect to SQLite database
$db = new SQLite3('wosp.db');

$staffDetails = null;
$StaffID = "";

// Check if a StaffID is provided for confirmation
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['confirmID'])) {
    $StaffID = $_POST['confirmID'];

    // Retrieve staff details
    $checkStmt = $db->prepare("SELECT FirstName, LastName, StaffRole, UserName FROM Staff WHERE StaffID = :StaffID");
    $checkStmt->bindValue(':StaffID', $StaffID, SQLITE3_INTEGER);
    $result = $checkStmt->execute()->fetchArray(SQLITE3_ASSOC);

    if ($result) {
        $staffDetails = $result;
    } else {
        echo "<p style='color: red;'>No staff member found with ID $StaffID.</p>";
    }
}

// If the user clicks delete, remove the staff member immediately
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['deleteID'])) {
    $StaffID = $_POST['deleteID'];

    $stmt = $db->prepare("DELETE FROM Staff WHERE StaffID = :StaffID");
    $stmt->bindValue(':StaffID', $StaffID, SQLITE3_INTEGER);

    if ($stmt->execute()) {
        echo "<p style='color: green;'>Staff member with ID $StaffID has been removed successfully.</p>";
    } else {
        echo "<p style='color: red;'>Failed to remove staff member.</p>";
    }
}

// Close the database connection
$db->close();
?>

<!-- Staff ID Confirmation Form -->
<form method="POST" action="deleteStaffPage.php">
    <label for="confirmID">Enter Staff ID:</label>
    <input type="number" name="confirmID" required>
    <button type="submit">Confirm</button>
</form>

<?php if ($staffDetails): ?>
    <h3>Staff Details</h3>
    <p><strong>First Name:</strong> <?= htmlspecialchars($staffDetails['FirstName']) ?></p>
    <p><strong>Last Name:</strong> <?= htmlspecialchars($staffDetails['LastName']) ?></p>
    <p><strong>Role:</strong> <?= htmlspecialchars($staffDetails['StaffRole']) ?></p>
    <p><strong>Username:</strong> <?= htmlspecialchars($staffDetails['UserName']) ?></p>

    <!-- Delete Button (No Confirmation) -->
    <form method="POST" action="deleteStaffPage.php">
        <input type="hidden" name="deleteID" value="<?= htmlspecialchars($StaffID) ?>">
        <button type="submit" style="color: red;">Delete Staff</button>
    </form>
<?php endif; ?>
