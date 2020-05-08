<?php

    session_start();

    if(!isset($_SESSION['login_user']) || $_SESSION['login_user'] == "") {
        header("Location: login.php");
    }
    $currentuser=$_SESSION['login_user'];
    $contactemail=$_GET['contact'];
    $_SESSION['contactemail']=$contactemail;
    $chatname=$currentuser ."_" .$contactemail;
    $_SESSION['chatname']=$chatname;

 ?>
<?php
    include "db/config.php";
    $sql = "select * from `$currentuser` where cemail='$contactemail' ";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        // output data of each row
        while ($row = $result->fetch_assoc()) {
            $chatnamechk=$row['chatname'];
            // echo $chatnamechk;
            // echo $chatname;
        }
    }
    if($chatnamechk == ''){
        $sql = "update `$currentuser` set `chatname`='$chatname' where `cemail`='$contactemail'";
        if($conn->query($sql)===true){
            
        }else{echo "Error" . $conn->error;}
        $sql = "update `$contactemail` set `chatname`='$chatname' where `cemail`='$currentuser'";
        if($conn->query($sql)===true){
            
        }else{echo "Error" . $conn->error;}
    
        $sql= "CREATE TABLE if not exists `messenger`.`$chatname` ( `msgid` BIGINT NOT NULL AUTO_INCREMENT , `sender` VARCHAR(250) NOT NULL , `message` VARCHAR(65000) NOT NULL , `time` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , PRIMARY KEY (`msgid`)) ENGINE = InnoDB" ;
       if($conn->query($sql)===true){
            
        }else{
            echo "Error" . $conn->error;
        }
    }else{

    }
        $sql= "select * from `$currentuser` where cemail='$contactemail'";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $cname=$row['cname'];
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

<body id="msgpage" onload="scroll()">
    <div class="container">
        <div class="row">
            <div class="left">
                <div class="back"><img src="images/arrow-left.svg" alt=""></div>
                <a href="profile.php?contact=<?php echo $contactemail ?>">
                    <div class="imageblock"><img src="images/user/face.jpeg" alt=""></div>
                </a>
                <div class="nameblock">
                    <div class="name"><?php echo $cname ;?></div>
                </div>
            </div>
            <div class="right">
                <div class="dots">...</div>
            </div>
        </div>
        <div id="window-container">
            <div id="message-window">

                <?php
                include "db/config.php";
                $sql = "select `chatname` from `$currentuser` where cemail='$contactemail'";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $chatname=$row['chatname'];
                    }
                }
                else{
                    echo "Error" . $conn->error;
                }
                
                $sql= "select * from `$chatname`";
                $result=mysqli_query($conn,$sql) or die;
                if($result==true){
                    while($row=mysqli_fetch_assoc($result)){
                        if($row['sender']==$currentuser){
                            $date=$row['time'];
                            $date = strtotime($date);
                            $time= date('h:i a', $date);
                            ?> <div class="receiver">
                    <?php echo $row['message']?>
                    <div class="timehai"><?php echo $time ?></div>
                </div><?php
                        }elseif($row['sender']==$contactemail){
                            $date=$row['time'];
                            $date = strtotime($date);
                            $time= date('h:i a', $date);
                            ?> <div class="sender">
                    <?php echo $row['message'];?>
                    <div class="timehai"><?php echo $time ?></div>
                </div><?php
                        }
                    }
                }else{
                    echo "Error" . $conn->error;
                }
            ?>
            </div>
        </div>
        <div class="type">
            <form action="sendmessage.php" method="POST">
                <textarea name="message" id="message" cols="38" rows="1"></textarea>
                <input type="submit" name="submit" value="send">
            </form>
        </div>

    </div>

</body>
<script type="text/javascript" src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
<script>
    $('.back').click(function() {
        window.location.href = "index.php";
    })

</script>

</html>


<script>
    var receivecount = $('.sender').length;

    setInterval("my_function();", 100);

    function my_function() {
        $('#window-container').load(location.href + ' #message-window');
        var new_rc = $('.sender').length;
        if (new_rc > receivecount) {
            receivecount = new_rc;
            scroll();
        }

    }

</script>

<script>
    function scroll() {
        // var objDiv = document.getElementById("message-window");
        //     objDiv.scrollTop = objDiv.scrollHeight;
        var objDiv2 = document.getElementById("window-container");
        objDiv2.scrollTop = objDiv2.scrollHeight;
    }

</script>
