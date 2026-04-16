<?php

session_start();

// Check if user is logged in, if not redirect to login page
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

// Database connection details
$hostname = "localhost";
$username = "root";
$password = "";
$database = "client";

// Check if the form was submitted via POST method
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $con = mysqli_connect($hostname, $username, $password, $database);

    if (!$con) {
        die("Error in Connection" . mysqli_error($con));
    }

    // Update user profile
    if (isset($_POST['new-name']) && isset($_POST['new-email']) && isset($_POST['new-phone']) && isset($_POST['new-birthday']) && isset($_POST['new-gender'])) {
        // Escape user inputs for security
        $newName = mysqli_real_escape_string($con, $_POST['new-name']);
        $newEmail = mysqli_real_escape_string($con, $_POST['new-email']);
        $newPhone = mysqli_real_escape_string($con, $_POST['new-phone']);
        $newBirthday = mysqli_real_escape_string($con, $_POST['new-birthday']);
        $newGender = mysqli_real_escape_string($con, $_POST['new-gender']);

        // Fetch current user's email from session
        $email = $_SESSION['email'];

        // Update user profile in the database
        $update_query = "UPDATE client1 SET name='$newName', email='$newEmail', phone_number='$newPhone', birthday='$newBirthday', gender='$newGender' WHERE email='$email'";

        if (mysqli_query($con, $update_query)) {
            echo "Profile updated successfully.";
            // Update session with new email if changed
            $_SESSION['email'] = $newEmail;
        } else {
            echo "Error updating profile: " . mysqli_error($con);
        }
    }

    // Update user password
    if (isset($_POST['current-password']) && isset($_POST['new-password']) && isset($_POST['confirm-password'])) {
        // Fetch current user's email from session
        $email = $_SESSION['email'];

        // Escape user inputs for security
        $currentPassword = mysqli_real_escape_string($con, $_POST['current-password']);
        $newPassword = mysqli_real_escape_string($con, $_POST['new-password']);
        $confirmPassword = mysqli_real_escape_string($con, $_POST['confirm-password']);

        // Fetch current password from the database
        $password_query = "SELECT password FROM client1 WHERE email='$email'";
        $password_result = mysqli_query($con, $password_query);

        if ($password_result) {
            $row = mysqli_fetch_assoc($password_result);
            $dbPassword = $row['password'];

            // Verify if the current password matches the one in the database
            if (password_verify($currentPassword, $dbPassword)) {
                // Check if the new password matches the confirm password
                if ($newPassword === $confirmPassword) {
                    // Hash the new password
                    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

                    // Update the password in the database
                    $update_query = "UPDATE client1 SET password='$hashedPassword' WHERE email='$email'";
                    if (mysqli_query($con, $update_query)) {
                        echo "Password updated successfully.";
                    } else {
                        echo "Error updating password: " . mysqli_error($con);
                    }
                } else {
                    echo "New password and confirm password do not match.";
                }
            } else {
                echo "Current password is incorrect.";
            }
        } else {
            echo "Error fetching password: " . mysqli_error($con);
        }
    }

    // Close connection
    mysqli_close($con);
}
?>
