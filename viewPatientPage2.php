<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Patients</title>
    <link rel="stylesheet" href="style.css" />
</head>

<body>
    <?php
        include("NavBar3.php");           
    ?>

    <div>
        <h2 class="centered-header">View Patients</h2>
        <form method="GET" action="">
            <input type="text" name="search" placeholder="Search by First or Last Name" />
            <button type="submit">Search</button>
        </form>
    </div>

    <div>
      <?php
        $db = new SQLite3('wosp.db');
        $search = isset($_GET['search']) ? SQLite3::escapeString($_GET['search']) : '';

        if ($search) {
            $select_query = "SELECT * FROM Patient WHERE FirstName LIKE '%$search%' OR LastName LIKE '%$search%'";
        } else {
            $select_query = "SELECT * FROM Patient";
        }

        $result = $db->query($select_query);
        
        echo "<table>";
        echo "<tr> <th>PatientID</th> <th>FirstName</th> <th>LastName</th> <th>PhoneNumber</th> <th>PatientGender</th> <th>DateOfBirth</th> </tr>";

        while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
            echo "<tr> 
                    <td>{$row['PatientID']}</td> 
                    <td>{$row['FirstName']}</td>
                    <td>{$row['LastName']}</td>
                    <td>{$row['PhoneNumber']}</td>
                    <td>{$row['PatientGender']}</td>
                    <td>{$row['DateOfBirth']}</td>
                </tr>";
        }

        echo "</table>";
        $db->close();
      ?>
    </div>
</body>

</html>