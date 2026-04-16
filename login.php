<!DOCTYPE html>
<html>
    <head> 
        <style>
            /* Your CSS styles */
            .login {
                width: 340px;
                height: 400px;
                background: #2c2c2c;
                padding: 47px;
                padding-bottom: 57px;
                color: #fff;
                border-radius: 17px;
                padding-bottom: 50px;
                font-size: 1.3em;
                font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
            }

            .login input[type="text"],
            .login input[type="password"] {
                opacity: 1;
                display: block;
                border: none;
                outline: none;
                width: 100%;
                padding: 13px 18px;
                margin: 20px 0 0 0;
                font-size: 0.8em;
                border-radius: 100px;
                background: #3c3c3c;
                color: #fff;
            }

            .login input:focus {
                animation: bounce 1s;
                -webkit-appearance: none;
            }

            .login input[type=submit],
            .login input[type=button],
            .h1 {
                border: 0;
                outline: 0;
                width: 100%;
                padding: 13px;
                margin: 40px 0 0 0;
                border-radius: 500px;
                font-weight: 600;
                animation: bounce2 1.6s;
            }

            .h1 {
                padding: 0;
                position: relative;
                top: -35px;
                display: block;
                margin-bottom: -0px;
                font-size: 1.3em;
            }

            .btn {
                background: linear-gradient(144deg, #af40ff, #5b42f3 50%, #00ddeb);
                color: #fff;
                padding: 16px !important;
            }

            .btn:hover {
                background: linear-gradient(144deg, #1e1e1e , 20%,#1e1e1e 50%,#1e1e1e );
                color: rgb(255, 255, 255);
                padding: 16px !important;
                cursor: pointer;
                transition: all 0.4s ease;
            }

            .login input[type=text] {
                animation: bounce 1s;
                -webkit-appearance: none;
            }

            .login input[type=password] {
                animation: bounce1 1.3s;
            }

            .ui {
                font-weight: bolder;
                background: -webkit-linear-gradient(#B563FF, #535EFC, #0EC8EE);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                border-bottom: 4px solid transparent;
                border-image: linear-gradient(0.25turn, #535EFC, #0EC8EE, #0EC8EE);
                border-image-slice: 1;
                display: inline;
            }

            @media only screen and (max-width: 600px) {
                .login {
                    width: 70%;
                    padding: 3em;
                }
            }

            @keyframes bounce {
                0% {
                    transform: translateY(-250px);
                    opacity: 0;
                }
            }

            @keyframes bounce1 {
                0% {
                    opacity: 0;
                }

                40% {
                    transform: translateY(-100px);
                    opacity: 0;
                }
            }

            @keyframes bounce2 {
                0% {
                    opacity: 0;
                }

                70% {
                    transform: translateY(-20px);
                    opacity: 0;
                }
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
                padding: 5px 15px;
                border: none;
                border-radius: 5px;
                cursor: pointer;
                transition: background-color 0.3s ease;
                margin-top: 10px; /* Adjust the value to move the button down */
            }


            button[type="button"]:hover {
                background-color: #555;
            }

        </style>
    </head>
    <body>
        <div class="backg">
            <center>
                <div class="login wrap">
                    <div class="h1" name="email">Login</div>
                    <form method="post" action="login_process.php">
                        <input placeholder="Email" id="email" name="email" type="text" required>
                        <input placeholder="Password" id="password" name="password" type="password" required>
                        <input value="Login" class="btn" type="submit" name="submit"> <!-- Added name="submit" -->
                    </form>
                    <a href="index.php">
                        <input value="Registration" class="btn" type="submit">
                    </a>

                    <a href="home.php">
                        <button class="logout-button" type="button">Go Back</button>
                    </a>
                </div>


            </center>98
        </div>
        <?php
        ?>          

    </body
