<?php
    session_start();
    if(isset($_GET['username'])){
        include "dbController.php";
        $username=$_GET['username'];
        $name=$_GET['name'];
        $dob=$_GET['dob'];
        $email=$_GET['email'];
        $password=$_GET['password'];
        $gender=$_GET['gender'];

        $user=new User();
        $msg=$user->createUser($username, $name, $email, $password, $dob, $gender);
        if($msg=="success"){
            $_SESSION['username']=$username;
            header("location:intermediate-page.php");
        }
        else
            echo "<script>alert('record could not be inserted');</script>".$user->dbase->error;

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
    <script type="text/javascript" src="./js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/font-awesome.css">
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
<body>
<?php   include "header.php"; ?>

<div class="container">
    <form action="">
        <div class="form-group">
            <label for="uname">Choose a User name</label>
            <input type="text" name="username" id="uname" class="form-control" onchange="checkIfUserExists()">
            <span class="" id="alert_username"></span>
        </div>
        <div class="form-group">
            <label for="name">Your Name</label>
            <input type="text" name="name" id="name" class="form-control">
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" class="form-control">
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" name="password" id="password" class="form-control">
        </div>
        <div class="form-group">
            <label for="dob">DOB</label>
            <input type="date" name="dob" id="dob" class="form-control">
        </div>
        <div class="form-group">
            <label for="gender">Gender</label>
            <select name="gender" id="gender" class="form-control">
                <option value="m">Male</option>
                <option value="f">Female</option>
            </select>
        </div>
        <div class="form-group">
            <button type="submint" class="btn btn-success">Register Now</button>
            <button type="reset" class="btn btn-danger">Clear Data</button>
        </div>
        <div class="form-group">
            <span class="" id="alert_username"></span>
        </div>
    </form>
</div>
</body>
</html>