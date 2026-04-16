<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>

        <?php
        $hostname = "localhost";
        $username = "root";
        $password = "";
        $database = "client";

        $con = mysqli_connect($hostname, $username, $password, $database);

        if (!$con) {
            die("Error in Connection" . mysqli_error($con));
        }

        if (isset($_POST['submit'])) {
            $name = $_POST['name'];
            $phone_number = $_POST['phonenumber'];
            $birthday = $_POST['birthday'];
            $gender = $_POST['gender'];
            $email = $_POST['email'];
            $password = $_POST['password'];

            // Generate a unique c_id
            $c_id = generateCID();

            $sql = "INSERT INTO client1 (c_id, name, phone_number, birthday, gender, email, password) VALUES ('$c_id', '$name', '$phone_number', '$birthday', '$gender', '$email', '$password')";

            if (mysqli_query($con, $sql)) {
                echo "<script>alert('Data stored in database, Now you can login.'); window.location='login.php';</script>";
            } else {
                echo "Error: " . mysqli_error($con);
            }
            mysqli_close($con);
        }

// Function to generate a unique c_id
        function generateCID() {
            $prefix = 'c_';
            $random_number = mt_rand(100, 999); // Generate a random 3-digit number
            $c_id = $prefix . $random_number;
            return $c_id;
        }
        ?>

    </body>
</html>
