<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Medical History</title>
    <link rel="stylesheet" href="style.css" />
</head>

<body>

    <?php include("NavBar2.php"); ?>
    <div> <h2 class="centered-header">Add Medical History</h2> </div>
    
    <div class="main">
        <form action="createMedHistoryRecord.php" method="post">
            <input type="number" id="PatientID" name="PatientID" placeholder="Patient ID" required>
            <textarea id="PastIllnesses" name="PastIllnesses" placeholder="Past Illnesses" required></textarea>
            <textarea id="PastSurgeries" name="PastSurgeries" placeholder="Past Surgeries" required></textarea>
            <textarea id="PastAllergies" name="PastAllergies" placeholder="Past Allergies" required></textarea>
            <textarea id="PastVaccinations" name="PastVaccinations" placeholder="Past Vaccinations" required></textarea>
            
            <button type="submit">Add Medical History</button>
        </form>
    </div>

</body>
</html>

