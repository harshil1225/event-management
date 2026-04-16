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

// Fetch organizer details
$organizer_query = "SELECT * FROM organizer";
$organizer_result = mysqli_query($con, $organizer_query);

// Fetch client details
$client_query = "SELECT * FROM client1";
$client_result = mysqli_query($con, $client_query);

// Fetch data from the `payment` table
$sql = "SELECT p_id, c_id, package, p_method, amount, status, date_time FROM payment";
$result = mysqli_query($con, $sql); // Use `$con` instead of `$conn`

if (!$result) {
    die("Error in Query: " . mysqli_error($con));
}
?>

<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Event Management Admin</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
        <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">
        <style>
            body {
                font-family: 'Open Sans', sans-serif;
                margin: 0;
                display: flex;
                background-image: url('c_3.jpg');
                background-size: cover;
                background-position: center;
                color: #333;
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
                background-color: #B22222;
                padding: 10px;
                color: #fff;
                border: none;
                border-radius: 5px;
                cursor: pointer;
                text-align: center;
                transition: background-color 0.3s;
                width: 100%;
            }

            .logout-button:hover {
                background-color: #fff;
                color: #B22222;
            }

            .main-content {
                flex: 1;
                padding: 20px;
                background-color: rgba(255, 255, 255, 0.9);
                height: 100vh;
                overflow-y: auto;
            }

            .section {
                display: none;
                background-color: rgba(0, 0, 0, 0.7);
                padding: 20px;
                border-radius: 10px;
                color: white;
            }

            .section h2 {
                text-align: center;
                margin-bottom: 20px;
            }

            table {
                width: 100%;
                border-collapse: collapse;
                margin-top: 20px;
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
        </style>
    </head>

    <body>
        <div class="sidebar">
            <h1>Admin Panel</h1>
            <a href="#profile" id="profile-link"><i class="fas fa-user"></i> Profile</a>
            <a href="#organizer" id="organizer-link"><i class="fas fa-users"></i> Manage Organizers</a>
            <a href="#clients" id="clients-link"><i class="fas fa-user-friends"></i> Manage Clients</a>
            <a href="#reports" id="reports-link"><i class="fas fa-chart-line"></i> Reports</a>
            <a href="#payment-verification" id="payment-verification-link"><i class="fas fa-money-check-alt"></i> Payment Verification</a>
            <a href="#settings" id="settings-link"><i class="fas fa-cog"></i> Settings</a>
            <button class="logout-button" type="button">Logout</button>

        </div>

        <div class="main-content">
            <div class="section" id="admin-info">
                <h2>Admin Profile</h2>
                <!-- Admin details here -->
                <p><strong>Admin Name:</strong> <?php echo htmlspecialchars($admin['name']); ?></p>
                <p><strong>Admin ID:</strong> <?php echo htmlspecialchars($admin['id']); ?></p>
                <p><strong>Email:</strong> <?php echo htmlspecialchars($admin['email_id']); ?></p>
                <p><strong>Contact:</strong> <?php echo htmlspecialchars($admin['phone_number']); ?></p>
                <p><strong>Gender:</strong> <?php echo htmlspecialchars($admin['gender']); ?></p>
            </div>

            <div class="section" id="organizer-section">
                <h2>Manage Organizers</h2>
                <!-- Organizer details here -->
                <table>
                    <thead>
                        <tr>
                            <th>Organizer ID</th>
                            <th>Name</th>
                            <th>Contact</th>
                            <th>Email</th>
                            <th>Address</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($organizer = mysqli_fetch_assoc($organizer_result)): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($organizer['o_id']); ?></td>
                                <td><?php echo htmlspecialchars($organizer['name']); ?></td>
                                <td><?php echo htmlspecialchars($organizer['concat_no']); ?></td>
                                <td><?php echo htmlspecialchars($organizer['email']); ?></td>
                                <td><?php echo htmlspecialchars($organizer['address']); ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>

            <div class="section" id="client-section">
                <h2>Manage Clients</h2>
                <!-- Client details here -->

                <table>
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Phone Number</th>
                            <th>Birth Date</th>
                            <th>Gender</th>
                            <th>Email</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($client = mysqli_fetch_assoc($client_result)): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($client['name']); ?></td>
                                <td><?php echo htmlspecialchars($client['phone_number']); ?></td>
                                <td><?php echo htmlspecialchars($client['birthday']); ?></td>
                                <td><?php echo htmlspecialchars($client['gender']); ?></td>
                                <td><?php echo htmlspecialchars($client['email']); ?></td>
                                <td><button class="delete-btn" onclick="confirmDelete()">Delete</button></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>

            </div>

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
            <!-- Payment Verification Section -->
            <div id="payment-verification-section" style="display: none;">
                <h2>Payment Verification</h2>
                <p>Manage and verify payments here.</p>
                <table border="1" cellspacing="0" cellpadding="10">
                    <thead>
                        <tr>
                            <th>Payment ID</th>
                            <th>Client ID</th>
                            <th>Package</th>
                            <th>Payment Method</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Date & Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $totalAmount = 0; // Initialize the total amount variable

                        if ($result->num_rows > 0) {
                            // Output data of each row
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $row['p_id'] . "</td>";
                                echo "<td>" . $row['c_id'] . "</td>";
                                echo "<td>" . $row['package'] . "</td>";
                                echo "<td>" . $row['p_method'] . "</td>";
                                echo "<td>" . $row['amount'] . "</td>";
                                echo "<td>" . $row['status'] . "</td>";
                                echo "<td>" . $row['date_time'] . "</td>";
                                echo "</tr>";

                                // Add the current row's amount to the total
                                $totalAmount += $row['amount'];
                            }
                        } else {
                            echo "<tr><td colspan='7'>No payments found.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
                <h3>Total Payment Amount: <?php echo $totalAmount; ?></h3> <!-- Display the total amount -->
            </div>

            <!-- Settings Section -->
            <div id="settings-section" style="display: none;">
                <h2>Settings</h2>
                <p>Configure admin panel settings here.</p>
            </div>

        </div>
        <script>
            // Function to toggle visibility of sections
            function showSection(sectionId) {
                document.querySelectorAll('.main-content > div').forEach(section => {
                    section.style.display = 'none';
                });
                document.getElementById(sectionId).style.display = 'block';
            }

            // Event Listeners for menu links
            document.getElementById('profile-link').addEventListener('click', function (e) {
                e.preventDefault();
                showSection('admin-info');
            });

            document.getElementById('organizer-link').addEventListener('click', function (e) {
                e.preventDefault();
                showSection('organizer-section');
            });

            document.getElementById('clients-link').addEventListener('click', function (e) {
                e.preventDefault();
                showSection('client-section');
            });

            document.getElementById('reports-link')?.addEventListener('click', function (e) {
                e.preventDefault();
                showSection('report-section');
            });

            // Logout button functionality
            document.querySelector('.logout-button').addEventListener('click', () => {
                if (confirm('Are you sure you want to logout?')) {
                    window.location.href = 'login.php';
                }
            });

            // Confirm Delete Function
            function confirmDelete() {
                if (confirm("Are you sure you want to delete this user?")) {
                    alert("On this time you cannot delete data from the database; this is just a placeholder.");
                }
            }

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
                // Placeholder data for demonstration
                output.innerHTML += `
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
                            <tr>
                                <td>1</td>
                                <td>101</td>
                                <td>1234567890</td>
                                <td>Wedding</td>
                                <td>${startDate} 10:00 AM</td>
                            </tr>
                        </tbody>
                    </table>`;
            }

            document.getElementById('payment-verification-link').addEventListener('click', function (e) {
                e.preventDefault();
                showSection('payment-verification-section');
            });

            document.getElementById('settings-link').addEventListener('click', function (e) {
                e.preventDefault();
                showSection('settings-section');
            });

        </script>

    </body>

</html>
