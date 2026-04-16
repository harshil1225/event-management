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
    $database = "client";

    // Establishing connection to the database
    $con = mysqli_connect($hostname, $username, $password, $database);

    // Check connection
    if (!$con) {
        die("Error in Connection: " . mysqli_error($con));
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
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $phone = mysqli_real_escape_string($con, $_POST['phone']);
    $eventType = mysqli_real_escape_string($con, $_POST['event']);
    $startDate = mysqli_real_escape_string($con, $_POST['start_date']);
    $endDate = mysqli_real_escape_string($con, $_POST['end_date']);
    $venue = mysqli_real_escape_string($con, $_POST['venue']);
    $noOfGuests = mysqli_real_escape_string($con, $_POST['guests']);
    $additionalComments = mysqli_real_escape_string($con, $_POST['comments']);
    $dateTime = date('Y-m-d H:i:s'); // Current timestamp

    // SQL query to insert data into the book_event table
    $insertQuery = "INSERT INTO book_event (c_name, email, c_id, phone_number, event_type, start_date, end_date, venue, no_of_guest, additional_comments, date_time) 
                    VALUES ('$name', '$email', '$c_id', '$phone', '$eventType', '$startDate', '$endDate', '$venue', '$noOfGuests', '$additionalComments', '$dateTime')";

    // Executing query
    if (mysqli_query($con, $insertQuery)) {
        echo "Booking successful. Redirecting to payment...";
        header("Refresh: 3; URL=payment.php");
    } else {
        echo "Error: " . $insertQuery . "<br>" . mysqli_error($con);
    }

    // Close connection
    mysqli_close($con);
}
?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Event Management System - Payment Packages</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                margin: 0;
                padding: 0;
                background-color: #a28cb1;
            }

            .container {
                width: 80%;
                margin: auto;
                padding: 20px;
            }

            h1 {
                text-align: center;
                color: #333;
                margin-bottom: 50px;
                font-size: 36px;
            }

            /* Payment Packages Styles */
            .packages {
                display: flex;
                justify-content: space-around;
                gap: 20px;
            }

            .package {
                flex: 1;
                background-color: #ede3ead9;
                border-radius: 10px;
                box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
                padding: 30px;
                margin-bottom: 30px;
                transition: transform 0.3s ease;
                max-width: 300px; /* Set maximum width for each package */
                cursor: pointer;
            }

            .package:hover {
                transform: translateY(-5px);
            }

            .package h2 {
                margin-top: 0;
                color: #130214a3;
                font-size: 28px;
            }

            .package .price {
                font-size: 32px;
                font-weight: bold;
                color: #6650d7;
                margin-bottom: 20px;
            }

            .package ul {
                list-style-type: none;
                padding: 0;
                margin: 0;
            }

            .package ul li {
                color: #666;
                margin-bottom: 10px;
            }

            .package .btn {
                background-color: #6650d7;
                color: white;
                padding: 10px 20px;
                text-align: center;
                text-decoration: none;
                display: inline-block;
                border-radius: 5px;
                cursor: pointer;
                transition: background-color 0.3s ease;
            }

            .package .btn:hover {
                background-color: #45a049;
            }

            /* Payment Details Form Styles */
            .payment-form {
                max-width: 500px;
                margin: 0 auto;
                background-color: #ede3ead9;
                padding: 20px;
                border-radius: 5px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            }

            .payment-option {
                margin-bottom: 15px;
            }

            .payment-option label {
                display: inline-block;
                vertical-align: middle;
                margin-left: 10px;
            }

            .payment-option input[type="radio"] {
                display: inline-block;
                vertical-align: middle;
                margin-right: 10px;
            }

            .input-field {
                margin-bottom: 15px;
            }

            .input-field label {
                display: block;
                margin-bottom: 5px;
            }

            .input-field input[type="text"],
            .input-field textarea {
                width: 100%;
                padding: 8px;
                border: 1px solid #ccc;
                border-radius: 4px;
                box-sizing: border-box;
            }

            .input-field textarea {
                resize: vertical;
            }

            button[type="submit"] {
                background: linear-gradient(144deg, #af40ff, #5b42f3 50%, #00ddeb);
                color: white;
                padding: 10px 20px;
                border: none;
                border-radius: 4px;
                cursor: pointer;
                font-size: 16px;
                margin-top: 20px;
                display: block;
                margin-left: auto;
                margin-right: auto;
            }

            button[type="submit"]:hover {
                background: #4caf50;
            }
        </style>
    </head>
    <body>

        <div class="container">
            <h1>Select package for your event </h1>

            <!-- Payment Packages -->
            <div class="packages">
                <div class="package" onclick="updatePaymentAmount('Basic Package', '1000')">
                    <h2>Basic Package</h2>
                    <div class="price">Rs.1000</div>
                    <ul>
                        <li>Venue Booking</li>
                        <li>Basic Decoration</li>
                        <li>Music Arrangement</li>
                        <li>Basic Catering</li>
                        <li>Event Coordination</li>
                    </ul>
                    <a href="#" class="btn">Select</a>
                </div>

                <div class="package" onclick="updatePaymentAmount('Standard Package', '2000')">
                    <h2>Standard Package</h2>
                    <div class="price">Rs.2000</div>
                    <ul>
                        <li>Venue Booking</li>
                        <li>Premium Decoration</li>
                        <li>Live Music Band</li>
                        <li>Catering Service</li>
                        <li>Professional Photography</li>
                        <li>Event Planning</li>
                    </ul>

                    <a href="#" class="btn">Select</a>
                </div>

                <div class="package" onclick="updatePaymentAmount('Premium Package', '3000')">
                    <h2>Premium Package</h2>
                    <div class="price">Rs.3000</div>
                    <ul>
                        <li>Venue Booking</li>
                        <li>Custom Decoration</li>
                        <li>Live DJ</li>
                        <li>Catering & Photography</li>
                        <li>Lighting Arrangement</li>
                        <li>Videography</li>
                        <li>Luxury Transportation</li>
                    </ul>
                    <a href="#" class="btn">Select</a>
                </div>
            </div>

            <!-- Payment Details Form -->
            <div class="payment-form">
               <h2>Payment Details</h2>
<form action="process_payment.php" method="post">
    <!-- Hidden input field to store the selected package -->
    <input type="hidden" id="selected_package" name="selected_package">

    <div class="payment-option">
        <input type="radio" id="credit_card" name="payment_method" value="credit_card" onclick="showPaymentDetails('credit_card')">
        <label for="credit_card">
            <img src="card_logo.jpg" alt="Credit Card" style="width: 40px; vertical-align: middle;">
            Credit Card
        </label>
    </div>

    <div class="payment-option">
        <input type="radio" id="paytm" name="payment_method" value="paytm" onclick="showPaymentDetails('paytm')">
        <label for="paytm">
            <img src="paytem.jpg" alt="Paytm" style="width: 40px; vertical-align: middle;">
            Paytm
        </label>
    </div>

    <div class="payment-option">
        <input type="radio" id="gpay" name="payment_method" value="gpay" onclick="showPaymentDetails('gpay')">
        <label for="gpay">
            <img src="gpay.jpg" alt="GPay" style="width: 40px; vertical-align: middle;">
            GPay
        </label>
    </div>

    <div class="payment-option">
        <input type="radio" id="bank_transfer" name="payment_method" value="bank_transfer" onclick="showPaymentDetails('bank_transfer')">
        <label for="bank_transfer">
            <img src="bank_logo.jpg" alt="Bank Transfer" style="width: 40px; vertical-align: middle;">
            Bank Transfer
        </label>
    </div>

    <div class="input-field">
        <label for="amount">Amount:</label>
        <input type="text" id="amount" name="amount" placeholder="Enter amount" required readonly>
    </div>

    <div id="credit-card-details" class="payment-details" style="display:none;">
        <h3>Enter Credit Card Details</h3>
         </div>

    <div id="paytm-details" class="payment-details" style="display:none;">
        <h3>Enter Paytm Details</h3>
        </div>

    <div id="gpay-details" class="payment-details" style="display:none;">
        <h3>Enter GPay Details</h3>
         </div>

    <div id="bank-details" class="payment-details" style="display:none;">
        <h3>Enter Bank Transfer Details</h3>
        
    </div>

    <button type="submit">Book Event</button>
</form>

<script>

    function updatePaymentAmount(packageName, amount) {
        document.getElementById("selected_package").value = packageName; // Set the selected package name
        document.getElementById("amount").value = amount; // Set the amount
    }
</script>


