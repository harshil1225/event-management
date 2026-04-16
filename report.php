<?php
session_start();

// Check if user is logged in, if not redirect to login page
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

// Database connection
$hostname = "localhost";
$username = "root";
$password = "";
$database = "client";
$con = mysqli_connect($hostname, $username, $password, $database);
if (!$con) {
    die("Error in Connection: " . mysqli_error($con));
}

$events = [];
$payments = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the selected dates
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];

    // Fetch data from book_event table
    $event_query = "SELECT * FROM book_event WHERE date_time BETWEEN '$start_date' AND '$end_date'";
    $event_result = mysqli_query($con, $event_query);
    if (!$event_result) {
        die("Error in fetching event data: " . mysqli_error($con));
    }
    while ($event_row = mysqli_fetch_assoc($event_result)) {
        $events[] = $event_row;
    }

    // Fetch data from payment table
    $payment_query = "SELECT * FROM payment WHERE date_time BETWEEN '$start_date' AND '$end_date'";
    $payment_result = mysqli_query($con, $payment_query);
    if (!$payment_result) {
        die("Error in fetching payment data: " . mysqli_error($con));
    }
    while ($payment_row = mysqli_fetch_assoc($payment_result)) {
        $payments[] = $payment_row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report Page</title>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Open Sans', sans-serif;
            margin: 0;
            background-image: url('c_3.jpg');
            padding: 20px;
            background-color: #f9f9f9;
        }

        h1 {
    background-color: #3e3557;
    text-align: center;
    color: #ece0f5;
}
        .form-container {
            max-width: 500px;
            margin: 20px auto;
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .form-group {
            margin-bottom: 15px;
        }

        input[type="date"],
        button {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        button {
            background-color: #5b42f3;
            color: white;
            border: none;
            cursor: pointer;
            transition: background 0.3s;
        }

        button:hover {
            background-color: #4caf50;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>Event and Payment Report</h1>

    <div class="form-container">
        <form method="POST" action="">
            <div class="form-group">
                <label for="start_date">Start Date:</label>
                <input type="date" id="start_date" name="start_date" required>
            </div>
            <div class="form-group">
                <label for="end_date">End Date:</label>
                <input type="date" id="end_date" name="end_date" required>
            </div>
            <button type="submit">Generate Report</button>
        </form>
    </div>

    <?php if ($_SERVER['REQUEST_METHOD'] == 'POST'): ?>
        <div class="form-container">
            <h2>Events from <?php echo htmlspecialchars($start_date); ?> to <?php echo htmlspecialchars($end_date); ?></h2>
            <table>
                <thead>
                    <tr>
                        <th>Event ID</th>
                        <th>Client ID</th>
                        <th>Phone Number</th>
                        <th>Event Type</th>
                        <th>Date and Time</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($events)): ?>
                        <tr><td colspan="5">No events found.</td></tr>
                    <?php else: ?>
                        <?php foreach ($events as $event): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($event['event_id']); ?></td>
                                <td><?php echo htmlspecialchars($event['c_id']); ?></td>
                                <td><?php echo htmlspecialchars($event['phone_number']); ?></td>
                                <td><?php echo htmlspecialchars($event['event_type']); ?></td>
                                <td><?php echo htmlspecialchars($event['date_time']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>

           <h2>Payments from <?php echo htmlspecialchars($start_date); ?> to <?php echo htmlspecialchars($end_date); ?></h2>
<table>
    <thead>
        <tr>
            <th>Payment ID</th>
            <th>Client ID</th>
            <th>Amount</th>
            <th>Date and Time</th>
        </tr>
    </thead>
    <tbody>
        <?php if (empty($payments)): ?>
            <tr><td colspan="4">No payments found.</td></tr>
        <?php else: ?>
            <?php
            $total_amount = 0; // Initialize total amount
            foreach ($payments as $payment): 
                $total_amount += $payment['amount']; // Calculate total amount
            ?>
                <tr>
                    <td><?php echo htmlspecialchars($payment['p_id']); ?></td>
                    <td><?php echo htmlspecialchars($payment['c_id']); ?></td>
                    <td><?php echo htmlspecialchars($payment['amount']); ?></td>
                    <td><?php echo htmlspecialchars($payment['date_time']); ?></td>
                </tr>
            <?php endforeach; ?>
            <tr>
                <td colspan="2" style="text-align: right; font-weight: bold;">Total Amount:</td>
                <td><?php echo htmlspecialchars($total_amount); ?></td>
                <td></td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

                   
        </div>
    <?php endif; ?>
</body>
</html>
