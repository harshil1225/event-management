<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            text-align: center;
            background-color: #ADD8E6; /* Light blue background */
        }
        .container {
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap; /* Makes it responsive */
        }
        .member {
            margin: 20px;
            width: 220px; /* Fixed width for member details */
            border: 1px solid #ccc;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 10px;
            transition: transform 0.3s;
            background-color: white; /* White background for member card */
        }
        .member:hover {
            transform: scale(1.05);
        }
        .member img {
            width: 100%;
            border-radius: 10px;
        }
        .details {
            margin-top: 10px;
        }
        .back-button {
            display: inline-block;
            margin: 20px 0;
            padding: 10px 20px;
            font-size: 16px;
            color: white;
            background-color: #007BFF;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .back-button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

    <h1>Our Team</h1>
    <div class="container">
        <div class="member">
            <img src="hasu1.jpg" alt="Member 1">
            <div class="details">
                <h3>Harshil Vasava</h3>
                <p>Qualification: BCA (Bachelor of Computer Applications)</p>
                <p>Skills: HTML, JAVA</p>
            </div>
        </div>
        <div class="member">
            <img src="tirth.jpg" alt="Member 2">
            <div class="details">
                <h3>Tirth Desai</h3>
                <p>Qualification: BCA (Bachelor of Computer Applications)</p>
                <p>Skills: HP, PYTHON</p>
            </div>
        </div>
        <div class="member">
            <img src="dev.jpg" alt="Member 3">
            <div class="details">
                <h3>Dev Bhandari</h3>
                <p>Qualification: BCA (Bachelor of Computer Applications)</p>
                <p>Skills: C++, JAVA</p>
            </div>
        </div>
        <div class="member">
            <img src="tejaswini.jpg" alt="Member 4">
            <div class="details">
                <h3>Borse Tejaswini</h3>
                <p>Qualification: BCA (Bachelor of Computer Applications)</p>
                <p>Skills: PYTHON, HTML</p>
            </div>
        </div>
    </div>

    <a href="home.php" class="back-button">Back to Home</a> <!-- Back to Home Button at the bottom -->

</body>
</html>
