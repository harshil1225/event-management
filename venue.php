<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Add or Delete Venue</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                margin: 0;
                padding: 0;
                background-image: url('c_3.jpg'); /* Set the background image */
                background-size: cover;
                background-position: center;
                color: #333; /* Set text color to ensure visibility on dark background */
                display: flex;
                justify-content: center; /* Center the content horizontally */
                align-items: center; /* Center the content vertically */
                height: 100vh; /* Full viewport height */
            }

            .container {
                width: 100%; /* Take full width */
                max-width: 400px; /* Set max width to control size */
                margin: 20px; /* Add margin to avoid touching the screen edges */
                padding: 20px;
                background-color: rgba(255, 255, 255, 0.9); /* Slightly transparent background */
                border-radius: 10px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.2); /* Slightly larger shadow */
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
                width: 100%; /* Ensures the text box takes the full width of its parent container */
                max-width: 375px; /* Sets a maximum width for the text box */
                padding: 10px;
                font-size: 16px;
                border: 1px solid #ccc;
                border-radius: 5px;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <h2>Add or Delete Venue</h2>
            
            <!-- Form to add a new venue -->
            <form id="venueForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="form-group">
                    <label for="venueName">Venue Name:</label>
                    <input type="text" id="venueName" name="venueName" required>
                </div>
                <button type="submit" name="addVenue">Add Venue</button>
            </form>

            <!-- Form to delete an existing venue -->
            <form id="deleteVenueForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="form-group"><br>
                    <label for="deleteVenue">Select Venue to Delete:</label>
                    <select id="deleteVenue" name="deleteVenue" required>
                        <option value="">Select Venue</option>
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

                        // Fetch venues for the dropdown
                        $venueQuery = "SELECT venue_id, venue_name FROM venue";
                        $venueResult = $conn->query($venueQuery);

                        if ($venueResult->num_rows > 0) {
                            while ($venueRow = $venueResult->fetch_assoc()) {
                                echo "<option value='" . $venueRow['venue_id'] . "'>" . $venueRow['venue_name'] . "</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
                <button type="submit" name="deleteVenueBtn">Delete Venue</button>
            </form>

            <?php
            // Prepare and execute SQL query to insert venue into the database
            if (isset($_POST['addVenue'])) {
                $venueName = $_POST["venueName"];

                // Check if the venue already exists
                $checkVenueQuery = "SELECT * FROM venue WHERE venue_name = '$venueName'";
                $checkVenueResult = $conn->query($checkVenueQuery);

                if ($checkVenueResult->num_rows > 0) {
                    echo "<p class='error-message'>Venue already exists. Please enter a different name.</p>";
                } else {
                    // Generate venue ID
                    $venueID = 'v_' . uniqid();

                    // Prepare SQL statement
                    $stmt = $conn->prepare("INSERT INTO venue (venue_id, venue_name) VALUES (?, ?)");
                    $stmt->bind_param("ss", $venueID, $venueName);

                    // Execute the statement
                    if ($stmt->execute()) {
                        echo "<p class='success-message'>Venue added successfully.</p>";
                    } else {
                        echo "<p class='error-message'>Error: " . $conn->error . "</p>";
                    }

                    // Close statement
                    $stmt->close();
                }
            }

            // Handle deleting a venue
            if (isset($_POST['deleteVenueBtn'])) {
                $venueIDToDelete = $_POST['deleteVenue'];

                $deleteVenueQuery = "DELETE FROM venue WHERE venue_id = '$venueIDToDelete'";
                if ($conn->query($deleteVenueQuery) === TRUE) {
                    echo "<p class='success-message'>Venue deleted successfully.</p>";
                } else {
                    echo "<p class='error-message'>Error deleting venue: " . $conn->error . "</p>";
                }
            }

            // Close database connection
            $conn->close();
            ?>
        </div>
    </body>
</html>
