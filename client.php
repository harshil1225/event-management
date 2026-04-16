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
    die("Error in Connection" . mysqli_error($con));
}

// Fetch client data based on email
$email = $_SESSION['email'];
$client_query = "SELECT * FROM client1 WHERE email='$email'";
$client_result = mysqli_query($con, $client_query);
if (!$client_result) {
    die("Error in fetching data: " . mysqli_error($con));
}
$row = mysqli_fetch_assoc($client_result);

// Fetch events and venues
$event_query = "SELECT * FROM event";
$event_result = mysqli_query($con, $event_query);
$events = array();
while ($event_row = mysqli_fetch_assoc($event_result)) {
    $events[] = $event_row['event_name'];
}
$venuesQuery = "SELECT * FROM venue";
$venuesResult = mysqli_query($con, $venuesQuery);
$venues = array();
while ($venue_row = mysqli_fetch_assoc($venuesResult)) {
    $venues[] = $venue_row['venue_name'];
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Client Dashboard</title>
        <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
        <style>
            body {
                font-family: 'Open Sans', sans-serif;
                margin: 0;
                padding: 0;
                background-image: url('dashbord.jpg');
                background-size: cover;
                background-position: center;
                background-repeat: no-repeat;
                color: #333;
                display: flex;
            }

            .sidebar {
                width: 250px;
                background-color: rgba(44, 62, 80, 0.9);
                padding: 15px;
                box-shadow: 2px 0 5px rgba(0, 0, 0, 0.2);
                height: 100vh;
                position: fixed;
                top: 0;
                left: 0;
                transition: width 0.3s ease;
            }

            .sidebar h1 {
                color: #007bff;
                text-align: center;
                margin-bottom: 30px;
            }

            .sidebar a {
                display: flex;
                align-items: center;
                color: #ecf0f1;
                text-decoration: none;
                padding: 10px;
                border-radius: 4px;
                margin: 5px 0;
                transition: background 0.3s;
            }

            .sidebar a:hover {
                background-color: #34495e;
            }

            .sidebar a i {
                margin-right: 10px;
            }

            .header {
                background-color: #2c3e50;
                color: white;
                text-align: center;
                padding: 10px 0;
                width: calc(100% - 250px);
                margin-left: 250px;
                position: fixed;
                top: 0;
                left: 0;
                z-index: 1;
            }

            .content {
                margin-left: 260px;
                padding: 60px 20px 20px; /* Adjust padding to make space for header */
                flex: 1;
                display: flex;
                flex-direction: column;
                align-items: center; /* Center content horizontally */
            }

            .form-container {
                width: 100%;
                max-width: 800px;
                background: rgba(241, 225, 241, 0.9);
                padding: 25px;
                border-radius: 8px;
                box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
                margin-top: 20px;
                text-align: center; /* Center text in the container */
            }

            .form-group {
                margin-bottom: 15px;
                text-align: left; /* Align labels to the left */
            }

            input[type="text"],
            input[type="email"],
            input[type="tel"],
            input[type="date"],
            select,
            textarea {
                width: 100%;
                padding: 10px;
                margin-top: 5px;
                border-radius: 5px;
                border: 1px solid #ccc;
                box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            }

            button {
                background: linear-gradient(144deg, #af40ff, #5b42f3);
                color: white;
                padding: 10px 20px;
                border: none;
                border-radius: 5px;
                cursor: pointer;
                font-size: 16px;
                transition: background 0.3s;
            }

            button:hover {
                background: #4caf50;
            }


            @media (max-width: 768px) {
                .sidebar {
                    width: 100%;
                    height: auto;
                    position: relative;
                }
                .content {
                    margin-left: 0;
                }
                .header {
                    margin-left: 0;
                    width: 100%;
                }
            }
        </style>
    </head>
    <body>
        <div class="header">
            <h1>Client Dashboard</h1>
        </div>
        <div class="sidebar">
            <a href="#profile"><i class="fas fa-user"></i>Profile</a>
            <a href="#book-event"><i class="fas fa-calendar-alt"></i>Book Event</a>
            <a href="#history"><i class="fas fa-history"></i>History</a>
             <a href="feedback.php"><i class="fas fa-comments"></i>Feedback</a>
            <a href="#setting"><i class="fas fa-cog"></i>Setting</a>
            <a href="javascript:void(0)" onclick="confirmLogout()" class="logout-btn"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </div>

        <div class="content" id="profile">
            <div class="form-container">
                <h2>Profile</h2>
                <table style="width: 100%; text-align: left;">
                    <tr>
                        <td><strong>Name:</strong></td>
                        <td><?php echo $row['name']; ?></td>
                    </tr>
                    <tr>
                        <td><strong>Email:</strong></td>
                        <td><?php echo $row['email']; ?></td>
                    </tr>
                    <tr>
                        <td><strong>Phone Number:</strong></td>
                        <td><?php echo $row['phone_number']; ?></td>
                    </tr>
                    <tr>
                        <td><strong>Birthday:</strong></td>
                        <td><?php echo $row['birthday']; ?></td>
                    </tr>
                    <tr>
                        <td><strong>Gender:</strong></td>
                        <td><?php echo $row['gender']; ?></td>
                    </tr>
                </table>
            </div>

        </div>

        <div class="content" id="book-event" style="display: none;">
            <div class="form-container">
                <h1>Event Booking Form</h1>
                <form action="payment.php" method="post" onsubmit="return validateForm()">
                    <div class="form-group">
                        <label for="name">Name:</label>
                        <input type="text" id="name" name="name" value="<?php echo $row['name']; ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" value="<?php echo $row['email']; ?>" readonly>
                    </div>

                    <div class="form-group">
                        <label for="phone">Phone Number:</label>
                        <input type="tel" id="phone" name="phone" pattern="[689][0-9]{9}" value="<?php echo $row['phone_number']; ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="event">Select Event Type:</label>
                        <select id="event" name="event" required>
                            <?php foreach ($events as $event): ?>
                                <option value="<?php echo $event; ?>"><?php echo $event; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="guests">Number of Guests (more than 100):</label>
                        <input type="number" id="guests" name="guests" min="100" max="10000" required>
                        <small>Please enter a number more than 100.</small>
                    </div>

                    <div class="form-group">
                        <label for="start_date">Start Date:</label>
                        <input type="date" id="start_date" name="start_date" required min="<?php echo date('Y-m-d'); ?>" onchange="updateVenueOptions()">
                    </div>

                    <div class="form-group">
                        <label for="end_date">End Date:</label>
                        <input type="date" id="end_date" name="end_date" required min="<?php echo date('Y-m-d'); ?>" onchange="updateVenueOptions()">
                    </div>

                    <div class="form-group">
                        <label for="venue">Select Venue:</label>
                        <select id="venue" name="venue" required>
                            <option value="">Select a Venue</option>
                            <?php foreach ($venues as $venue): ?>
                                <option value="<?php echo $venue; ?>"><?php echo $venue; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="message">Message:</label>
                        <textarea id="message" name="comments" rows="4"></textarea>
                    </div>

                    <button type="submit">Book Event</button>
                </form>
            </div>
        </div>

        <script>
            // This function checks if the selected venue is available for the specified date range.
            function updateVenueOptions() {
                const startDate = document.getElementById('start_date').value;
                const endDate = document.getElementById('end_date').value;
                const selectedVenue = document.getElementById('venue').value;

                // If the user has selected a start date, end date, and venue
                if (startDate && endDate && selectedVenue) {
                    fetch('check_venue_availability.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({start_date: startDate, end_date: endDate, venue: selectedVenue})
                    })
                            .then(response => response.json())
                            .then(data => {
                                // If the venue is unavailable, alert and clear the venue selection.
                                if (data.isVenueUnavailable) {
                                    alert("The selected venue is already booked for the selected date range. Please choose a different venue to proceed.");
                                    document.getElementById('venue').value = ''; // Clear the selected venue
                                    return false; // Prevent form submission or action
                                }
                            })
                            .catch(error => console.error('Error:', error));
                }
            }

            // Trigger the venue check on form submission
            function validateForm() {
                const startDate = document.getElementById('start_date').value;
                const endDate = document.getElementById('end_date').value;
                const selectedVenue = document.getElementById('venue').value;

                // If the user has selected start date, end date, and venue, we check availability
                if (startDate && endDate && selectedVenue) {
                    return fetch('check_venue_availability.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({start_date: startDate, end_date: endDate, venue: selectedVenue})
                    })
                            .then(response => response.json())
                            .then(data => {
                                // If the venue is unavailable, alert and prevent form submission
                                if (data.isVenueUnavailable) {
                                    alert("The selected venue is already booked for this date range. Please choose another venue to continue.");
                                    return false; // Prevent form submission
                                }

                                // If the venue is available, proceed to the payment page
                                window.location.href = 'payment.php'; // Proceed to the payment page
                                return true;
                            })
                            .catch(error => console.error('Error:', error));
                } else {
                    alert("Please select a valid venue and date range before proceeding.");
                    return false; // Prevent form submission if no start date, end date, or venue is selected
                }
            }
        </script>

    </div>
    <div class="content" id="history" style="display: none;">
        <div class="form-container">
            <h2>Booking History</h2>
            <table id="historyTable" border="1" style="width: 100%; border-collapse: collapse; text-align: left;">
                <thead>
                    <tr>
                        <th>Event ID</th>
                        <th>Event Type</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Venue</th>
                        <th>No. of Guests</th>
                        <th>Additional Comments</th>
                        <th>Booking Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Fetch booking history for the logged-in user
                    $email = $_SESSION['email']; // Get the logged-in user's email from the session
                    $query = "SELECT * FROM book_event WHERE email = '$email' ORDER BY date_time DESC";
                    $result = mysqli_query($con, $query);

                    if (!$result) {
                        echo "<tr><td colspan='8'>Error fetching booking history: " . mysqli_error($con) . "</td></tr>";
                    } elseif (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>
                    <td>{$row['event_id']}</td>
                    <td>{$row['event_type']}</td>
                    <td>{$row['start_date']}</td>
                    <td>{$row['end_date']}</td>
                    <td>{$row['venue']}</td>
                    <td>{$row['no_of_guest']}</td>
                    <td>{$row['additional_comments']}</td>
                    <td>{$row['date_time']}</td>
                </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='8'>No booking history found for your account.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>

            <div class="content" id="setting" style="display: none;">
                <div class="form-container">
                    <h2>Settings</h2>
                    <!-- Future implementation for settings -->
                </div>
            </div>


            <script>



                document.querySelectorAll('.sidebar a').forEach(link => {
                    link.addEventListener('click', function (event) {
                        if (this.getAttribute('href').startsWith("#")) {
                            event.preventDefault();
                            document.querySelectorAll('.content').forEach(content => content.style.display = 'none');
                            const targetId = this.getAttribute('href').substring(1);
                            document.getElementById(targetId).style.display = 'block';
                        }
                    });
                });

                // Show the profile section by default
                document.getElementById('profile').style.display = 'block';

            </script>
            <script>
                function confirmLogout() {
                    if (confirm("Are you sure you want to log out?")) {
                        // Logout logic (clear session or session_destroy if necessary)
                        window.location.href = "login.php"; // Redirect to the login page
                    }
                }
            </script>

            </body>
            </html>