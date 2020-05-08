<?php

session_start();

$contactemail=$_SESSION['contactemail'];
if(!isset($_SESSION['login_user']) || $_SESSION['login_user'] == "") {
    header("Location: login.php");
}
$currentuser=$_SESSION['login_user'];

include "db/config.php";
    
    $sql = "select `chatname` from `$currentuser` where cemail='$contactemail'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $chatname=$row['chatname'];
            echo $chatname;
        }
    }
    else{
        echo "Error" . $conn->error;
    }
    if(isset($_POST['submit'])){
        if ($_POST['submit'] == "send"){ 
          
            $messageis=$_POST['message'];
            
            $sender=$currentuser;
            if($messageis==""){header("location: chat.php?contact=$contactemail");}else{
            $sql="INSERT INTO `$chatname`(`msgid`, `sender`, `message`, `time`) VALUES (NULL,'$sender','$messageis',current_timestamp())";
            if ($conn->query($sql) === true) {
                header("location: chat.php?contact=$contactemail");
            }
            else{
                echo "Error" . $conn->error;
            }
        }
        }
    }
?>
