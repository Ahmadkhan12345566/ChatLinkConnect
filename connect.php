<?php

$con = new mysqli("localhost",'root','password','chats');
if(!$con){
die(mysqli_error($con));
}

?>
