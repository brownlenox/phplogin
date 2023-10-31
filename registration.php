<?php
session_start();
if(isset($_SESSION["user"])) {
    header("Loaction: index.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link href="style.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <?php
        if (isset($_POST['submit'])) {
            $fullname = $_POST['fullname'];
            $email = $_POST['email'];
            $pass1 = $_POST['password'];
            $pass2 = $_POST['confirm_password'];

            $passwordHash = password_hash($pass1, PASSWORD_DEFAULT);

            $errors = array();

            

            if (empty($fullname) OR empty($email) OR empty($pass1) OR empty($pass2)) {
                array_push($errors,"All fields are required!");
            }
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                array_push($errors,"Emai is not valid");
            }
            if (strlen($pass1)<8) {;
                array_push($errors, "Password must be at least 8 characters");
            }
            if ($pass1!==$pass2) {
                array_push($errors, "Password does not match");
            }


            require_once "database.php";
            $sql = "SELECT *  FROM users WHERE email = '$email'";
            $result = mysqli_query($conn, $sql);
            $rowCount = mysqli_num_rows($result);
            if ($rowCount>0) {
                array_push($errors, "Email already exists");
            }

            if (count($errors)>0) {
                foreach ($errors as $error) {
                    echo "<div class='alert alert-danger'>$error</div>";
                }
            }else {
                // insert the data in to the database

                
                $sql = "INSERT INTO users(fullname, email, password) VALUES( ?, ?, ? )";
                $stmt = mysqli_stmt_init($conn);
                $preparestmt = mysqli_stmt_prepare($stmt, $sql);
                if ($preparestmt) {
                    mysqli_stmt_bind_param($stmt,"sss",$fullname,$email,$passwordHash);
                    mysqli_stmt_execute($stmt);
                    echo "<div class='alert alert-success'>You are registered succesfully.</div>";
                }else {
                    die("Something went wrong!");
                }
            }
        }
        
        ?>
        <form action="registration.php" method="post">
            <div class="form-group">
                <label for="fullname">Fullname:</label>
                <input type="text" name="fullname" class="form-control" placeholder="Enter your full name">
            </div>
            <div class="form-group">
            <label for="email">E-mail:</label>
                <input type="email" name="email" class="form-control" placeholder="Enter your email">
            </div>
            <div class="form-group">
            <label for="password">Password:</label>
                <input type="password" name="password"class="form-control" placeholder="Password">
            </div>
            <div class="form-group">
            <label for="password">Confirm password:</label>
                <input type="password" name="confirm_password" class="form-control" placeholder="Confirm password">
            </div>
            <div class="form-btn text-center">
                <input type="submit" value="Register" class="btn btn-primary" name=submit>
            </div>
        </form>
        <div><p>Already have an account <a href="login.php">Login here</a></P></div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    
</body>
</html>