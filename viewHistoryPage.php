<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Medical History</title>
    <link rel="stylesheet" href="style.css" />
    
</head>

<body>
    <?php include("NavBar2.php"); ?>

    <div>
        <h2 class="centered-header">View Medical History</h2>
    </div>

    <div class="search-container">
        <form method="GET" action="">
            <input type="text" name="search" placeholder="Search by Patient ID or Illness..." value="<?php echo htmlspecialchars($_GET['search'] ?? '', ENT_QUOTES); ?>" />
            <button type="submit">Search</button>
        </form>
    </div>

    <div>
        <?php
            $db = new SQLite3('wosp.db');
            $search = $_GET['search'] ?? '';

            if (!empty($search)) {
                $search = SQLite3::escapeString($search);
                $select_query = "SELECT * FROM MedHistory 
                                 WHERE PatientID LIKE '%$search%' 
                                    OR PastIllnesses LIKE '%$search%'";
            } else {
                $select_query = "SELECT * FROM MedHistory";
            }

            $result = $db->query($select_query);

            echo "<table>";
            echo "<tr> 
                    <th>HistoryID</th> 
                    <th>PatientID</th> 
                    <th>PastIllnesses</th> 
                    <th>PastSurgeries</th> 
                    <th>PastAllergies</th> 
                    <th>PastVaccinations</th> 
                  </tr>";

            while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
                echo "<tr> 
                        <td>{$row['HistoryID']}</td> 
                        <td>{$row['PatientID']}</td>
                        <td>{$row['PastIllnesses']}</td>
                        <td>{$row['PastSurgeries']}</td>
                        <td>{$row['PastAllergies']}</td>
                        <td>{$row['PastVaccinations']}</td>
                      </tr>";
            }

            echo "</table>";
            $db->close();
        ?>
    </div>
</body>

</html>



