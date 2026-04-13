<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Staff</title>
    <link rel="stylesheet" href="style.css" />
</head>

<body>
    <?php
        include("NavBar.php");           
    ?>

    <div>
        <h2 class="centered-header">View Staff</h2>
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
            $select_query = "SELECT * FROM Staff WHERE FirstName LIKE '%$search%' OR LastName LIKE '%$search%'";
        } else {
            $select_query = "SELECT * FROM Staff";
        }

        $result = $db->query($select_query);
        
        echo "<table>";
        echo "<tr> <th>StaffID</th> <th>FirstName</th> <th>LastName</th> <th>StaffRole</th> <th>UserName</th> <th>UserPassword</th> </tr>";

        while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
            echo "<tr> 
                    <td>{$row['StaffID']}</td> 
                    <td>{$row['FirstName']}</td>
                    <td>{$row['LastName']}</td>
                    <td>{$row['StaffRole']}</td>
                    <td>{$row['UserName']}</td>
                    <td>{$row['UserPassword']}</td>
                </tr>";
        }

        echo "</table>";
        $db->close();
      ?>
    </div>
</body>

</html>
