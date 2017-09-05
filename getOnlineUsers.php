<?php
session_start();
if (!$_SESSION["username"]) die;
include("dbController.php");
$db=mysqli_connect(HOST,USER,PASSWORD,DATABASE);
// Don't give the list to anybody not logged in
$username=$_SESSION['username'];
$query="select username,name,profile_pic from users,user_profile where available_flag > (now()-60) and users.username!='$username'and users.username=user_profile.user_id";
$users = mysqli_query($db,$query);
$output = "";
while($row=mysqli_fetch_array($users))
{
    $pic=$row['profile_pic'];
    $name=$row['name'];
    $uname=$row['username'];
    $output .= "<li>
                    <a href='messages.php?id=$uname' class='bg-warning'>
                        <img src='$pic'> ".$name."
                        <section class='conv_option'>
                            <span class='fa fa-phone'></span>
                            <span class='fa fa-circle online-color'></span>
                        </section>
                    </a>
                </li>";
}
print $output;
$query="select username,name,profile_pic from users,user_profile where available_flag < (now()-60) and users.username=user_profile.user_id";
$users = mysqli_query($db,$query);
$output = "";
while($row=mysqli_fetch_array($users))
{
    $pic=$row['profile_pic'];
    $name=$row['name'];
    $uname=$row['username'];
    $output .= "<li><a href='messages.php?id=$uname' class='bg-warning'><img src='$pic'> ".$name."
        <section class='conv_option'>
            <span class='fa fa-phone'></span>
            <span class='fa fa-circle-o online-color'></span>
        </section></a></li>";
}
print $output;
?>
