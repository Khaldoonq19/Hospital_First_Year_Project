<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create New Appointment</title>
    <link rel="stylesheet" href="style.css" />
</head>

<body>

    <?php include("NavBar2.php"); ?>
    <div> <h2 class="centered-header">Create New Appointment</h2> </div>
    
    <div class="main">
        <form action="createNewAppointmentRecord.php" method="post">
            <input type="text" id="PatientID" name="PatientID" placeholder="Patient ID" required>
            <input type="text" id="StaffID" name="StaffID" placeholder="Staff ID" required>
            <input type="datetime-local" id="AppointmentDate" name="AppointmentDate" required>
            <textarea id="PatientNotes" name="PatientNotes" placeholder="Patient Notes" required></textarea>
            
            <button type="submit">Create Appointment</button>
        </form>
    </div>

</body>
</html>
