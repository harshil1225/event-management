<?php
session_start();

// Check if organizer is logged in, if not redirect to login page
if (!isset($_SESSION['email'])) {
    // Redirect to login page if not logged in
    header("Location: login.php");
    exit();
}

// Fetch organizer data based on email from the session
$hostname = "localhost";
$username = "root";
$password = "";
$database = "client";

$con = mysqli_connect($hostname, $username, $password, $database);

if (!$con) {
    die("Error in Connection" . mysqli_error($con));
}

$email = $_SESSION['email'];
$organizer_query = "SELECT * FROM organizer WHERE email='$email'";
$organizer_result = mysqli_query($con, $organizer_query);
$row = mysqli_fetch_assoc($organizer_result);

// Handle adding a venue
if (isset($_POST['addVenue'])) {
    $venueName = $_POST["venueName"];
    $checkVenueQuery = "SELECT * FROM venue WHERE venue_name = '$venueName'";
    $checkVenueResult = mysqli_query($con, $checkVenueQuery);

    if (mysqli_num_rows($checkVenueResult) > 0) {
        $errorMessage = "Venue already exists. Please enter a different name.";
    } else {
        $venueID = 'v_' . uniqid();
        $sql = "INSERT INTO venue (venue_id, venue_name) VALUES ('$venueID', '$venueName')";

        if (mysqli_query($con, $sql)) {
            $successMessage = "Venue added successfully.";
        } else {
            $errorMessage = "Error: " . $sql . "<br>" . mysqli_error($con);
        }
    }
}

// Handle deleting a venue
if (isset($_POST['deleteVenueBtn'])) {
    $venueIDToDelete = $_POST['deleteVenue'];
    $deleteVenueQuery = "DELETE FROM venue WHERE venue_id = '$venueIDToDelete'";

    if (mysqli_query($con, $deleteVenueQuery)) {
        $successMessage = "Venue deleted successfully.";
    } else {
        $errorMessage = "Error deleting venue: " . mysqli_error($con);
    }
}

// Handle adding an event
if (isset($_POST['addEvent'])) {
    $eventName = $_POST['eventName'];
    $checkEventQuery = "SELECT * FROM event WHERE event_name = '$eventName'";
    $checkEventResult = mysqli_query($con, $checkEventQuery);

    if (mysqli_num_rows($checkEventResult) > 0) {
        $errorMessage = "Event already exists. Please enter a different name.";
    } else {
        $eventID = 'e_' . uniqid();
        $sql = "INSERT INTO event (event_id, event_name) VALUES ('$eventID', '$eventName')";

        if (mysqli_query($con, $sql)) {
            $successMessage = "Event added successfully.";
        } else {
            $errorMessage = "Error: " . $sql . "<br>" . mysqli_error($con);
        }
    }
}

