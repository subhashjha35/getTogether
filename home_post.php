<?php
/**
 * Created by PhpStorm.
 * User: subhash
 * Date: 9/3/17
 * Time: 4:31 AM
 */
session_start();
include "dbController.php";
date_default_timezone_set("Asia/Kolkata");
if(isset($_POST['post_text'])){
    $post_text=$_POST['post_text'];
    $username=$_SESSION['username'];
    $file_type="";
    $flag=1;
    print_r($_FILES['picture']);
    print_r($_FILES['file']);
    print_r($_FILES['video']);

    if($_FILES['picture']['size']>20000){
        $file=$_FILES['picture'];
        $file_name=$file['name'];
        $tmp_name=$file['tmp_name'];
        $file_type="picture";
        echo $destination="resources/users/".$username."/chat_data/images/img".date("hidmy",time()).$file_name;
        if(!move_uploaded_file($tmp_name,$destination)){
            echo "can't upload file";
            $flag=0;
        }
        else
            $flag=1;
    }
    elseif($_FILES['video']['size']>100000 && $_FILES['video']['size']<20000000){
        $file=$_FILES['video'];
        $file_name=$file['name'];
        $tmp_name=$file['tmp_name'];
        $file_type="video";
        echo $destination="resources/users/".$username."/chat_data/videos/vid".date("hidmy",time()).$file_name;
        if(!move_uploaded_file($tmp_name,$destination)){
            echo "can't upload file";
            $flag=0;
        }
        else
            $flag=1;
    }
    elseif($_FILES['file']['size']>10){
        $file=$_FILES['file'];
        $file_name=$file['name'];
        $tmp_name=$file['tmp_name'];
        $file_type="document";
        $destination="resources/users/".$username."/chat_data/documents/file".date("hidmy",time()).$file_name;
        if(!move_uploaded_file($tmp_name,$destination)){
            echo "can't upload file";
            $flag=0;
        }
        else
            $flag=1;
    }
    else{
        $file_type="";
        $destination="";
    }
    if($flag==1){
        $post=new Post();
        $post->createPost($username,$post_text,$destination,$file_type);
    }
    else
        echo "can't post your message right now";
}

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
        $(document).ready(function(){

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
            position:relative;
            padding:10px;
            color:#444;
            text-decoration:none;
        }
        .chat-div .onlineBox ul img{
            height:28px;
            border-radius:14px;
        }
        .chat-div .onlineBox ul a .online-color{
            color: #f09400;
        }
        .chat-div .onlineBox ul li a .conv_option {
            position: absolute;
            display: inline-block;!important;
            right: 10px;
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

        .post-block{
            margin:10px 0px 10px 10px;
            padding:10px;
            border-radius:10px 10px 0 0;!important;
            overflow: hidden;!important;
        }
        .post-block .form-group textarea{
            -webkit-transition: all 0.2s ease-out;
            height: 36px;
        }
        .post-block .form-group textarea:focus{
            height: 80px;
        }
        .post-list{
            margin: 10px 0px 10px 10px;
            padding:10px;
            border-radius:5px;
            border:1px solid orange;
        }
        .post-list .row{
            padding:10px;
        }

        .suggestion_result_box{
            border:1px solid #ccc;
            -webkit-border-radius:5px;
            -moz-border-radius:5px;
            border-radius:5px;
            margin:2px 0px;
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
            $db=mysqli_connect(HOST,USER,PASSWORD,DATABASE);
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

    <div class="col-md-5">
        <div class="row">
            <div class="post-block bg-warning">
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="post_body">Do you have something to Post?</label>
                        <textarea name="post_text" id="" class="form-control"></textarea>
                    </div>
                    <div class="form-group">
                        <label class="btn btn-default" for="addFile"><i class="fa fa-paperclip" aria-hidden="true"></i></label>
                        <input type="file" id="addFile" name="file" class="hidden">
                        <label class="btn btn-default" for="addPicture"><i class="fa fa-picture-o" aria-hidden="true"></i></label>
                        <input type="file" id="addPicture" name="picture" class="hidden">
                        <label class="btn btn-default" for="addVideo"><i class="fa fa-video-camera" aria-hidden="true"></i></label>
                        <input type="file" id="addVideo" name="video" class="hidden">
                        <div class="text-right" style="display: inline-block;float: right;">
                            <button type="submit" class="btn btn-warning">POST</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="row">
            <?php
            $post=new Post();
            $res=$post->showPosts();

            while($row=$res->fetch_assoc()):
                $post_id=$row['posts_id'];
                $post_text=$row['post_text'];
                $post_object=$row['post_object'];
                $object_type=$row['post_object_type'];
                $uname=$row['user_id'];
                $name=$row['name'];
                $time=$row['post_time'];
                $user_pic=$row['profile_pic'];
                $time=strtotime($time);
                /*echo $time;*/
                $t=time()-$time;

                /*echo "<br>".$t;*/
                if($t>=(60*60*24*365.25))
                    $new_t=floor($t/(60*60*24*365.25))." year";
                else if($t>=60*60*24*30){
                    $new_t=floor($t/(60*60*24*30))." months";
                }
                else if($t>=60*60*24){
                    $new_t=floor($t/(60*60*24))." days";
                }
                else if($t>=60*60){
                    $new_t=floor($t/(60*60))." hours";
                }
                else if($t>=60){
                    $new_t=floor($t/(60))." minutes";
                }
                else{
                    $new_t=floor($t)." seconds";
                }
                ?>
                <div class="post-list bg-warning">
                    <div class="row">
                        <div class="col-md-2 col-xs-3">
                            <img src="<?=$user_pic;?>" alt="" class="img-responsive img-rounded">
                        </div>
                        <div class="col-md-9 col-xs-8">
                            <a href="#"><span class="h4"><?=$name;?></span><br><span class="h5">@<?=$uname;?></span></a>
                            <span><?=$new_t;?></span>
                        </div>
                        <div class="col-md-1 col-xs-1" style="position: relative;">
                            <nav class="navbar navbar-default navbar-right" style="inline-block; position:absolute;right:20px">
                                <ul class="nav navbar-nav">
                                    <li class="dropdown"><a href="#" class="" data-toggle="dropdown"><span class="fa fa-edit"></span></a>
                                        <ul class="dropdown-menu">
                                            <li><a href="#">Unfriend User</a></li>
                                            <li><a href="#">Report this Post</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <p><?=$post_text;?></p>
                        </div>
                    </div>
                    <div class="text-center">
                        <?php
                        if($object_type=="picture"):
                            ?>
                            <img src="<?=$post_object;?>" alt="" class="img-responsive">
                            <?php
                        elseif($object_type=="video"):
                            ?>
                            <video class="img-responsive" controls>
                                <source src="<?=$post_object;?>">
                            </video>
                            <?php
                        elseif($object_type=="file"):
                            ?>

                            <?php
                        endif;
                        ?>
                    </div>
                    <div>
                        <div style="background:#fff;">
                            <a href="#">
                                <span class="fa fa-heart-o"></span>
                                <span>12</span> Likes</a> |
                            <a href="#">
                                <span>
                                    <?php
                                    $com=new PostComment();
                                    $a=$com->countPost($post_id);
                                    $r=$a->fetch_array();
                                    echo $r[0];?>
                                </span> Comments</a>
                        </div>
                        <div class="input-group">
                            <div class="input-group-addon">
                                <img src="./resources/images/user(256).jpg" alt=""height="20px">
                            </div>
                            <input type="text" class="form-control" id="<?="post_text".$post_id;?>">
                            <div class="input-group-btn">
                                <button type="button" class="btn btn-primary" id="<?=$post_id;?>"onclick="insert_comment(this.id)">Comment</button>
                            </div>
                        </div>
                        <div id="<?='comment-list-box'.$post_id;?>" style="overflow:hidden;">
                            <?php
                            $comment=new PostComment();
                            $res1=$comment->showPostComment($post_id,5);
                            while($row1=$res1->fetch_assoc()) {
                                ?>
                                <div class="" style="background:#EEEEEE; padding:5px 10px;">
                                    <?= $row1['username']; ?> : <?= $row1['comment_body']; ?></div>

                                <?php
                            }
                            ?>
                            <a class="btn btn-warning" style="padding:2px 5px;float:right;">View All</a>
                        </div>

                    </div>

                </div>
            <?php endwhile;
            ?>
            <div class="post-list bg-warning">
                <div class="row">
                    <div class="col-md-2 col-xs-3">
                        <img src="" alt="" class="img-responsive img-rounded">
                    </div>
                    <div class="col-md-9 col-xs-8">
                        <a href="#"><span class="h4">Subhash Jha</span><br><span class="h5">@subhashjha35</span></a>
                    </div>
                    <div class="col-md-1 col-xs-1" style="position: relative;">
                        <nav class="navbar navbar-default navbar-right" style="inline-block; position:absolute;right:20px">
                            <ul class="nav navbar-nav">
                                <li class="dropdown"><a href="#" class="" data-toggle="dropdown"><span class="fa fa-edit"></span></a>
                                    <ul class="dropdown-menu">
                                        <li><a href="#">Unfriend User</a></li>
                                        <li><a href="#">Report this Post</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolorum nulla quasi quod? Adipisci amet debitis fugit impedit magnam non vel voluptates!
                            Commodi consectetur dolore dolorum ex, maiores minus possimus veritatis!</p>
                    </div>
                </div>
                <div class="text-center">
                    <img src="./resources/images/user_female.png" alt="">
                </div>
                <div style="background:#fff;">
                    <a href="#"><span class="fa fa-heart-o"> <span>12</span> </span> Likes</a> | <a href="#"><span>5</span> Comments</a>
                </div>
                <div>
                    <div class="input-group">
                        <div class="input-group-addon">
                            <img src="./resources/images/user(256).jpg" alt=""height="20px">
                        </div>
                        <input type="text" class="form-control">
                        <div class="input-group-btn">
                            <button type="button" class="btn btn-primary">Comment</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-2" style="padding:10px">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title"><strong>You may need them</strong></div>
            </div>
            <div class="panel-body">
                <div class="suggestion_result_box col-xs-6 col-md-12">
                    <div class="text-center">
                        <img src="./resources/images/user(256).jpg" width="50%" class="" alt="">
                    </div>
                    <div><strong>Subhash Jha,</strong> <span>India</span></div>
                    <div>Native: English</div>
                </div>
                <div class="suggestion_result_box col-xs-6 col-md-12">
                    <div class="text-center">
                        <img src="./resources/images/user(256).jpg" width="50%" class="" alt="">
                    </div>
                    <div><strong>Subhash Jha,</strong> <span>India</span></div>
                    <div>Native: English</div>
                </div>
                <div class="suggestion_result_box col-xs-6 col-md-12">
                    <div class="text-center">
                        <img src="./resources/images/user(256).jpg" width="50%" class="" alt="">
                    </div>
                    <div><strong>Subhash Jha,</strong> <span>India</span></div>
                    <div>Native: English</div>
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
    function insert_comment($id){
        $comment_text=$("#post_text"+$id).val();

         /*alert($comment_text);*/
        $.get("showPosts.php",{post_id:$id,user:"<?=$_SESSION['username'];?>",comment_text:$comment_text},function(data){
         $("#comment-list-box"+$id).html(data);
         });
    }
</script>
</body>
</html>
