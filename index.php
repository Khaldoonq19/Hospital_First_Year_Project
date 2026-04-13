<?php
session_start(); // Start session

// Check if user is logged in
if (!isset($_SESSION['UserName'])) {
    header("Location: login.php"); // Redirect to login page
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>4L Hospital</title>
    <link rel="stylesheet" href="style.css" />
</head>

<body style="background-color: #f4f4f4;">
    <?php include("NavBar.php"); ?>

    <div class="home-panel">
        <p class="eyebrow">Admin Dashboard</p>
        <h1>Welcome to 4L Hospital</h1>
        <h2>Manage staff records quickly and confidently.</h2>
        <div class="quick-actions">
            <a href="createNewStaffPage.php">Create Staff</a>
            <a href="viewStaffPage.php">View Staff</a>
            <a href="updateStaffPage.php">Update Staff</a>
        </div>
    </div>
</body>

</html>
