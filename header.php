<?php
include_once "dbController.php";
if(isset($_GET['signup'])){
    echo $username=$_GET['username'];
    echo $name=$_GET['name'];
    echo $dob=$_GET['dob'];
    $email=$_GET['email'];
    $password=$_GET['password'];
    $gender=$_GET['gender'];

    $user=new User();
    $msg=$user->createUser($username, $name, $email, $password, $dob, $gender);
    if($msg=="success"){
        $_SESSION['username']=$username;
        header("location:intermediate.php");
    }
    else
        echo "<script>alert('record could not be inserted');</script>".$user->dbase->error;

}

if(isset($_POST['login'])):
    $user=new User();
    $uname=htmlspecialchars(mysqli_real_escape_string($user->dbase,$_POST['username']));
    $pass=htmlspecialchars(mysqli_real_escape_string($user->dbase,$_POST['password']));
    $arr=array(
        'username'=>$uname,
        'password'=>$pass
    );
    $res=$user->loginCheck($arr);
    if($res):
        $_SESSION['username']=$uname;
        echo "<script>window.location='home.php';</script>";
    else:
        echo "<script>window.location='index.php?error';</script>";
    endif;
endif;

if(isset($_GET['error']))
    echo "<script>alert('Incorrect Login Details');</script>";
?>

