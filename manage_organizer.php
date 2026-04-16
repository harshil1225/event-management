<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Management Admin</title>
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
            max-width: 800px; /* Increased max-width for better table display */
            margin: 20px;
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }

        h1, h2 {
            text-align: center;
            color: #1b3c5d;
        }

        .table-container {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #1b3c5d;
            color: #fff;
        }

        tr:hover {
            background-color: #f5f5f5;
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
    <div class="container">
        <h1>Admin</h1>

        <?php
        session_start();

        // Check if organizer is logged in, if not redirect to login page
        if (!isset($_SESSION['email'])) {
            header("Location: login.php");
            exit();
        }

        // Establish database connection
        $hostname = "localhost";
        $username = "root";
        $password = "";
        $database = "client";

        $con = mysqli_connect($hostname, $username, $password, $database);

        if (!$con) {
            die("Error in Connection: " . mysqli_connect_error());
        }

        // Fetch organizer data based on email from the session
        $email = $_SESSION['email'];
        $admin_query = "SELECT * FROM admin WHERE email_id='$email'";
        $admin_result = mysqli_query($con, $admin_query);
        $row = mysqli_fetch_assoc($admin_result);
        ?>

        <div class="content" id="organizers">
            <h2>Manage Organizers</h2>
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Organizer ID</th>
                            <th>Name</th>
                            <th>Contact Number</th>
                            <th>Email</th>
                            <th>Address</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Retrieve organizer details from the database
                        $organizer_query = "SELECT * FROM organizer";
                        $organizer_result = mysqli_query($con, $organizer_query);

                        // Loop through each organizer and display their details
                        while ($organizer_row = mysqli_fetch_assoc($organizer_result)) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($organizer_row['o_id']) . "</td>";
                            echo "<td>" . htmlspecialchars($organizer_row['name']) . "</td>";
                            echo "<td>" . htmlspecialchars($organizer_row['concat_no']) . "</td>";
                            echo "<td>" . htmlspecialchars($organizer_row['email']) . "</td>";
                            echo "<td>" . htmlspecialchars($organizer_row['address']) . "</td>";
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <?php
    // Close the database connection
    mysqli_close($con);
    ?>
</body>

</html>
