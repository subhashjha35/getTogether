<?php
session_start();
include "dbController.php";
if(isset($_GET['msg_text'])){
    $msg_text=$_GET['msg_text'];
    $sender=$_SESSION['username'];
    $receiver=$_GET['receiver'];
    $msg_obj=$_GET['msg_obj'];
    $msg=new Message();
    $msg->createMessage($sender,$receiver,$msg_text,$msg_obj);
}


$msg=new Message();
$user2=$_GET['receiver'];
$user1=$_SESSION['username'];
$get_messages=$msg->showMessage($user1, $user2);
/*print_r($get_messages);*/

foreach($get_messages as $msgs){
    $sender=$msgs['sender_id'];
    $msg_text=$msgs['msg_text'];
    $receiver=$msgs['receiver_id'];
    $msg_obj=$msgs['msg_obj'];
    $msg_time=$msgs['msg_time'];
    $user=new User();
    if($sender==$user1){
        $res=$user->showUserProfile($sender);
        $arr1=$res->fetch_assoc();
        ?>
        <div class="" style="text-align: right">
            <p class="alert alert-success" style="display: inline-block;padding:5px 10px;!important;                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    "><?=$msg_text;?></p> <img src="<?=$arr1['profile_pic'];?>" class="img-rounded" style="height:40px;" alt="">
        </div>

    <?php
    }
    else {
        $res=$user->showUserProfile($user2);
        $arr2=$res->fetch_assoc();
    ?>
        <div class=""">
            <img src="<?=$arr2['profile_pic'];?>" class="img-rounded" style="height:40px;" alt=""> <p class="alert alert-danger" style="display: inline-block;padding:5px 10px;!important;"><?=$msg_text;?></p>
        </div>

    <?php
    }

}


?>
