<?php
session_start(); // Start session

// If already logged in, redirect to appropriate homepage
if (isset($_SESSION['UserName'])) {
    if ($_SESSION['StaffRole'] === 'Admin') {
        header("Location: index.php");
    } elseif ($_SESSION['StaffRole'] === 'Doctor') {
        header("Location: index2.php");
    } elseif ($_SESSION['StaffRole'] === 'Receptionist') {
        header("Location: index3.php");
    }
    exit();
}

// Handle login request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $db = new PDO("sqlite:wosp.db"); // Connect to database
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $username = $_POST['UserName'];
        $password = $_POST['UserPassword'];

        // Query to check user credentials
        $stmt = $db->prepare("SELECT * FROM staff WHERE UserName = :username AND UserPassword = :password");
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $password);
        $stmt->execute();
        
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            // Set session variables
            $_SESSION['UserName'] = $user['UserName'];
            $_SESSION['StaffRole'] = $user['StaffRole'];

            // Redirect based on role
            if ($user['StaffRole'] === 'Admin') {
                header("Location: index.php");
            } elseif ($user['StaffRole'] === 'Doctor') {
                header("Location: index2.php");
            } elseif ($user['StaffRole'] === 'Receptionist') {
                header("Location: index3.php");
            } else {
                $error = "Access denied! Only Admins, Doctors, and Receptionists can log in.";
            }
            exit();
        } else {
            $error = "Invalid username or password!";
        }
    } catch (PDOException $e) {
        $error = "Database error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - 4L Hospital</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>

<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h3 class="text-center">Login</h3>
                        
                        <?php if (isset($error)): ?>
                            <div class="alert alert-danger"><?php echo $error; ?></div>
                        <?php endif; ?>

                        <form method="post">
                            <div class="mb-3">
                                <label for="UserName" class="form-label">Username</label>
                                <input type="text" class="form-control" id="UserName" name="UserName" required>
                            </div>

                            <div class="mb-3">
                                <label for="UserPassword" class="form-label">Password</label>
                                <input type="password" class="form-control" id="UserPassword" name="UserPassword" required>
                            </div>

                            <button type="submit" class="btn btn-primary w-100">Login</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
