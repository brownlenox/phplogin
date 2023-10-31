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
    <title>Login form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link href="style.css" rel="stylesheet">
</head>
<body>
    <div class="container" >
    <?php
    if (isset($_POST['login'])) {
       $email = $_POST['email'];
       $password = $_POST['password'];
       require_once "database.php";
       $sql = "SELECT * FROM users WHERE email = '$email'";
       $result = mysqli_query($conn, $sql);
       $user = mysqli_fetch_array($result, MYSQLI_ASSOC);
       if ($user) {
        if (password_verify($password, $user['password'])) {
            session_start();
            $_SESSION["user"] = "yes";
            header("Location: index.php");
            die();
        }else {
            echo "<div class='alert alert-danger'>Password does not match</div>";
        }
       } else {
        echo "<div class='alert alert-danger'>Email does not match</div>";
       }
       
    }
    ?>
    <form action="login.php" method="post">
            <div class="form-group">
            <label for="email">E-mail:</label>
                <input type="email" name="email" class="form-control" placeholder="Enter your email">
            </div>
            <div class="form-group">
            <label for="password">Password:</label>
                <input type="password" name="password"class="form-control" placeholder="Password">
            </div>
            <div class="form-btn text-center">
                <input type="submit" value="Login" class="btn btn-primary" name="login">
            </div>
        </form>
        <div><p>Not registered yet <a href="registration.php">Register here</a></P></div>
    </div>
</body>
</html>