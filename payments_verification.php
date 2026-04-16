<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payments Verification</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-image: url('c_3.jpg');
            background-size: cover;
            background-position: center;
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            width: 90%;
            max-width: 1200px;
            margin: 20px;
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.9); /* Slightly transparent background */
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2); /* Box shadow for depth */
            text-align: center;
        }

        h2 {
            color: #1b3c5d; /* Header color */
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 0 auto; /* Center table */
            background-color: #e0f2f1; /* Light blue background color */
        }

        th, td {
            border: 1px solid #007bff; /* Change border color */
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #1b3c5d; /* Header background color */
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2; /* Alternate row color */
        }

        .delete-btn {
            background-color: #f44336;
            color: white;
            border: none;
            padding: 6px 12px;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .delete-btn:hover {
            background-color: #d32f2f;
        }
    </style>
</head>
<body>
    <div class="container">
       <?php
session_start();

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if user is logged in
    if (!isset($_SESSION['email'])) {
        header("Location: login.php");
        exit();
    }

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

    // Fetching event booking form data
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $email = mysqli_real_escape_string($con, $_POST['email']); // The client's email from the form
    $phone = mysqli_real_escape_string($con, $_POST['phone']);
    $eventType = mysqli_real_escape_string($con, $_POST['event']);
    $eventDate = mysqli_real_escape_string($con, $_POST['date']);
    $venue = mysqli_real_escape_string($con, $_POST['venue']);
    $noOfGuests = mysqli_real_escape_string($con, $_POST['guests']);
    $entertainment = mysqli_real_escape_string($con, $_POST['entertainment']);
    $specialRequests = mysqli_real_escape_string($con, $_POST['special_requests']);
    $additionalComments = mysqli_real_escape_string($con, $_POST['comments']);

    // Inserting into book_event table
    $insertEventQuery = "INSERT INTO book_event (c_name, email, c_id, phone_number, event_type, event_date, venue, no_of_guest, entertainment, special_requests, additional_comments) 
                         VALUES ('$name', '$email', '$c_id', '$phone', '$eventType', '$eventDate', '$venue', '$noOfGuests', '$entertainment', '$specialRequests', '$additionalComments')";
    
    // Execute the query
    if (!mysqli_query($con, $insertEventQuery)) {
        die("Error inserting event: " . mysqli_error($con));
    }

    // Fetching payment details
    $selectedPackage = mysqli_real_escape_string($con, $_POST['selected_package']);
    $paymentMethod = mysqli_real_escape_string($con, $_POST['payment_method']);
    $amount = mysqli_real_escape_string($con, $_POST['amount']);

    // Prepare payment method details
    $paymentDetails = "";
    if ($paymentMethod === 'credit_card') {
        $cardNumber = mysqli_real_escape_string($con, $_POST['card_number']);
        $cardHolder = mysqli_real_escape_string($con, $_POST['card_holder']);
        $expiryDate = mysqli_real_escape_string($con, $_POST['expiry_date']);
        $cvv = mysqli_real_escape_string($con, $_POST['cvv']);
        $paymentDetails = "Card Number: $cardNumber, Card Holder: $cardHolder, Expiry: $expiryDate, CVV: $cvv";
    } elseif ($paymentMethod === 'paytm') {
        $paytmNumber = mysqli_real_escape_string($con, $_POST['paytm_number']);
        $paytmUpiId = mysqli_real_escape_string($con, $_POST['paytm_upi']);
        $paymentDetails = "Paytm Number: $paytmNumber, UPI ID: $paytmUpiId";
    } elseif ($paymentMethod === 'gpay') {
        $gpayNumber = mysqli_real_escape_string($con, $_POST['gpay_number']);
        $gpayUpiId = mysqli_real_escape_string($con, $_POST['gpay_upi']);
        $paymentDetails = "GPay Number: $gpayNumber, UPI ID: $gpayUpiId";
    } elseif ($paymentMethod === 'bank_transfer') {
        $bankAccount = mysqli_real_escape_string($con, $_POST['bank_account']);
        $bankHolder = mysqli_real_escape_string($con, $_POST['bank_holder']);
        $ifscCode = mysqli_real_escape_string($con, $_POST['ifsc_code']);
        $paymentDetails = "Bank Account: $bankAccount, Account Holder: $bankHolder, IFSC: $ifscCode";
    }

    // Inserting into payment table
    $insertPaymentQuery = "INSERT INTO payment (c_id, package, p_method, amount, status, date_time, payment_details) 
                           VALUES ('$c_id', '$selectedPackage', '$paymentMethod', '$amount', 'Pending', NOW(), '$paymentDetails')";

    // Execute the payment query
    if (mysqli_query($con, $insertPaymentQuery)) {
        echo "Payment and event booked successfully!";
    } else {
        echo "Error in Payment: " . mysqli_error($con);
    }

    // Close the connection
    mysqli_close($con);
}
?>
