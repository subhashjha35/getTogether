<?php  session_start(); ?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <script type="text/javascript" src="./js/jquery-1.8.3.min.js"></script>
    <script type="text/javascript" src="./js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/font-awesome.css">
</head>
<body>
<?php

    if (isset($_POST['feedback_rating'])){
        include "dbController.php";
        $username=$_POST['username'];
        $ftitle=$_POST['feedback_title'];
        $fbody=$_POST['feedback_body'];
        $frating=$_POST['feedback_rating'];
        $feed=new Feedback();
        $createFeed=$feed->createFeedback($username,$ftitle,$fbody,$frating);
        if($createFeed):
            ?>
            <script>
                alert("record inserted");
                $("document").ready(function(){
                    $('#update_info').removeClass('alert-danger alert-info');
                    $('#update_info').addClass('alert-success');
                    $('#update_info').html("Content Updated Successfully");
                });
            </script>
            <?php
        else:
            ?>
            <script>
                alert("record couldnot be inserted");
                $('document').ready(function(){
                    $('#update_info').removeClass('alert-success alert-info');
                    $('#update_info').addClass('alert-danger');
                    $('#update_info').html("Error Updating Content");
                });
            </script>
            <?php
        endif;

    }
?>


    <div class="container">
        <div class="text-center">
            <h2>Feedback Form</h2>
        </div>

            <form action=""method="post">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" class="form-control" name="username">
                </div>
                <div class="form-group">
                    <label for="username">Title</label>
                    <input type="text" class="form-control" name="feedback_title">
                </div>
                <div class="form-group">
                    <label for="username">Feedback Body</label>
                    <input type="text" class="form-control" name="feedback_body">
                </div>
                <div class="form-group">
                    <label for="username">Rate our website</label>
                    <input type="text" class="form-control" name="feedback_rating">
                </div>
                <div class="form-group">
                    <button class="btn btn-primary" type="submit">Submit your Feedback</button>
                </div>
                <div id="update_info" class="alert">Status</div>
            </form>
        </div>
    </div>
</body>
</html>
