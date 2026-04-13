<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Patient</title>
    <link rel="stylesheet" href="style.css" />
</head>

<body>

    <?php include("NavBar3.php"); ?>
    <div> <h2 class="centered-header">Add Patient</h2> </div>
    
    <div class="main">
        <form action="addNewPatientRecord.php" method="post">
            <input type="text" id="FirstName" name="FirstName" placeholder="FirstName" required>
            <input type="text" id="LastName" name="LastName" placeholder="LastName" required>
            <input type="text" id="PhoneNumber" name="PhoneNumber" placeholder="PhoneNumber" required>
            <input type="text" id="PatientGender" name="PatientGender" placeholder="PatientGender" required> 
            <input type="text" id="DateOfBirth" name="DateOfBirth" placeholder="DateOfBirth" required> 
            
            <button type="submit">Add Patient</button>
        </form>
    </div>

</body>
</html>
