<?php

    session_start();

    if(!isset($_SESSION['login_user']) || $_SESSION['login_user'] == "") {
        header("Location: login.php");
    }
    $currentuser=$_SESSION['login_user'];
    $contactemail=$_GET['contact'];

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
<?php
    include "db/config.php";

    $sql = "select * from `users` where `uemail`='$contactemail'";
    $res=$conn->query($sql);
    if ($res->num_rows > 0) {
        while ($row = $res->fetch_assoc()) {
            $contactname=$row['uname'];
        }
    }

?>
<body id="profile">
    <div class="container">
        <div class="row">
            <div class="back"><img src="images/arrow-left.svg" alt=""></div>
            <div class="nameblock"><?php echo $contactname ?></div>
        </div>
        <div class="image">
            <div class="pro-pic">
                <img src="images/user/face.jpeg" alt="">
            </div>
        </div>
        <div class="info">
            <div class="email-info">
                <img src="images/mail.svg" alt="" class="emailicon">
                <div class="email"><?php echo $contactemail ;?></div>
            </div>
            
        </div>
    </div>
</body>
<script type="text/javascript" src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
<script>
    $('.back').click(function(){
        window.location.href="index.php";
    })
</script>
</html>