<?php
// check_venue_availability.php

// Get the request body and decode it into a PHP array
$data = json_decode(file_get_contents('php://input'), true);

// Extract the data from the request
$startDate = $data['start_date'];
$endDate = $data['end_date'];
$venue = $data['venue'];

// Database connection
$hostname = "localhost";
$username = "root";
$password = "";
$database = "client";
$con = mysqli_connect($hostname, $username, $password, $database);
if (!$con) {
    die("Error in Connection" . mysqli_error($con));
}

// Query to check if the venue is already booked for the selected date range
$query = "SELECT * FROM book_event WHERE venue = '$venue' AND (
            (start_date <= '$endDate' AND end_date >= '$startDate')
          )";

$result = mysqli_query($con, $query);

// Check if any rows were returned (meaning the venue is already booked)
if (mysqli_num_rows($result) > 0) {
    echo json_encode(['isVenueUnavailable' => true]);
} else {
    echo json_encode(['isVenueUnavailable' => false]);
}
?>
