<!DOCTYPE html>
   <html>
        <head>
            <meta charset="UTF-8">
            <title></title>
            <style>
            .container {
                position: relative;
                max-width: 500px;
                width: 100%;
                background: #15172b;
                ;
                padding: 40px;
                border-radius: 8px;
                box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            }

            .container header {
                font-size: 1.2rem;
                color: #ffffff;
                font-weight: 600;
                text-align: center;
            }

            .container .form {
                margin-top: 15px;
            }

            .form .input-box {
                width: 100%;
                margin-top: 10px;
            }

            .input-box label {
                color: #e0d3d3;
            }

            .form :where(.input-box input, .select-box) {
                position: relative;
                height: 35px;
                width: 100%;
                outline: none;
                font-size: 1rem;
                color: #c7bbbb;
                margin-top: 5px;
                border: 1px solid #af8d88;
                border-radius: 6px;
                padding: 0 15px;
                background: #2c2c2c;
            }

            .input-box input:focus {
                box-shadow: 0 1px 0 rgba(125, 255, 3, 0.1);
            }

            .form .column {
                display: flex;
                column-gap: 15px;
            }

            .form .gender-box {
                margin-top: 10px;
            }

            .form :where(.gender-option, .gender) {
                display: flex;
                align-items: center;
                column-gap: 50px;
                flex-wrap: wrap;
            }

            .form .gender {
                column-gap: 5px;
            }

            .gender input {
                accent-color: #EE4E34;
            }

            .form :where(.gender input, .gender label) {
                cursor: pointer;
            }

            .gender label {
                color: #dbd4d4;
            }

            .email :where(input, .select-box) {
                margin-top: 10px;
            }

            .select-box select {
                height: 100%;
                width: 100%;
                outline: none;
                border: none;
                color: #808080;
                font-size: 1rem;
                background: #2c2c2c;
            }

            .form button {
                background: linear-gradient(144deg, #af40ff, #5b42f3 50%, #00ddeb);
                color: #fff;
                padding: 16px !important;

            }

            .form button:hover {
                background: linear-gradient(144deg, #1e1e1e , 20%,#1e1e1e 50%,#1e1e1e );
                color: rgb(255, 255, 255);
                padding: 16px !important;
                cursor: pointer;
                transition: all 0.4s ease;
            }
            .backg{
                background-image: url('11.jpg');
                height:100vh;
                background-repeat: no-repeat;
                width: 100%;
                background-size: cover;
                background-position: center;
            }
            *{
                margin:0;
                padding:0;
            }

            button[type="button"] {
                background-color: #333;
                color: #fff;
                padding: 10px 20px;
                border: none;
                border-radius: 5px;
                cursor: pointer;
                transition: background-color 0.3s ease;
            }

            button[type="button"]:hover {
                background-color: #555;
            }
            </style>
        </head>
        <body>
        <center>
            <div class="backg">
                <section class="container">
                    <header><h1>Registration Form</h1></header>
                    <form class="form" method="post" action="db_connection.php" onsubmit="return validateForm()">
                        <div class="input-box">
                            <label>Full Name</label>
                            <input required placeholder="Enter full name" type="text" name="name" id="name" oninput="validateFullName(event)">
                            <small id="name-error" style="color: red;"></small>

                        </div>
                        <div class="column">
                            <div class="input-box">
                                <label>Phone Number</label>
                                <input required pattern="[0-9]{10}" placeholder="Enter phone number" type="tel" name="phonenumber" id="phonenumber">
                                <small>Format: 10 digits without spaces or dashes</small>
                            </div>
                            <div class="input-box">
                                <label>Birth Date</label>
                                <input required placeholder="Enter birth date" type="date" name="birthday" id="birthday">
                            </div>
                        </div><br>
                        <div class="gender-box">
                            <div class="gender label">
                                <label>Gender:</label>
                            </div><br>
                            <div class="gender-option">
                                <div class="gender">
                                    <input checked name="gender" id="check-male" type="radio" value="male">
                                    <label for="check-male">Male</label>
                                </div>
                                <div class="gender">
                                    <input name="gender" id="check-female" type="radio" value="female">
                                    <label for="check-female">Female</label>
                                </div>
                                <div class="gender">
                                    <input name="gender" id="check-other" type="radio" value="prefer_not_to_say">
                                    <label for="check-other">Prefer not to say</label>
                                </div>
                            </div>
                        </div><br>
                        <div class="input-box email">
                            <label>E-Mail ID</label>
                            <input required placeholder="abc123@gmail.com" type="email" name="email" id="email">
                        </div>
                        <div class="column">
                            <div class="input-box">
                                <label>Password</label>
                                <input required minlength="8" placeholder="Enter your password" type="password" name="password" id="password">
                                <small>Minimum 8 characters</small>
                            </div>
                        </div><br>
                        <div class="btn">
                            <button type="submit" name="submit">Submit</button>
                        </div>
                    </form><br>
                    <a href="home.php">
                        <button class="logout-button" type="button">Go Back</button>
                    </a>
                </section>
<script>
    function validateForm() {
        // Basic client-side validation
        var name = document.getElementById('name').value.trim();
        var phoneNumber = document.getElementById('phonenumber').value.trim();
        var birthday = document.getElementById('birthday').value;
        var email = document.getElementById('email').value.trim();
        var password = document.getElementById('password').value.trim();

        // Name validation
        if (name === "") {
            alert("Please enter your full name.");
            return false;
        }

        // Phone number validation
        if (!phoneNumber.match(/^\d{10}$/)) {
            alert("Please enter a valid 10-digit phone number.");
            return false;
        }

        // Email validation
        if (!/\S+@\S+\.\S+/.test(email)) {
            alert("Please enter a valid email address.");
            return false;
        }

        // Password validation
        if (password.length < 8) {
            alert("Password must be at least 8 characters long.");
            return false;
        }

        // Birthdate validation
        var birthDate = new Date(birthday);
        var today = new Date();
        var age = today.getFullYear() - birthDate.getFullYear();
        var monthDifference = today.getMonth() - birthDate.getMonth();

        // Check if the birth date is in the future or the user is less than a minimum age (e.g., 0 or 120)
        if (birthDate > today) {
            alert("Birth date cannot be in the future.");
            return false;
        }
        
        // Minimum age (e.g., 18 years)
        if (age < 18) {
            alert("You must be at least 18 years old.");
            return false;
        }
        
        // Maximum age (e.g., 120 years)
        if (age > 120) {
            alert("Please enter a realistic birth date.");
            return false;
        }

        // All validations passed
        return true;
    }

    function validateFullName(event) {
        const input = event.target.value;
        const regex = /^[a-zA-Z\s]*$/; // Regular expression to match only alphabetic characters and spaces

        if (!regex.test(input)) {
            document.getElementById('name-error').textContent = "Please enter name in proper format.";
            document.getElementById('name').setCustomValidity("Please enter name in proper format.");
        } else {
            document.getElementById('name-error').textContent = "";
            document.getElementById('name').setCustomValidity(""); // Reset custom validity
        }
    }
</script>
            </div>
        </center>
        <?php
        ?>

    </body>
</html>


