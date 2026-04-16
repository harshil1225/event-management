<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Create or Delete Event</title>
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
                width: 100%;
                max-width: 400px;
                margin: 20px;
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
            input[type="text"], select {
                width: 95%;
                padding: 10px;
                font-size: 16px;
                border: 1px solid #ccc;
                border-radius: 5px;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <h2>Create or Delete Event</h2>

            <!-- Form to add a new event -->
            <form id="eventForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="form-group">
                    <label for="eventName">Event Name:</label>
                    <input type="text" id="eventName" name="eventName" required>
                </div>
                <button type="submit" name="addEvent">Add Event</button>
            </form><br>

            <!-- Form to delete an event -->
            <form id="deleteEventForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="form-group">
                    <label for="deleteEvent">Select Event to Delete:</label>
                    <select id="deleteEvent" name="deleteEvent" required>
                        <option value="">Select Event</option>
                        <?php
                        // Connect to the database
                        $servername = "localhost";
                        $username = "root";
                        $password = "";
                        $dbname = "client";

                        $conn = new mysqli($servername, $username, $password, $dbname);

                        // Check connection
                        if ($conn->connect_error) {
                            die("Connection failed: " . $conn->connect_error);
                        }

                        // Fetch events for the dropdown
                        $eventQuery = "SELECT event_id, event_name FROM event";
                        $eventResult = $conn->query($eventQuery);

                        if ($eventResult->num_rows > 0) {
                            while ($eventRow = $eventResult->fetch_assoc()) {
                                echo "<option value='" . $eventRow['event_id'] . "'>" . $eventRow['event_name'] . "</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
                <button type="submit" name="deleteEventBtn">Delete Event</button>
            </form>

            <?php
            // Prepare and execute SQL query to insert event into the database
            if (isset($_POST['addEvent'])) {
                $eventName = $_POST["eventName"];

                // Check if the event already exists
                $checkEventQuery = "SELECT * FROM event WHERE event_name = '$eventName'";
                $checkEventResult = $conn->query($checkEventQuery);

                if ($checkEventResult->num_rows > 0) {
                    echo "<p class='error-message'>Event already exists. Please add a new event.</p>";
                } else {
                    // Generate event ID in the format "e_101"
                    $eventID = 'e_' . uniqid();
                    $sql = "INSERT INTO event (event_id, event_name) VALUES ('$eventID', '$eventName')";

                    if ($conn->query($sql) === TRUE) {
                        echo "<p class='success-message'>Event added successfully.</p>";
                    } else {
                        echo "Error: " . $sql . "<br>" . $conn->error;
                    }
                }
            }

            // Handle deleting an event
            if (isset($_POST['deleteEventBtn'])) {
                $eventIDToDelete = $_POST['deleteEvent'];

                $deleteEventQuery = "DELETE FROM event WHERE event_id = '$eventIDToDelete'";
                if ($conn->query($deleteEventQuery) === TRUE) {
                    echo "<p class='success-message'>Event deleted successfully.</p>";
                } else {
                    echo "Error deleting event: " . $conn->error;
                }
            }

            // Close database connection
            $conn->close();
            ?>
        </div>
    </body>
</html>
