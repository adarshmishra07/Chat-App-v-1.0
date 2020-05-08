<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Messenger</title>
    <meta name="author" content="Adarsh">
    <meta name="description" content="Example description">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" type="image/x-icon" href="" />
</head>
<?php
include 'db/config.php';
$php_errormsg="";
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $useremail = $_POST['email'];
    $passw= $_POST['password'];
    $sql = "SELECT * FROM `users` WHERE `uemail` = '$useremail' LIMIT 1";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        // output data of each row
        while ($row = $result->fetch_assoc()) {
            $chk_pass = $row['password'];
        }
        if (password_verify($passw, $chk_pass)) {
        $_SESSION['login_user'] = $useremail;
        header("location: index.php");
        } else {
        $php_errormsg = "Your Email or Password is invalid";
        echo $php_errormsg;
        }
    }
    else{
        $php_errormsg="User does not exist";
        echo $php_errormsg;
    }
    
}
?>
<body id="register">
    <div class="container">
        <div class="logo">Messenger</div>
        <div class="text">LOG IN</div>
        <form action=" " method="POST">
            <input type="email" name="email" placeholder="Enter Your Email Address" required>
            <input type="password" name="password" placeholder="Enter Your Password" required><br>
            <input type="submit" value="Login" name="login">
        </form>
        <a href="register.php">Register</a>
    </div>
</body>
<script type="text/javascript" src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>

</html>