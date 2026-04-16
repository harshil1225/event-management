<?php
// Start the session and check for admin login
session_start();

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
    die("Error in Connection: " . mysqli_connect_error());
}

// Fetch admin profile details
$email = $_SESSION['email'];
$admin_query = "SELECT * FROM admin WHERE email_id='$email'";
$admin_result = mysqli_query($con, $admin_query);
$admin = mysqli_fetch_assoc($admin_result);

// Fetch client details (client1 table)
$client_query = "SELECT * FROM client1";
$client_result = mysqli_query($con, $client_query);

// Fetch event details (booking_event table)
$event_query = "SELECT * FROM book_event";
$event_result = mysqli_query($con, $event_query);

// Fetch payment details (payment table)
$payment_query = "SELECT * FROM payment";
$payment_result = mysqli_query($con, $payment_query);

if (!$client_result || !$event_result || !$payment_result) {
    die("Error in Query: " . mysqli_error($con));
}
?>

<div class="section" id="report-section">
    <h2>Event and Payment Reports</h2>
    <div class="form-container">
        <form id="report-form">
            <div class="form-group">
                <label for="start_date">Start Date:</label>
                <input type="date" id="start_date" name="start_date" required>
            </div>
            <div class="form-group">
                <label for="end_date">End Date:</label>
                <input type="date" id="end_date" name="end_date" required>
            </div>
            <button type="button" onclick="generateReport()">Generate Report</button>
        </form>
    </div>
    <div id="report-output">
        <!-- Dynamic report content will appear here -->
    </div>
</div>

<script>
// Generate Report Functionality
    function generateReport() {
        const startDate = document.getElementById('start_date').value;
        const endDate = document.getElementById('end_date').value;

        if (!startDate || !endDate) {
            alert('Please select both start and end dates.');
            return;
        }

        const output = document.getElementById('report-output');
        output.innerHTML = `<h3>Reports from ${startDate} to ${endDate}</h3>`;

        // Fetch data from PHP
        const xhr = new XMLHttpRequest();
        xhr.open("POST", "generate_report.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                output.innerHTML += xhr.responseText;
            }
        };
        xhr.send(`start_date=${startDate}&end_date=${endDate}`);
    }
</script>

