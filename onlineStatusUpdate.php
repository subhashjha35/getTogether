<?php

session_start();
$db=mysqli_connect("localhost","root","123456","gettogether");
$username=$_SESSION['username'];
if ($username)
{
    mysqli_query($db,"UPDATE users SET available_flag = NOW() WHERE username = '$username'") or die(mysqli_error($db));
}


?>