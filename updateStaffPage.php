<?php
include("NavBar.php");

// Connect to SQLite database
$db = new SQLite3('wosp.db');

$staffDetails = null;
$StaffID = "";
$message = ""; // Store success or error messages
$clearFields = false; // Determines if fields should be cleared

// Check if a StaffID is provided for confirmation
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['StaffID']) && !isset($_POST['update'])) {
    $StaffID = $_POST['StaffID'];

    // Retrieve staff details
    $checkStmt = $db->prepare("SELECT FirstName, LastName, StaffRole, UserName, UserPassword FROM Staff WHERE StaffID = :StaffID");
    $checkStmt->bindValue(':StaffID', $StaffID, SQLITE3_INTEGER);
    $result = $checkStmt->execute()->fetchArray(SQLITE3_ASSOC);

    if ($result) {
        $staffDetails = $result;
    } else {
        $message = "<p style='color: red;'>No staff member found with ID $StaffID.</p>";
    }
}

// If the user updates staff details
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    $StaffID = $_POST['StaffID'];
    $FirstName = $_POST['FirstName'];
    $LastName = $_POST['LastName'];
    $StaffRole = $_POST['StaffRole'];
    $UserName = $_POST['UserName'];
    $UserPassword = $_POST['UserPassword'];

    // Prepare the update statement
    $updateStmt = $db->prepare("UPDATE Staff SET 
                                FirstName = :FirstName, 
                                LastName = :LastName, 
                                StaffRole = :StaffRole, 
                                UserName = :UserName, 
                                UserPassword = :UserPassword 
                                WHERE StaffID = :StaffID");

    // Bind values to the update statement
    $updateStmt->bindValue(':FirstName', $FirstName, SQLITE3_TEXT);
    $updateStmt->bindValue(':LastName', $LastName, SQLITE3_TEXT);
    $updateStmt->bindValue(':StaffRole', $StaffRole, SQLITE3_TEXT);
    $updateStmt->bindValue(':UserName', $UserName, SQLITE3_TEXT);
    $updateStmt->bindValue(':UserPassword', $UserPassword, SQLITE3_TEXT);
    $updateStmt->bindValue(':StaffID', $StaffID, SQLITE3_INTEGER);

    // Execute the update statement
    if ($updateStmt->execute()) {
        $message = "<p style='color: green;'>Staff details updated successfully.</p>";
        $clearFields = true; // Clears form fields after update
        $staffDetails = null; // Clear staff details to reset form
    } else {
        $message = "<p style='color: red;'>Failed to update staff details.</p>";
    }
}

// Close the database connection
$db->close();
?>

<!-- Display Messages -->
<?= $message ?>

<!-- Staff ID Confirmation Form -->
<form method="POST" action="updateStaffPage.php">
    <label for="StaffID">Enter Staff ID:</label>
    <input type="number" name="StaffID" required>
    <button type="submit">Confirm</button>
</form>

<?php if ($staffDetails && !$clearFields): ?>
    <h3>Staff Details</h3>
    <form method="POST" action="updateStaffPage.php">
        <input type="hidden" name="StaffID" value="<?= htmlspecialchars($StaffID) ?>">

        <label>First Name:</label>
        <input type="text" name="FirstName" value="<?= htmlspecialchars($staffDetails['FirstName']) ?>" required>

        <label>Last Name:</label>
        <input type="text" name="LastName" value="<?= htmlspecialchars($staffDetails['LastName']) ?>" required>

        <label>Role:</label>
        <input type="text" name="StaffRole" value="<?= htmlspecialchars($staffDetails['StaffRole']) ?>" required>

        <label>Username:</label>
        <input type="text" name="UserName" value="<?= htmlspecialchars($staffDetails['UserName']) ?>" required>

        <label>Password:</label>
        <input type="password" name="UserPassword" value="<?= htmlspecialchars($staffDetails['UserPassword']) ?>" required>

        <button type="submit" name="update">Update Staff</button>
    </form>
<?php endif; ?>




