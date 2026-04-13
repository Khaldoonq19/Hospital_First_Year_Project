<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create New Staff</title>
    <link rel="stylesheet" href="style.css" />
</head>

<body>

    <?php include("NavBar.php"); ?>
    <div> <h2 class="centered-header">Create New Staff</h2>  </div>
    <div class="main">
        <form action="createNewStaffRecord.php" method="post">
            
            <input type="text" id="FirstName" name="FirstName" placeholder="FirstName" required>
            <input type="text" id="LastName" name="LastName" placeholder="LastName" required>
            <input type="text" id="StaffRole" name="StaffRole" placeholder="StaffRole" required>
            <input type="text" id="UserName" name="UserName" placeholder="UserName" required> 
            <input type="text" id="UserPassword" name="UserPassword" placeholder="UserPassword" required>       
            
            <button type="submit">Create Staff</button>
        </form>
    </div>
</body>
</html>
