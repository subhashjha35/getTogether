<?php
    session_start();
    $db=mysqli_connect("localhost","root","123456","gettogether");

    /* For Interests List */
    include("interestsLists.php");
    $iArray =explode("\n", $interestsLists);

    if(isset($_POST['interests'])){
        include("dbController.php");
        $user=new User();
        $user->updateInterests($_POST['interests']);
    }
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <script type="text/javascript" src="./js/jquery-1.8.3.min.js"></script>
    <script type="text/javascript" src="js/jquery.imgareaselect.js"></script>
    <script type="text/javascript" src="./js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/font-awesome.css">
    <link rel="stylesheet" type="text/css" href="css/imgareaselect-default.css" />
    <script>

        /* --------x--------x--------x--------x--------x--------x--------x--------x--------x--------x-------- */

       $(document).ready(function(){

           $('#img_modal').modal('hide');
           image = document.getElementById("modal_user_image");
           originalHeight = document.getElementById("modal_user_image").naturalHeight;
           originalWidth = document.getElementById("modal_user_image").naturalWidth;
          $("#user_image").on("change",function(){
              $("#img_form").submit();
          });
           function getCoordinates(img, selection) {
               if (!selection.width || !selection.height){
                   return;
               }
               // With this two lines i take the proportion between the original size and
               // the resized img
               var porcX = image.naturalWidth / image.width;
               var porcY = image.naturalHeight / image.height;
               // Send the corrected coordinates to some inputs:
               // Math.round to get integer number
               // (selection.x1 * porcX) to correct the coordinate to real size

               console.log("selection x1:"+ selection.x1);
               console.log("selection x2:"+ selection.x2);


               $('input[name="x1"]').val(Math.round((selection.x1)*porcX));
               $('input[name="y1"]').val(Math.round((selection.y1)*porcY));
               $('input[name="x2"]').val(Math.round((selection.x2)*porcY));
               $('input[name="y2"]').val(Math.round((selection.y2)*porcY));
               $('input[name="w"]').val(Math.round((selection.width)*porcY));
               $('input[name="h"]').val(Math.round((selection.height)*porcY));
           }

           // Take the original size from image with naturalHeight - Width


           // Show original size in console to make sure is correct (optional):
           console.log('IMG width: ' + originalWidth + ', heigth: ' + originalHeight);
           console.log('IMG width: ' + image.width + ', heigth: ' + image.height);
           console.log($("input[name='x1']").val());

           // Enable imgAreaSelect on your image

           $('#modal_user_image').imgAreaSelect({ aspectRatio: '1:1', handles: true, x1: 0, y1: 0, x2: 100, y2: 100,
           fadeSpeed: 200,
           imageHeight: originalHeight,
           imageWidth: originalWidth,
           parent:".modal-content",
           onSelectChange: getCoordinates // this function below
           });


       });
    </script>
    <style>
        #image_label{
            position: relative;
        }
        #image_label #add_pic_logo_box{
            position: absolute;
            width:100%;
            /*right:30%;*/
            bottom:20%;
            color:#f8f8f8;
            text-align: center;
            font-size:100%;
            visibility: hidden;
        }
        #image_label:hover #add_pic_logo_box{
            visibility: visible;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <?php include "header.php";
    $username=$_SESSION['username'];
    if(isset($_FILES['user_image'])){
        $dest_orig;
        $file=$_FILES['user_image'];
        $fname=$file['name'];
        $tmp_name=$file['tmp_name'];
        $enc_name=uniqid().$fname;
        $dest_orig="resources/users/$username/avatar_pics/".$enc_name;
        if(move_uploaded_file($tmp_name,$dest_orig)){
            shell_exec("chmod -R 777 resources");
            $db1=mysqli_connect("localhost","root","123456","gettogether");
            $sql="UPDATE `user_profile` SET `profile_pic`='$dest_orig' WHERE `user_id`='$username'";
            if(!mysqli_query($db1,$sql)){
                echo "alert('couldnot update pic')";
                echo mysqli_error($db1);
            }
            else{
                ?>
                <script>
                    $.post("getUserProfilePic.php",{id:"<?=$username;?>"},function(data){
                       $("#modal_user_image").attr("src",data);
                    });
                </script>
                <?php
            }
        }
        ?>

        <script type="text/javascript">
            $('document').ready(function(){
                $('#img_modal').modal('show');
            });
        </script>
    <?php

    }
    else
    { //echo "alert('not yet submitted');";
    }


    if(isset($_POST['x1'])){
        $x1 = $_POST['x1'];
        $y1 = $_POST['y1'];
        $x2 = $_POST['x2'];
        $y2 = $_POST['y2'];
        $h = $_POST['h'];
        $w = $_POST['w'];
        $x1."<br>".$x2."<br>".$y1."<br>".$y2."<br>";
        /*echo $width."<br>".$height;*/
        $db=mysqli_connect("localhost","root","123456","gettogether");
        $sql="select * from user_profile where user_id='$username'";
        $res=mysqli_query($db,$sql);
        $row=mysqli_fetch_assoc($res);
        $src=$row['profile_pic'];


        $img=imagecreatetruecolor(256,256);
        //$dest_img=imagecrop($source_img,['x'=>$x1,'y'=>$y1,'width'=>$w,'height'=>$h]);
        /*$dest1_img=resizeImage($dest_img);*/

        $enc_name=uniqid().$username;
        //header('Content-Type: image/jpeg');
        $image_type=substr($src,-3);

        //echo "<br>image type :".$image_type."<br>";
        $cropped_image_dest = "resources/users/$username/avatar_pics/jpg-256/$enc_name" . ".$image_type";
        /*switch ($image_type) {
            case "jpg":
                $source_img = imagecreatefromjpeg($src);
                break;
            case "png":
                $source_img = imagecreatefrompng($src);
                break;
            case "gif":
                $source_img = imagecreatefromgif($src);
        }*/
        if($image_type=="png"){
            imageAlphaBlending($img, false);
            imageSaveAlpha($img, true);
        }
        $source_img=imagecreatefromstring(file_get_contents($src));

        if($source_img!=FALSE){
            //echo "Here are the imagecopyresampled values :<br> x1:$x1 | y1:$y1 | w:$w | h:$h";
            imagecopyresampled($img,$source_img,0,0,$x1,$y1,256,256,$w,$h);
            switch ($image_type){
                case "jpg":
                {imagejpeg($img, $cropped_image_dest,100); break;}
                case "png":
                {imagepng($img, $cropped_image_dest,0); break;}
                case "gif":
                {imagegif($img, $cropped_image_dest);}
            }

            /*$link= "./resources/users/".$username."/avatar_pics/jpg-256/";
            echo "<a href='".$link."'>open link</a>";*/

            shell_exec("cd resources/users/".$username."/avatar_pics/; sudo chmod -R 777 jpg-256/");
            $db=mysqli_connect("localhost","root","123456","gettogether");
            $sql="UPDATE `user_profile` SET `profile_pic`='$cropped_image_dest' WHERE `user_id`='$username'";
            if(!mysqli_query($db,$sql)){
                echo "alert('couldnot update pic')";
                echo mysqli_error($db);
            }
        }



    }
    ?>

    <div class="container">
        <div class="col-md-6 col-md-offset-3">
            <div class=" panel panel-warning">
                <div class="panel-heading">
                    <h2 class="panel-title">Fill the details</h2>
                </div>
                <div class="panel-body">
                    <div class="text-center">
                        <form action="<?=$_SERVER['PHP_SELF'];?>" method="post" id="img_form" enctype="multipart/form-data">
                            <label for="user_image" id="image_label">
                                <?php
                                    $sql="select * from users,user_profile where user_id='$username' and users.username=user_profile.user_id";
                                    $res=mysqli_query($db,$sql);
                                    $row=mysqli_fetch_assoc($res);
                                    $user_img=$row['profile_pic'];
                                    $name=$row['name'];
                                ?>
                                <img id="user_pic"src="<?=$user_img;?>" style="width:100%; max-width: 400px;" class="img-circle img-responsive img-thumbnail">
                                <div id="add_pic_logo_box">Add a Photo</div>
                            </label>
                            <input type="file" name="user_image" id="user_image" class="hidden" accept=".bmp,.png,.jpg">
                        </form>
                    </div>
                    <div class="text-center">
                        <h2 class="h3"><?=$name;?></h2>
                        <a href="home.php" class="btn btn-warning">Skip To Home</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div id="img_modal" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content" style="position: relative">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">CROP IMAGE</h4>
                    </div>
                    <div class="modal-body">
                        <div class="text-center">
                            <img src="resources/web/images/section-1.jpg" id="modal_user_image" style="max-width:80%; box-sizing:content-box; -moz-box-sizing:content-box; -webkit-box-sizing:content-box;">
                            <form action="<?=$_SERVER['PHP_SELF'];?>" method="post">
                                <input type="hidden" name="x1"/>
                                <input type="hidden" name="y1"/>
                                <input type="hidden" name="x2"/>
                                <input type="hidden" name="y2"/>
                                <input type="hidden" name="w"/>
                                <input type="hidden" name="h"/>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="submit" name="submit" value="Submit" class="btn btn-primary" />
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
