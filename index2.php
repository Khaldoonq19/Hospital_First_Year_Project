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
    <?php include("NavBar2.php"); ?>

    <div class="home-panel">
        <p class="eyebrow">Doctor Dashboard</p>
        <h1>Welcome to 4L Hospital</h1>
        <h2>Review appointments, patient details, and medical history in one place.</h2>
        <div class="quick-actions">
            <a href="viewAppointmentPage.php">View Appointments</a>
            <a href="viewPatientPage.php">View Patients</a>
            <a href="viewHistoryPage.php">Medical History</a>
        </div>
    </div>
</body>

</html>
