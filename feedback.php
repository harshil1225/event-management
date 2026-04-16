<?php
session_start();

// Check if user is logged in, if not redirect to login page
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "client";
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the user is logged in
if (!isset($_SESSION['email'])) {
    header("Location: login.php"); // Redirect to login if not logged in
    exit();
}

// Fetch client ID (c_id) based on logged-in email
$email = $_SESSION['email'];
$client_query = "SELECT c_id FROM client1 WHERE email = '$email'";
$client_result = $conn->query($client_query);
if ($client_result->num_rows > 0) {
    $client_row = $client_result->fetch_assoc();
    $c_id = $client_row['c_id'];
} else {
    die("Client not found.");
}

// Insert data into the feedback table after form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $feedback = $_POST["message"];

    // Prepare the SQL statement to prevent SQL injection
    $stmt = $conn->prepare("INSERT INTO feedback (c_id, feedback, date_time) VALUES (?, ?, NOW())");
    $stmt->bind_param("is", $c_id, $feedback);

    if ($stmt->execute()) {
        $feedbackSubmitted = true; // Indicate that the feedback was submitted successfully
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f2f2f2;
            background-image: url('11.jpg'); /* Set background image here */
            background-repeat: no-repeat;
            background-size: cover;
        }
        .container {
            max-width: 500px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 5px;
        }
        textarea {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
            height: 100px;
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
        }
        button:hover {
            background-color: #0056b3;
        }
        .message {
            text-align: center;
            margin-top: 10px;
            color: red;
        }
        .success {
            color: green;
        }
    </style>
</head>
<body>
    <div class="container">
    <h2>Feedback Form</h2>
    <form id="feedbackForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" onsubmit="return validateForm()">
        <div class="form-group">
            <label for="message">Your Feedback:</label>
            <textarea id="message" name="message" required></textarea>
        </div>
        <button type="submit">Submit Feedback</button>
    </form>
    <div id="successMessage" class="message" style="display: none;">Thank you for your feedback!</div>

    <!-- Success message after feedback submission -->
    <?php
    if (isset($feedbackSubmitted) && $feedbackSubmitted === true) {
        echo "<div class='message success'>Thank you for your feedback!</div>";
    }
    ?>

    <!-- Back button -->
    <a href="client.php" class="back-btn" style="display: block; text-align: center; margin-top: 20px; font-size: 16px; color: #007bff; text-decoration: none;">
        <i class="fas fa-arrow-left"></i> Back to Client Dashboard
    </a>
</div>

    <script>
        function validateForm() {
            var message = document.getElementById("message").value;
            var successMessage = document.getElementById("successMessage");

            if (message.trim() == "") {
                alert("Please enter your feedback.");
                return false;
            }

            successMessage.style.display = "block";
            successMessage.style.color = "green"; // Set success message color to green
            setTimeout(function () {
                successMessage.style.display = "none"; // Hide the message after 10 seconds
            }, 10000);

            return true;
        }
    </script>
</body>
</html>
