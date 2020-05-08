<?php

    session_start();

    if(!isset($_SESSION['login_user']) || $_SESSION['login_user'] == "") {
        header("Location: login.php");
    }
$currentuser=$_SESSION['login_user'];
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

<body id="home">
    <nav>
        <div class="logo">Messenger</div>
        <div class="group">
            <div class="add"><a href="adduser.php"><img src="images/user-plus.svg" alt=""></a></div>
            <div class="logout"><a href="logout.php">Logout</a></div>
        </div>
        <ul class="main-nav">
            <li><a href="">Setting</a></li>
            <li><a href="">Profile</a></li>
        </ul>
    </nav>
    <div class="container">
        <div class="options">
            <div class="chats active">
                <div class="title"><img src="images/message-square.svg" alt="">Chats</div>
            </div>
            <div class="contacts">
                <div class="title"><img src="images/user.svg" alt="">Contacts</div>
            </div>
        </div>
        <div id="chat">
            <div class="main-chats">
                <?php 
                include "db/config.php";
                $sql="select * from `$currentuser` where chatname!=''";
                $result=mysqli_query($conn,$sql) or die;
                if($result==true){
                    while($row=mysqli_fetch_assoc($result)){
                        $contactname=$row['cname'];
                        $contactemail=$row['cemail'];                                    
                ?>
                <a href="chat.php?contact=<?php echo $contactemail ;?>">
                    <div class="row friend">
                        <div class="imageblock"><img src="images/user/face.jpeg" alt=""></div>
                        <div class="nameblock">
                            <div class="name"><?php echo $contactname ?></div>
                            <div class="recentmsg"><?php
                            $sql ="select * from `$currentuser` where `chatname` != '' and cemail='$contactemail'";
                            $result1 = $conn->query($sql);
                            if ($result1->num_rows > 0) {
                                while ($row1 = mysqli_fetch_assoc($result1)) {
                                    $current_chat=$row1['chatname'];
                                    $sql ="select * from `$current_chat` ORDER BY msgid DESC LIMIT 1";
                                    $result2 = $conn->query($sql);
                                  
                                    if ($result2->num_rows > 0) {
                                        $onerow=$result2->fetch_all();
                                        foreach ($onerow as $row2) {
                                            echo $row2[2];
                                        }
                                    }
                                }
                            }?>
                            </div>
                        </div>
                    </div>
                </a>
                <?php 
                }
            }
                ?>
            </div>
        </div>
        <div id="contacts">
            <?php 
                include "db/config.php";
                $sql="select * from `$currentuser` order by cname";
                $result=mysqli_query($conn,$sql) or die;
                if($result==true){
                    while($row=mysqli_fetch_assoc($result)){
                        $contactname=$row['cname'];
                        $contactemail=$row['cemail'];                                    
            ?>
            <a href="chat.php?contact=<?php echo $contactemail ;?>">
                <div class="row friend">
                    <div class="imageblock"><img src="images/user/face.jpeg" alt=""></div>
                    <div class="nameblock">
                        <div class="name"><?php echo $contactname ?></div>
                    </div>
                </div>
            </a>
            <?php
                    }
                }
            ?>
        </div>
    </div>
</body>
<script type="text/javascript" src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
<script>
    $('.chats').click(function() {
        $('#chat').css("display", "block");
        $('#contacts').css("display", "none");
        $('.chats').addClass('active');
        $('.contacts').removeClass('active');
    })
    $('.contacts').click(function() {
        $('.chats').removeClass('active');
        $('.contacts').addClass('active');
        $('#contacts').css("display", "block");
        $('#chat').css("display", "none");
    })
    $('.friend').click(function() {
        window.location.href = "chat.php";
    })

    setInterval("my_function();", 2500);

    function my_function() {
        $('#chat').load(location.href + ' .main-chats');
    }

</script>

</html>
