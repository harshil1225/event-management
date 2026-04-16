<?php
session_start();

$hostname = "localhost";
$username = "root";
$password = "";
$database = "client";

$con = mysqli_connect($hostname, $username, $password, $database);

if (!$con) {
    die("Error in Connection" . mysqli_error($con));
}
if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Prepare the client query
    $client_query = "SELECT * FROM client1 WHERE email='$email' AND password='$password'";
    $client_result = mysqli_query($con, $client_query);

    if (mysqli_num_rows($client_result) > 0) {
        // Client login successful
        $_SESSION['email'] = $email; // Set session variable with client's email
        echo "<script>alert('Login successful')</script>";
        echo "<script>window.open('client.php','_self')</script>";
        exit();
    } else {
        // Check if it's an admin login
        $admin_query = "SELECT * FROM admin WHERE email_id='$email' AND password='$password'";
        $admin_result = mysqli_query($con, $admin_query);
        
        if (mysqli_num_rows($admin_result) > 0) {
            // Admin login successful
            $_SESSION['email'] = $email; // Set session variable with admin's email
            echo "<script>alert('Login successful')</script>";
            echo "<script>window.open('admin.php','_self')</script>";
            exit();
        } else {
            // Check if it's an organizer login
            $organizer_query = "SELECT * FROM organizer WHERE email='$email' AND password='$password'";
            $organizer_result = mysqli_query($con, $organizer_query);
            
            if (mysqli_num_rows($organizer_result) > 0) {
                // Organizer login successful
                $_SESSION['email'] = $email; // Set session variable with organizer's email
                echo "<script>alert('Login successful')</script>";
                echo "<script>window.open('organizer.php','_self')</script>";
                exit();
            } else {
                // Login failed
                echo "<script>alert('Wrong email and password')</script>";
                echo "<script>window.open('login.php','_self')</script>";
                exit();
            }
        }
    }
}
