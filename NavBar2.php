<?php
session_start(); // Start session
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>4L Hospital</title>
    
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">

    <!-- Font Awesome for Icons -->
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>

    <style>
        /* General Page Styling */
        body {
            background-color: #f8f9fa;
            font-family: 'Arial', sans-serif;
        }

        /* Navigation Bar */
        .navbar {
            background-color: #343a40;
            padding: 15px;
        }
        
        .navbar-brand {
            color: white !important;
            font-size: 24px;
            font-weight: bold;
        }

        .dropdown .dropbtn {
            background-color: #007bff;
            color: white;
            padding: 10px 16px;
            border: none;
            font-size: 16px;
            cursor: pointer;
            border-radius: 5px;
            transition: 0.3s;
        }

        .dropdown .dropbtn:hover {
            background-color: #0056b3;
        }

        /* Dropdown Content */
        .dropdown-content {
            display: none;
            position: absolute;
            background-color: white;
            min-width: 220px;
            box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.2);
            z-index: 1;
            border-radius: 5px;
            overflow: hidden;
        }

        .dropdown-content a {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
            transition: 0.3s;
        }

        .dropdown-content a:hover {
            background-color: #007bff;
            color: white;
        }

        .dropdown:hover .dropdown-content {
            display: block;
        }

        /* Logout Button */
        .logout-btn {
            background-color: #dc3545;
            color: white;
            padding: 10px 16px;
            border: none;
            font-size: 16px;
            cursor: pointer;
            border-radius: 5px;
            transition: 0.3s;
        }

        .logout-btn:hover {
            background-color: #b02a37;
        }
    </style>
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg">
            <div class="container-fluid">
                <a class="navbar-brand" href="index2.php">4L Hospital</a>

                <div class="dropdown">
                    <button class="dropbtn">Appointment <i class="fa fa-user-plus"></i></button>
                    <div class="dropdown-content">
                        <a href="createNewAppointmentPage.php">Create New Appointment</a>
                        <a href="viewAppointmentPage.php">View Appointment</a>
                        <a href="deleteAppointment.php">Delete Appointment</a>
                        <a href="updateAppointmentPage.php">Update Appointment</a>
                    </div>
                </div>

                <div class="dropdown">
                    <button class="dropbtn">Patient <i class="fa fa-user-times"></i></button>
                    <div class="dropdown-content">
                        <a href="viewPatientPage.php">View Patient</a>
                        <a href="viewHistoryPage.php">View Medical History</a>
                        <a href="updateMedHistoryPage.php">Update Medical History</a>
                        <a href="createMedHistoryPage.php">Add Medical History</a>
                    </div>
                </div>

                <!-- Logout Button -->
                <?php if (isset($_SESSION['UserName'])): ?>
                    <a href="logout.php" class="logout-btn">Logout <i class="fa fa-sign-out-alt"></i></a>
                <?php endif; ?>

            </div>
        </nav>
    </header>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
