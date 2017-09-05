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
    <script type="text/javascript" src="./js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <title>Profile Page - GetTogether</title>

    <!--- For setting the online status of the User --->

    <script>
        $(document).ready(function(){
            $("#ctrChosen").change(function(){
                $ctr=$("#ctrChosen").val();
                location.href="home.php?ctrChosen="+$ctr;
            });
        });

        setInterval("onlineStatusUpdate()", 5000); // Update every 10 seconds
        setTimeout(function(){
            onlineStatusUpdate();
        },1000)
        function onlineStatusUpdate()
        {
            $.post("onlineStatusUpdate.php"); // Sends request to update.php
            $.post("getOnlineUsers.php",null,function(data){
                $("#onlineUsersList").html(data);
            });
        }

        function makeFriend(user) {
            $.get("make_friend.php",{id:user,u:"<?=$_SESSION['username'];?>",act:"friend_request"});
        }

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
                <a href="intermediate.php"><img src="<?=$user_img;?>" alt="" class="img-circle profile-image"></a>
                <div><strong><a href="profile.php"><?=$name;?></a></strong></div>
                <div class=""><?=$_SESSION['username'];?></div>
            </div>
            <div>
                <form action="" method="post">
                    <div class="form-group">
                        <h4>Search People</h4>
                        <label for="country">Country</label>
                        <select name="" id="ctrChosen" class="form-control">
                            <?php
                            $loc=new Location();
                            $res=$loc->getCountry();
                            while($row =$res->fetch_assoc()){
                                $name=$row['name'];
                                $id=$row['id'];
                            ?>
                            <option value="<?=$id;?>"
                                <?php
                                    if(isset($_GET['ctrChosen'])){
                                        if($id==$_GET['ctrChosen'])
                                            echo "selected";
                                    }
                                ?>
                            ><?=$name;?></option>
                            <?php  } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="nat_language">Native Language</label>
                        <select name="native_language" id="nat_language" class="form-control">
                            <?php
                                $lang=new Language();
                                $llist=$lang->showLanguage();
                                while($row=$llist->fetch_assoc()):
                            ?>
                            <option value="<?=$row['name']?>"><?=$row['name']?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                </form>
                <a href="home_post.php" class="btn btn-primary">Post something</a>
            </div>
        </div>

        <div class="col-md-7">
            <div class="container-fluid">
                <div class="row bg-warning">
                    <?php
                        $user=new User();
                        if(isset($_GET['ctrChosen'])){
                            $ctr=$_GET['ctrChosen'];
                            $res=$user->showUserProfile(array("country_id"=>$ctr),$_SESSION['username']);
                        }
                        else
                        {
                            $res=$user->showUserProfile("",$_SESSION['username']);
                        }

                        while($row=$res->fetch_assoc()){
                    ?>
                    <div class="col-md-4 col-xs-6">
                        <div class="user-block-container img-rounded">
                            <div class="text-center user-block">
                                <a href="#" id="<?=$row['username'];?>" onclick="makeFriend(this.id)"><span class="fa fa-user-plus"></span></a>
                                <img src="<?=$row['profile_pic'];?>" class="profile-image img-circle table-bordered" alt="">
                                <div><a href="#" onclick="getUserProfileDetails(this.id)" id="<?=$row['username'];?>"><?=$row['name'];?></a></div>
                                <div><?php
                                    $loc=new Location();
                                    $res1=$loc->getCountry($row['country_id']);
                                    $abc=$res1->fetch_assoc();
                                    echo $abc['name'];
                                    ?>
                                </div>
                                <hr>
                                <div>
                                    Native: <?=$row['native_lan'];?>
                                </div>
                                <div>
                                    Learning: <?=$row['learn_lan'];?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                        }
                    ?>
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
    </script>
</body>
</html>
