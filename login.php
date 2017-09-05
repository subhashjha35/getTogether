<?php session_start(); ?>
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
    <?php  include "header.php";
    if(isset($_POST['username'])):
        include "dbController.php";
        $uname=$_POST['username'];
        $pass=$_POST['password'];
        $arr=array(
            'username'=>$uname,
            'password'=>$pass
        );
        $user=new User();
        $res=$user->loginCheck($arr);
        if($res):
            $_SESSION['username']=$uname;
            echo "<script>window.location='home.php';</script>";
        else:
            echo "<script>window.location='login.php?error';</script>";
        endif;
    endif;

    if(isset($_GET['error']))
        echo "<script>alert('Incorrect Login Details');</script>";
?>
<div class="container">
    <form action=""method="post">
        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" name="username" id="username" class="form-control">
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="text" name="password" id="password" class="form-control">
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-success">Login Now</button>
            <button type="reset" class="btn btn-default">Cancel</button>
        </div>
    </form>
</div>
</body>
</html>