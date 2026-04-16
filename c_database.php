<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Data</title>
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
    <h2>User Data</h2>

    <?php
    $hostname = "localhost";
    $username = "root";
    $password = "";
    $database = "client";

    $con = mysqli_connect($hostname, $username, $password, $database);

    if (!$con) {
        die("Error in Connection: " . mysqli_connect_error());
    }

    $sql = "SELECT * FROM client1";
    $result = mysqli_query($con, $sql);

    if (mysqli_num_rows($result) > 0) {
        echo "<table>";
        echo "<tr><th>Name</th><th>Phone Number</th><th>Birth Date</th><th>Gender</th><th>Email</th><th>Action</th></tr>";
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($row['name']) . "</td>";
            echo "<td>" . htmlspecialchars($row['phone_number']) . "</td>";
            echo "<td>" . htmlspecialchars($row['birthday']) . "</td>";
            echo "<td>" . htmlspecialchars($row['gender']) . "</td>";
            echo "<td>" . htmlspecialchars($row['email']) . "</td>";
            echo "<td><button class='delete-btn' onclick='confirmDelete()'>Delete</button></td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "No data found";
    }

    mysqli_close($con);
    ?>

    <script>
        function confirmDelete() {
            if (confirm("Are you sure you want to delete this user?")) {
                alert("On this time you can not delete data from database only option is here");
            }
        }
    </script>
</div>

</body>
</html>
