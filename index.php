<?php
    session_start();


?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <script type="text/javascript" src="./js/jquery-1.8.3.min.js"></script>
    <script type="text/javascript" src="./js/innerHeight.js"></script>
    <script type="text/javascript" src="./js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/font-awesome.css">
    <style>


        #section-1{
            background-image: url("resources/web/images/section-1.jpg");
            -webkit-background-size:;
            background-size:100% auto;;
            color:#fff;
            text-align: center;
            margin-top:50px;
        }
        #section-1 #signupModal{
            color:#777;
            text-align: left;
        }
        #section-1 .col-md-12{
            vertical-align:middle;
            position: ;
        }
        #section-1 h1{
            font-size: 100%;
        }
        @media screen and (min-width: 768px){
            #section-1{
                height:600px;
            }
            #section-1 .col-md-12{
                padding:225px 0px;
            }
            #section-1 h1{
                font-size: 40px;
            }
            #section-1 h3{
                font-size: 25px;
            }
            #section-1 .btn{
                padding:10px 40px;
            }
        }
        @media screen and (max-width: 768px){
            #section-1{
                height:170px;
            }
            #section-1 h1{
                font-size:large;
                position: relative;
            }
            #section-1 h3{
                font-size: small;
            }
            #section-1 .btn{
                padding:5px 10px;
            }
            #feed_container{
                padding:10px 0px;!important;

            }
            #feed{
                margin: 0px;!important;
                padding:0px;!important;
            }
            #feed .h3{
                font-size:small;
            }
            #feed .h4{
                font-size:small;
            }
            #feed #feed_user_pic{
                width:80%;
            }
        }
    </style>
    <script>
        function checkIfUserExists(){
            value=document.getElementById("uname").value;
            $.get("./checkUser.php",{username:value},function(data){
                divAlert = document.getElementById('alert_username');
                if(data=='exists'){
                    divAlert.style.visibility = 'visible';
                    divAlert.innerHTML='Username Already Exists!!!';
                    $('#alert_username').removeClass('alert-success');
                    $('#alert_username').addClass('alert-danger');
                }else if(data=='available'){
                    divAlert.innerHTML="<span class='fa fa-check-circle'></span>";
                    divAlert.style.visibility = 'visible';
                    $('#alert_username').removeClass('alert-danger');
                    $('#alert_username').addClass('alert-success');
                }
            })
        }
    </script>
</head>
<body id="style-1">
    <?php   include "header.php" ?>
    <div class="container-fluid" id="section-1">
      <section class="col-md-12">
          <h1 class="h1">Speak To Learn Different Languages</h1>
          <h3 class="h3">Connect with the native speakers around the world to learn the language you want</h3>
          <button class="btn btn-success" data-toggle="modal" data-target="#signupModal">GET STARTED NOW</button>
      </section>
    </div>
    <div class="container_fluid"style="background-color:#492A8D; padding:20px;" id="feed_container">
        <?php
            $feed=new Feedback();
            $row=$feed->viewFeedback();
            while($res=$row->fetch_assoc()){
                $user=$res['user_id'];
                $feedback_msg=$res['feedback_body'];
                $feedback_title=$res['feedback_title'];
                $feedback_rating=$res['feedback_rating'];
                $user_img=$res['profile_pic'];
                $name=$res['name'];
            ?>
                <div class="container" id="feed" >
                    <div class="text-center col-md-2 col-xs-3">
                        <img src="<?=$user_img;?>" style="width:60%;"class="img-circle" alt="" id="feed_user_pic">
                        <p class="h4" style="color:#fff;"><?=$name;?></p>
                    </div>
                    <div class="col-md-10 col-xs-9">
                        <p class="h3" style="color:#ffff00">
                            <?=$feedback_title;?>
                            <?php
                                for($i=0;$i<$feedback_rating;$i++):
                                ?>
                            <span class="fa fa-star"></span>
                                    <?php endfor; ?>
                        </p>
                        <p class="h4"style="color:#fff"><?=$feedback_msg;?></p>
                    </div>

                </div>
        <?php
            }
        ?>
    </div>

</body>
</html>
<script>
    navhead = document.getElementById("navbar-header");
    navhead.className = "navbar navbar-default navbar-fixed-top no-margin";

</script>