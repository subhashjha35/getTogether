<?php
    include "dbController.php";
    if(isset($_GET['username']) and $_GET['username']!=''){
        $uname=$_GET['username'];
        $user=new User();
        $arr=Array();
        $arr['username']=$uname;
        $result=$user->showUsers($arr);
        $result=$user->dbase->affected_rows;
        if($result)
            echo "exists";
        else
            echo "available";
    }
?>
