<?php 
    include "db/config.php";
    if(isset($_POST['submit'])){
        if ($_POST['submit'] == "Submit"){ 
            $name=$_POST['name'];
            $email=$_POST['email'];
            $password=$_POST['password'];
            $confirm_password=$_POST['confirm_password'];
            $options = [
                'cost' => 12,
            ];
            $sql = "SELECT * FROM users WHERE uemail = '$email'";
            $result = $conn->query($sql);
            if ($result->num_rows == 0) {
                if ($password == $confirm_password) {
                    $password = password_hash($_POST["password"], PASSWORD_BCRYPT,$options);
                    $sql = "INSERT INTO `users` (`user_id`, `uname`, `uemail`, `password`) VALUES (NULL, '$name', '$email', '$password')";
                    if ($conn->query($sql) === true) {
                        $sql = "CREATE TABLE `messenger`.`$email` ( `cid` BIGINT(10) NOT NULL primary key AUTO_INCREMENT , `cname` VARCHAR(500) NOT NULL , `cemail` VARCHAR(500) NOT NULL , `chatname` VARCHAR(5000) NOT NULL ) ;";
                        if($conn->query($sql)===true){
                            header("location: index.php");   
                        }else{
                            echo "Error" . $conn->error;
                        }
                        
                    } else {
                        echo "Error" . $conn->error;
                    }
                }else{
                    $php_errormsg='Password and Confirm Password does not match';
                }
            }else{
                $php_errormsg="Email already registered";
            }
        }           
    }
?>
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
<body id="register">
    <div class="container">
        <div class="logo">Messenger</div>
        <div class="text">To start using Messenger please register with your Email Id</div>
        <form action=" " method="post">
            <input type="name" name="name"  placeholder="Enter Your Name" required>
            <input type="email" name="email" placeholder="Enter Your Email Address" required>
            <input type="password" name="password" placeholder="Create Password"required>
            <input type="password" name="confirm_password" placeholder="Confirm Password" required><br>
            <input type="submit" value="Submit" name="submit">
        </form>
        <a href="index.php">Log In</a>
    </div>
</body>
<script type="text/javascript" src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>

</html>