// Handle deleting an event
if (isset($_POST['deleteEventBtn'])) {
    $eventIDToDelete = $_POST['deleteEvent'];
    $deleteEventQuery = "DELETE FROM event WHERE event_id = '$eventIDToDelete'";

    if (mysqli_query($con, $deleteEventQuery)) {
        $successMessage = "Event deleted successfully.";
    } else {
        $errorMessage = "Error deleting event: " . mysqli_error($con);
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Organizer Panel</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Your CSS styles here */
         body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-image: url('c_3.jpg');
            background-size: cover;
            background-position: center;
            color: #333;
            display: flex;
        }

        .sidebar {
            width: 250px;
            background-color: rgba(0, 0, 0, 0.8);
            padding: 20px;
            color: white;
            height: 100vh;
        }

        .sidebar h1 {
            text-align: center;
            color: #007bff;
            margin-bottom: 30px;
        }

        .sidebar a {
            display: block;
            text-decoration: none;
            color: #fff;
            padding: 15px;
            margin: 10px 0;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .sidebar a:hover {
            background-color: #0056b3;
        }

         .logout-button {
            background-color: #ff4d4d;
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 5px;
        }
        .logout-button:hover {
            background-color: #ff3333;
        }

        .main-content {
            flex: 1;
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.9);
            height: 100vh;
            overflow-y: auto;
        }

        .profile-info {
            background-color: rgba(0, 0, 0, 0.7);
            padding: 20px;
            border-radius: 10px;
            color: white;
        }

        .info-item {
            margin-bottom: 15px;
        }

        .info-item label {
            font-weight: bold;
        }

        .container {
            width: 100%;
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 24px;
            color: #007bff;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        input[type="text"], select {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button {
            display: block;
            width: 100%;
            padding: 10px;
            font-size: 16px;
            color: #fff;
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #0056b3;
        }

        .success-message {
            color: green;
            text-align: center;
        }

        .error-message {
            color: red;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <h1>Organizer</h1>
        <a href="#" id="profile-link"><i class="fas fa-user"></i> Profile</a>
        <a href="#" id="events-link"><i class="fas fa-calendar"></i> Manage Events</a>
        <a href="#" id="venue-link"><i class="fas fa-map-marker-alt"></i> Manage Venue</a>
        <a href="#" id="catering-link"><i class="fas fa-utensils"></i> Manage Catering</a>
        <a href="#" id="themes-link"><i class="fas fa-paint-roller"></i> Manage Themes</a>
       <button class="logout-button" id="logout-button" type="button">Logout</button>
    </div>

    <div class="main-content">
        <!-- Profile Section -->
        <div class="profile-info" id="profile-section">
            <h2>Profile</h2>
            <div class="info-item">
                <label>Organizer Name:</label>
                <p><?php echo $row['name']; ?></p>
            </div>
            <div class="info-item">
                <label>Email:</label>
                <p><?php echo $row['email']; ?></p>
            </div>
            <div class="info-item">
                <label>Contact Number:</label>
                <p><?php echo $row['concat_no']; ?></p>
            </div>
            <div class="info-item">
                <label>Address:</label>
                <p><?php echo $row['address']; ?></p>
            </div>
        </div>

        <!-- Manage Events Section -->
        <div class="container" id="events-container" style="display: none;">
            <h2>Create or Delete Event</h2>
            <?php if (isset($successMessage)) { echo "<p class='success-message'>$successMessage</p>"; } ?>
            <?php if (isset($errorMessage)) { echo "<p class='error-message'>$errorMessage</p>"; } ?>

            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="form-group">
                    <label for="eventName">Event Name:</label>
                    <input type="text" id="eventName" name="eventName" required>
                </div>
                <button type="submit" name="addEvent">Add Event</button>
            </form><br>

            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="form-group">
                    <label for="deleteEvent">Select Event to Delete:</label>
                    <select id="deleteEvent" name="deleteEvent" required>
                        <option value="">Select Event</option>
                        <?php
                        // Fetch events for the dropdown
                        $eventQuery = "SELECT event_id, event_name FROM event";
                        $eventResult = mysqli_query($con, $eventQuery);
                        if ($eventResult->num_rows > 0) {
                            while ($eventRow = mysqli_fetch_assoc($eventResult)) {
                                echo "<option value='" . $eventRow['event_id'] . "'>" . $eventRow['event_name'] . "</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
                <button type="submit" name="deleteEventBtn">Delete Event</button>
            </form>
        </div>

        <!-- Manage Venue Section -->
        <div class="container" id="venue-container" style="display: none;">
            <h2>Add or Delete Venue</h2>
            <?php if (isset($successMessage)) { echo "<p class='success-message'>$successMessage</p>"; } ?>
            <?php if (isset($errorMessage)) { echo "<p class='error-message'>$errorMessage</p>"; } ?>

            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="form-group">
                    <label for="venueName">Venue Name:</label>
                    <input type="text" id="venueName" name="venueName" required>
                </div>
                <button type="submit" name="addVenue">Add Venue</button>
            </form><br>

            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="form-group">
                    <label for="deleteVenue">Select Venue to Delete:</label>
                    <select id="deleteVenue" name="deleteVenue" required>
                        <option value="">Select Venue</option>
                        <?php
                        // Fetch venues for the dropdown
                        $venueQuery = "SELECT venue_id, venue_name FROM venue";
                        $venueResult = mysqli_query($con, $venueQuery);
                        if ($venueResult->num_rows > 0) {
                            while ($venueRow = mysqli_fetch_assoc($venueResult)) {
                                echo "<option value='" . $venueRow['venue_id'] . "'>" . $venueRow['venue_name'] . "</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
                <button type="submit" name="deleteVenueBtn">Delete Venue</button>
            </form>
        </div>
    </div>

    <script>
        // JavaScript for showing different sections
        document.querySelector('#events-link').addEventListener('click', () => {
            document.getElementById('profile-section').style.display = 'none';
            document.getElementById('events-container').style.display = 'block';
            document.getElementById('venue-container').style.display = 'none';
        });

        document.querySelector('#venue-link').addEventListener('click', () => {
            document.getElementById('profile-section').style.display = 'none';
            document.getElementById('events-container').style.display = 'none';
            document.getElementById('venue-container').style.display = 'block';
        });
        
        document.getElementById('profile-link').addEventListener('click', function() {
            showProfile(); // Show the profile data when clicking the profile link
        });

        document.getElementById('events-link').addEventListener('click', function() {
            showManageEvents(); // Show the manage events section
        });

        document.getElementById('venue-link').addEventListener('click', function() {
            showManageVenue(); // Show the manage venue section
        });

        function showProfile() {
            document.getElementById('profile-section').style.display = 'block';
            document.getElementById('events-container').style.display = 'none';
            document.getElementById('venue-container').style.display = 'none';
        }

        function showManageEvents() {
            document.getElementById('profile-section').style.display = 'none';
            document.getElementById('events-container').style.display = 'block';
            document.getElementById('venue-container').style.display = 'none';
        }

        function showManageVenue() {
            document.getElementById('profile-section').style.display = 'none';
            document.getElementById('events-container').style.display = 'none';
            document.getElementById('venue-container').style.display = 'block';
        }
        
         document.getElementById("logout-button").addEventListener("click", function() {
            const confirmLogout = confirm("Are you sure you want to logout?");
            if (confirmLogout) {
                window.location.href = "login.php";
            }
        });
    </script>
</body>
</html>
