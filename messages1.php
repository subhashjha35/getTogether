<?php
/**
 * Created by PhpStorm.
 * User: subhash
 * Date: 9/3/17
 * Time: 4:31 AM
 */
session_start();

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script type="text/javascript" src="./js/jquery-1.8.3.min.js"></script>
    <script type="text/javascript" src="./js/emojionearea.js"></script>
    <script type="text/javascript" src="./js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/emojionearea.css">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <title>Profile Page - GetTogether</title>

    <!--- For setting the online status of the User --->

    <script type="text/javascript">
        setInterval("onlineStatusUpdate()", 5000); // Update every 10 seconds
        setTimeout(function(){
            onlineStatusUpdate();
        },1000);
        <?php if(isset($_GET['id'])){
            $id=$_GET['id'];
            ?>
            setInterval("updateChat('<?php echo $id;?>')",1000);
            function updateChat(id=null){
                $.get("insert_message.php",{receiver:id},function(data){
                    $(".inner_chat_section").html(data);
                    $('.outer_chat_section').scrollTop($('.outer_chat_section')[0].scrollHeight);
                });
            }
            function insert_message(){
                if($("#text_msg").val()){
                    msg_body=$("#text_msg").val();
                    $.get("insert_message.php",{receiver:"<?=$_GET['id']?>", msg_text:msg_body, msg_obj:"text"}, function(data){
                        $(".inner_chat_section").html(data);
                        $('.outer_chat_section').scrollTop($('.outer_chat_section')[0].scrollHeight);
                    });
                    $("#msg_send_btn").val("");
                }

            }
            <?php
         } ?>

        function onlineStatusUpdate()
        {
            $.post("onlineStatusUpdate.php"); // Sends request to update.php
            $.post("getOnlineUsers.php",null,function(data){
                $("#onlineUsersList").html(data);
            });
        }

        $(document).ready(function () {
            $("#text_msg").keyup(function(event){
                if(event.keyCode == 13){
                    $("#msg_send_btn").click();
                    $("#text_msg").val("");
                }
            });

        });




    </script>

    <!--- xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx --->

    <style>
        body{
            background: #efefef;
        }
        .no-margin{
            margin:0px;!important;
        }
        .no-padding{
            padding:0px;!important;
        }
        .profile-image{
            max-width:100px;
        }

        .left-div, .chat-div{
            padding:10px;
            background-color: #fff;
            border: solid #d6d6d6;
            border-width: 0px 1px;
            box-sizing: border-box;
            padding-bottom: 10000px;
            margin-bottom: -10000px;
            overflow: hidden;
        }
        .chat-div .onlineBox{
            display:block;
        }
        .chat-div .onlineBox ul{
            list-style: none;
            padding:0px;
        }
        .chat-div .onlineBox ul li{
            display: block;
        }
        .chat-div .onlineBox ul li a{
            display: block;
            padding:10px;
            color:#444;
            text-decoration:none;
        }
        .chat-div .onlineBox ul img{
            height:28px;
            border-radius:14px;
        }
        .chat-div .onlineBox ul li a{
            position: relative;
        }
        .chat-div .onlineBox ul a .online-color{
            color: #f09400;
        }
        .chat-div .onlineBox ul li a .conv_option{
            position:absolute;
            display:inline-block;!important;
            right:10px;
        }
        .m10{
            margin:10px;
        }
        .p10{
            padding: 10px;
        }
        @media screen and (min-width: 768px) {
            .user-block-container{
                padding:10px; !important;
            }
        }
        @media screen and (max-width: 768px) {
            .user-block-container{
                padding:5px; !important;
            }
        }

        .user-block-container{
            border: 1px solid #d6d6d6;
            background: #fff;
        }
        .user-block{
            position: relative;
        }
        .user-block .fa-user-plus{
            position: absolute;
            right:7%;
            top:7%;
            font-size: 20px;
        }
        #user_profile_modal .interests{
            padding:5px;
        }

        @media screen and (max-width:768px){
            .col-md-4, .col-xs-6 {
                padding: 2px;!important;
            }
        }
        @media screen and (min-width:768px){
            .col-md-4, .col-xs-6 {
                padding: 10px;!important;
            }
        }

        #chat_container{
            position: relative;
            height:100%;
            background:#fff;
            box-sizing: border-box;

        }
        #chat_container img{
            height:20px;
        }
        #chat_list{
            background:#fff;
            padding:0px 5px;
            box-sizing: border-box;
            bottom:0px;
        }
        #chat_list nav{

        }
        #chat_block
        {
            position: relative;
            height: 580px;
            border-left:1px solid #d6d6d6;
            right:-3px;
            background:#fff;
            padding:0px 5px;
        }
        #chat_block .outer_chat_section{
            position:relative;
            overflow-y: scroll;
            height:540px;
        }
        #chat_block .inner_chat_section{
            padding:10px;
            position:relative;
            bottom:10px;
        }
        #chat_block .inner_chat_section .input-group{
            position:absolute;
            bottom: 0px;
        }


    </style>
