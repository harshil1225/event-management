<!DOCTYPE html>
<html>
<head>
    <style>
        /* Global reset and basic styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
            background-image: url('wp1837959.webp');
            background-repeat: no-repeat;
            background-size: cover;
            color: #333; /* Text color */
        }
        /* Navigation bar styles */
        .topnav {
            overflow: hidden;
            background-color: rgba(0, 0, 0, 0.7); /* Semi-transparent background */
            padding: 20px 10px; /* Add some padding */
            text-align: center; /* Center align links */
        }
        .topnav a {
            color: #fff; /* Link color */
            text-decoration: none;
            padding: 10px 20px; /* Add padding to links */
            display: inline-block;
            transition: background-color 0.3s; /* Smooth hover transition */
        }
        .topnav a:hover {
            background-color: rgba(255, 255, 255, 0.2); /* Semi-transparent background on hover */
        }
        .topnav a.contact-link {
            float: right; /* Align contact link to the right */
        }
        /* Contact info styles */
        .contact-info {
            display: none;
            position: absolute;
            background-color: rgba(255, 255, 255, 0.9);
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            z-index: 1000;
            right: 10px; /* Adjust contact info position */
            top: calc(100% + 10px); /* Position below contact link */
            width: 200px;
        }
        .contact-info h2 {
            font-size: 16px;
            margin-bottom: 10px;
        }
        /* Main content styles */
        .container {
            text-align: center;
            padding: 50px 0; /* Add vertical padding */
        }
        .centered {
            font-size: 48px;
            color: #fff; /* Text color */
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5); /* Add text shadow */
        }
        /* Description section styles */
        .description {
            text-align: center;
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.7); /* Semi-transparent background */
            max-width: 600px; /* Limit width to improve readability */
            margin: 20px auto; /* Center align and add some margin */
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2); /* Add box shadow */
        }
        .description p {
            font-size: 18px;
            line-height: 1.6; /* Increase line height for better readability */
            margin-bottom: 10px; /* Add some space between paragraphs */
        }
    </style> 
</head>
<body>
    <!-- Navigation bar -->
    <div class="topnav">
        <a class="active" href="#home">Home</a>
       
        <a href="gallery.php">Gallery</a>
        <!-- Modified contact us link -->
       <a href="our team.php">Our Team</a> 
        <a href="contact.php" class="contact-link">Contact us</a>
        <div class="contact-info"> <!-- Contact info container -->
            <h2>Contact Information</h2>
            <p>Email: wow183@gmail.com</p>
            <p>Phone: 9398765456</p>
        </div>
        <a href="login.php" class="split" name="login">Login</a>
    </div>
    
    <!-- Main content -->
    <div class="container">
        <div class="centered">EVENT MANAGEMENT </div>
    </div>
    
    <!-- Description section -->
    <div class="description">
        <p>“EVENT MANAGEMENT ” is a website dedicated to facilitating the planning, organization, execution, and monitoring of various types of events, such as corporate events, wedding events, and birthday events.</p>
    </div>
</body>
</html>
