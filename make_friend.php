<?php
    include "dbController.php";
    if (isset($_GET['id'])){
        $friends=new Friend();
        $res=$friends->createFriendship($_GET['id'],$_GET['u'],$_GET['act']);
        if(!$res){
            echo"<script>alert('no friendship created');</script>";
        }
    }



?>