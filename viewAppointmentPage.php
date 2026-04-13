<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Appointments</title>
    <link rel="stylesheet" href="style.css" />
</head>

<body>
    <?php
        include("NavBar2.php");           
    ?>
    
    <div>
        <h2 class="centered-header">View Appointments</h2>
    </div>

    <div>
      <?php
        // Connect to SQLite3 database
        $db = new SQLite3('wosp.db');

        // Query to fetch appointment details
        $select_query = "SELECT * FROM Appointment";
        $result = $db->query($select_query);
                
        // Table headers
        echo "<table>";
        echo "<tr> <th>AppointmentID</th> <th>PatientID</th> <th>StaffID</th> <th>AppointmentDate</th> <th>PatientNotes</th> </tr>";

        // Fetch and display each row
        while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
            $AppointmentID = $row['AppointmentID'];
            $PatientID = $row['PatientID'];
            $StaffID = $row['StaffID'];
            $AppointmentDate = $row['AppointmentDate'];
            $PatientNotes = $row['PatientNotes'];
                       
           echo "<tr> 
                  <td>$AppointmentID</td> 
                  <td>$PatientID</td>
                  <td>$StaffID</td>
                  <td>$AppointmentDate</td>
                  <td>$PatientNotes</td>
                </tr>";
        }

        echo "</table>";

        // Close the database connection
        $db->close();
      ?>
    </div>

</body>
</html>
