<?php

session_start();

// Check if the user is logged in
if (!isset($_SESSION['email'])) {
    // Redirect to the login page
    header("Location: login.php");
    exit();
}

// Proceed only if the user is logged in and the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Process the form submission
    // Your form processing code here

    // Database connection parameters
    $hostname = "localhost";
    $username = "root";
    $password = "";
    $database = "client"; // Make sure the database name is correct

    // Establishing connection to the database
    $con = mysqli_connect($hostname, $username, $password, $database);

    // Check connection
    if (!$con) {
        die("Error in Connection: " . mysqli_connect_error());
    }

    
    // Fetch user's email from session
    $userEmail = $_SESSION['email'];

    // Fetch c_id from client1 table based on the logged-in user's email
    $c_idQuery = "SELECT c_id FROM client1 WHERE email = '$userEmail'";
    $result = mysqli_query($con, $c_idQuery);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $c_id = $row['c_id'];
    } else {
        die("Error: User ID not found.");
    }

    // Fetching form data
    $package = mysqli_real_escape_string($con, $_POST['selected_package']);
    $paymentMethod = mysqli_real_escape_string($con, $_POST['payment_method']);
    $amount = mysqli_real_escape_string($con, $_POST['amount']);
    $status = "success"; // You can change this based on your application logic
    $dateTime = date('Y-m-d H:i:s'); // Current date and time

    // SQL query to insert data into the payment table
    $insertQuery = "INSERT INTO payment (c_id, package, p_method, amount, status, date_time) 
                    VALUES ('$c_id', '$package', '$paymentMethod', '$amount', '$status', '$dateTime')";

    // Executing query
    if (mysqli_query($con, $insertQuery)) {
        // Success: Display payment details
        echo '<!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Payment Confirmation</title>
            <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
            <style>
                body {
                    font-family: Arial, sans-serif;
                    background-color: #f8f9fa;
                    color: #333;
                }
                .container {
                    max-width: 600px;
                    margin: 50px auto;
                    padding: 20px;
                    border-radius: 10px;
                    box-shadow: 0 0 10px rgba(0,0,0,0.1);
                    background-color: #fff;
                }
                h1 {
                    color: #007bff;
                }
                .details {
                    margin-top: 20px;
                }
                .details div {
                    padding: 10px;
                    border-bottom: 1px solid #e9ecef;
                }
                .details div:last-child {
                    border-bottom: none;
                }
                .btn {
                    margin-top: 20px;
                }
            </style>
        </head>
        <body>
            <div class="container">
                <h1>Payment Recorded Successfully</h1>
                <div class="details">
                    <div><strong>Package:</strong> ' . htmlspecialchars($package) . '</div>
                    <div><strong>Payment Method:</strong> ' . htmlspecialchars($paymentMethod) . '</div>
                    <div><strong>Amount:</strong> Rs. ' . htmlspecialchars($amount) . '</div>
                    <div><strong>Status:</strong> ' . htmlspecialchars($status) . '</div>
                    <div><strong>Date & Time:</strong> ' . htmlspecialchars($dateTime) . '</div>
                </div>
                <a href="client.php" class="btn btn-primary">Go to Dashboard</a>
            </div>
            <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
            <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        </body>
        </html>';
    } else {
        echo "Error: " . $insertQuery . "<br>" . mysqli_error($con);
    }

    // Close connection
    mysqli_close($con);
}
?>
