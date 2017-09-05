<?php
if(isset($_POST['id'])){
    $id=$_POST['id'];
    $db=mysqli_connect("localhost","root","123456","gettogether");

    $sql="select * from user_profile where user_id='$id'";
    $res=mysqli_query($db,$sql);
    $row=mysqli_fetch_assoc($res);
    echo $row['profile_pic'];
}
?>