</head>
<body>
<?php include "header.php"; ?>
<div class="container-fluid no-margin no-padding" id="main_container">
    <div class="col-md-3 left-div">
        <div class="text-center">
            <?php
            $db=mysqli_connect("localhost","root","123456","gettogether");
            $username=$_SESSION['username'];
            $sql="select * from users,user_profile where users.username='$username' and users.username=user_profile.user_id";
            $res=mysqli_query($db,$sql);
            $row=mysqli_fetch_assoc($res);
            $user_img=$row['profile_pic'];
            $name=$row['name'];
            ?>
            <img src="<?=$user_img;?>" alt="" class="img-circle profile-image">
            <div><strong><a href="profile.php"><?=$name;?></a></strong></div>
            <div class=""><?=$_SESSION['username'];?></div>
        </div>
        <div>
            <form action="" method="post">
                <div class="form-group">
                    <h4>Search People</h4>
                    <label for="country">Country</label>
                    <select name="" id="" class="form-control">
                        <option value="0">Afghanistan</option>
                        <option value="0">Albania</option>
                        <option value="0">Algeria</option>
                        <option value="0">Argentina</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="nat_language">Native Language</label>
                    <select name="native_language" id="nat_language" class="form-control">
                        <option value="0">English</option>
                        <option value="0">Spanish</option>
                        <option value="0">Japanese</option>
                        <option value="0">French</option>
                        <option value="0">Arabic</option>
                        <option value="0">Hindi</option>
                    </select>
                </div>
            </form>
        </div>
    </div>

    <div class="col-md-7" id="chat_container">
        <div class="col-md-3" id="chat_list">
            <nav class="navbar">
                <ul class="nav">
                    <?php
                        $msg=new Message();
                        $res=$msg->showDistinctUser($_SESSION['username']);
                        foreach ($res as $uname) {
                            $user = new User();
                            $fetch_user = $user->showUserProfile(array('username' => $uname));
                            $row = $fetch_user->fetch_assoc();
                            ?>
                            <li><a href="messages.php?id=<?= $row['username']; ?>">
                                    <img src="<?=$row['profile_pic'];?>" class="img-rounded" style="height:40px;" alt=""> <?= $row['name']; ?></a></li>
                            <?php
                        }
                    ?>
                </ul>
            </nav>
        </div>
        <div class="col-md-9" id="chat_block">
            <div class="outer_chat_section">
                <section class="inner_chat_section" id="msg_container">
                    <?php
                        if(isset($_GET['id'])){
                            $msg = new Message();
                            $user2 = $_GET['id'];
                            $user1 = $_SESSION['username'];
                            $get_messages = $msg->showMessage($user1, $user2);
                            /*print_r($get_messages);*/

                            foreach ($get_messages as $msgs){
                                $sender = $msgs['sender_id'];
                                $msg_text = $msgs['msg_text'];
                                $receiver = $msgs['receiver_id'];
                                $msg_obj = $msgs['msg_obj'];
                                $msg_time = $msgs['msg_time'];
                                if ($sender == $user1){
                                    ?>
                                    <div class="" style="text-align: right">
                                        <p class="alert alert-success" style="display: inline-block;"><?= $msg_text; ?></p> <img
                                                src="./resources/images/user_male.png" style="height:40px;" alt="">
                                    </div>

                                    <?php
                                }
                                else {
                                ?>
                                <div class="">
                                    <img src="./resources/images/user.jpg" class="img-rounded" style="height:40px;" alt="">
                                    <p class="alert alert-danger" style="display: inline-block;"><?= $msg_text; ?></p>
                                </div>

                        <?php
                        }
                        }
                        }
                        ?>
                </section>
            </div>
            <div class="input-group">
                <input type="text" class="form-control" id="text_msg">
                <div class="input-group-btn">
                    <button type="submit" class="btn btn-success" id="msg_send_btn" onclick="insert_message()">Send</button>
                </div>
            </div>
        </div>
    </div>
    <div class="panel panel-danger col-md-2 chat-div">
        <div class="panel-heading">
            <span class="panel-title">Online Users</span>
        </div>
        <div class="onlineBox panel-body" style="padding:0px;">
            <ul class="" id="onlineUsersList">

            </ul>
        </div>
    </div>
</div>
<div id="user_profile_modal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content" style="position: relative">

        </div>
    </div>
</div>
<script>
    function getUserProfileDetails(userid){
        $.get("get_user_profile_details.php",{user:userid},function(data){
            $("#user_profile_modal .modal-content").html(data);
        });
        $("#user_profile_modal").modal('show');
    }


    $("#text_msg").emojioneArea({
        autoHideFilters: true,
        useSprite: false,
        saveEmojisAs: "image"
    });
</script>
</body>
</html>