<style>

    body::-webkit-scrollbar-track
    {
        box-shadow: inset 0 0 6px rgba(0,0,0,.3);
        border-radius: 10px;
        background-color: #F5F5F5;
    }

    body::-webkit-scrollbar
    {
        width: 12px;
        background-color: #F5F5F5;
    }

    body::-webkit-scrollbar-thumb
    {
        border-radius: 10px;
        box-shadow: inset 0 0 6px rgba(255, 103, 11, 0.53);
        background-color: rgba(255, 103, 11, 0.53);
    }
    .no-margin{
        margin:0px;!important;
    }
    .no-padding{
        padding:0px;!important;
    }
    .nav-profile-img{
        height: 26px;!important;
        background-color: #fff;
        border-radius:14px;
        border:1px solid #ccc;
        box-sizing: border-box;
    }
    header #right-nav a{
        padding-top:12px;!important;
        padding-bottom: 12px;!important;
    }
    header #right-nav  .fa{
        font-size:26px;!important;
    }
    header #right-nav .dropdown-menu .fa{
        font-size: 14px;!important;
        border-radius:14px;
        background-color: #000;
        padding:4px;
        color:#fff;
    }
    @media screen and (max-width: 768px){
        header #right-nav ul{
            margin:0px;!important;
            padding: 0px;!important;
        }
        header #right-nav>li, #right-nav>li a{
            width:24%;!important;
            text-align: center;
            vertical-align: middle;
            display: inline-block;!important;
            padding:0px auto;!important;
            box-sizing: border-box;
            margin:0px;
        }
        header #myNavbar{
            overflow: visible;
        }
        header #right-nav>li{
            position:relative;
        }

        header #right-nav li #d-down{
            background: #fff;
            overflow: visible;
            position: absolute;
            border:1px solid #e7e7e7;
            left:-70px;!important;
            top:58px;
        }
        header #right-nav li #d-down-req{
            background: #fff;
            overflow: visible;
            position: absolute;
            border:1px solid #e7e7e7;
            left:0px;!important;
            top:58px;
        }
        header #right-nav li>ul>li{

        }

        header #searchGroup{
            display: none;
        }
}
@media screen and (min-width: 768px){
    header .nav_label{
       display: none;
    }
    header #searchBar{
        width: 320px;
        float: right;!important;
    }


}
</style>
<header>
    <nav class="navbar navbar-default navbar-static-top no-margin" id="navbar-header">
        <div class="container">

            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a href="<?php if(isset($_SESSION['username'])) echo "home.php"; else echo "index.php";?>"><span class="navbar-brand"><span style="color:#EE5607;">Get</span><span>Together</span></span></a>
            </div>

            <!--<form action="" class="navbar-form navbar-left" id="searchGroup">
                <div class="input-group">
                    <input type="text" class="form-control"id="searchBar">
                    <div class="input-group-btn">
                        <button type="submit" class="btn btn-default"><span class="fa fa-search"></span></button>
                    </div>
                </div>
            </form>-->

            <div class="collapse navbar-collapse" id="myNavbar">
                <?php
                if(isset($_SESSION['username'])){ ?>
                    <ul class="nav navbar-nav navbar-right" id="right-nav">
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-user-plus"></i>
                            </a>
                            <ul class="dropdown-menu" id="d-down-req">
                                <?php
                                $user=$_SESSION['username'];
                                $not=new Notification();
                                $res=$not->showRequestNotification($user,5);
                                if(!$res){
                                    ?>
                                    <li><a href="#">No new Notification</a></li>
                                    <?php
                                }
                                else {
                                foreach($res as $row){
                                $name=$row['name'];
                                $profile_pic=$row['profile_pic'];
                                ?>
                                <li><a href="#"><img src="<?=$profile_pic;?>" alt="" height="30px"> <?=$name;?> wants to be your friend <span class="fa fa-check"></span> <span class="fa fa-times"></span></span></a></li>
                                <?php  } } ?>
                            </ul>
                        </li>
                        <li><a href="#"><span class="fa fa-bell"></span></a></li>
                        <li><a href="messages.php"><span class="fa fa-comments"></span></a></li>
                        <li class="dropdown">
                            <?php
                    		$db=mysqli_connect(HOST,USER,PASSWORD,DATABASE);
                            $username=$_SESSION['username'];
                            $sql="select * from user_profile where user_id='$username'";
                            $query=mysqli_query($db,$sql);
                            $row=mysqli_fetch_assoc($query);
                            $pic=$row['profile_pic'];
                            ?>
                            <a href="#" data-toggle="dropdown" class="dropdown-toggle"><img src="<?=$pic;?>" class="nav-profile-img" alt=""></a>
                            <ul class="dropdown-menu" id="d-down">
                                <li><a href="my_profile.php"><i class="fa fa-user"></i> My Profile</a></li>
                                <li><a href="logout.php"><i class="fa fa-power-off"></i> Logout</a></li>
                            </ul>
                        </li>
                    </ul>
                <?php } else { ?>
                <ul class="nav navbar-nav">
                    <li><a href="index.php"><span class="fa fa-home" style="font-size:18px;"></span> Home</a></li>
                    <li><a href="feedback.php"><span class="fa fa-comment" style="font-size:18px;"></span>Write Feedback</a></li>
                    <!--<li><a href="admin.php" class="padding: 0px !important; "><span class="fa fa-user" style="font-size:18px;"></span> Admin</a></li>-->
                </ul>

                <ul class="nav navbar-nav navbar-right">
                    <li><a href="" data-toggle="modal" data-target="#signupModal"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>
                    <li><a href="" data-toggle="modal" data-target="#loginModal"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
                </ul>
                <?php } ?>
            </div>
        </div>
    </nav>
    <div class="modal" id="loginModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Login Now</h4>
                </div>
                <div class="modal-body">
                    <form action="<?=$_SERVER['PHP_SELF'];?>" method="post">
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
                        <input type="hidden" name="login">
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal" id="signupModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Sign up Now</h4>
                </div>
                <div class="modal-body">
                    <form action="index.php" method="get">
                        <div class="form-group">
                            <label for="uname">Choose a User name</label>
                            <input type="text" name="username" id="uname" class="form-control" onchange="checkIfUserExists()">
                            <span id="alert_username"></span>
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
                            <button type="submit" class="btn btn-success">Register Now</button>
                            <button type="reset" class="btn btn-danger">Clear Data</button>
                        </div>
                        <input type="hidden" name="signup">
                    </form>
                </div>
            </div>
        </div>
    </div>
</header>
