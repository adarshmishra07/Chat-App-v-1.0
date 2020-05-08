<?php

    session_start();

    if(!isset($_SESSION['login_user']) || $_SESSION['login_user'] == "") {
        header("Location: login.php");
    }
$currentuser=$_SESSION['login_user'];


//echo $currentuser;
 ?>
<?php
include 'db/config.php';
$php_errormsg="";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $newcontact = $_POST['newcontact'];
    $sql = "SELECT * FROM `users` WHERE `uemail` = '$newcontact' LIMIT 1";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $sql = "select * from `$currentuser` where cemail = '$newcontact' LIMIT 1";
        $result = $conn->query($sql);
        if ($result->num_rows == 0) {
            $sql ="select * from users where uemail ='$newcontact' ";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                $contactname = $row['uname'];
                $contactemail = $row['uemail'];
                
                }
                $sql = "insert into `$currentuser` (`cid`, `cname`, `cemail`,`chatname` ) values(NULL, '$contactname', '$contactemail','' )";
                if ($conn->query($sql) === true) {
                    $sql ="select * from users where uemail='$currentuser'";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $currentname=$row['uname'];
                            $sql = "insert into `$contactemail` (`cid`, `cname`, `cemail`,`chatname` ) values(NULL, '$currentname', '$currentuser','' )";
                            if ($conn->query($sql) === true) {
                                header("location: index.php");
                            }else{
                                echo "Error" . $conn->error;
                            }
                        }
                    }


                }else{
                    echo "Error" . $conn->error;
                }
            }
        }else{
            $php_errormsg="Contact exists";
            echo $php_errormsg;
        }
    }
    else{
        $php_errormsg="User With this email is not registered";
        echo $php_errormsg;
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
        <div class="row">
            <div class="back"><img src="images/arrow-left.svg" alt=""></div>
            <div class="nameblock">Add Contact</div>
        </div>
        <div class="logo">Messenger</div>
        <form action=" " method="post">

            <input type="email" name="newcontact" placeholder="Enter Email Address" required><br>
            <input type="submit" value="Submit" name="submit">
        </form>
    </div>
</body>
<script type="text/javascript" src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>

<script>
    $('.back').click(function() {
        window.location.href = "index.php";
    })

</script>

</html>
