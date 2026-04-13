<?php
session_start(); 

if (!isset($_SESSION['UserName'])) {
    header("Location: login.php"); 
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
    <?php include("NavBar3.php"); ?>

    <div class="home-panel">
        <p class="eyebrow">Receptionist Dashboard</p>
        <h1>Welcome to 4L Hospital</h1>
        <h2>Add, update, and find patient records with a calmer workflow.</h2>
        <div class="quick-actions">
            <a href="addNewPatientPage.php">Add Patient</a>
            <a href="viewPatientPage2.php">View Patients</a>
            <a href="updatePatientPage.php">Update Patient</a>
        </div>
    </div>
</body>

</html>
