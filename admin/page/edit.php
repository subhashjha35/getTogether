<html>
    <head>
        <script type="text/javascript" src="../../js/jquery-1.8.3.min.js"></script>
        <script type="text/javascript" src="../../js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="../../css/bootstrap.css">
        <link rel="stylesheet" href="../../css/font-awesome.css">
    </head>
    <body>
    <?php
    include "../adminHeader.php";
    include "../adminController.php";
    if(isset($_POST['username'])):
        $uname=$_POST['username'];
        $name=$_POST['name'];
        $email=$_POST['email'];
        $password=$_POST['password'];
        $dob=$_POST['dob'];
        $gender=$_POST['gender'];
        $user=new User();
        $res=$user->updateUserDetails($uname, $name, $email, $password, $dob, $gender);
        if($res):
            ?>
            <script>
                $('document').ready(function(){
                    $('#update_info').removeClass('alert-danger alert-info');
                    $('#update_info').addClass('alert-success');
                    $('#update_info').html("Content Updated Successfully");
                });
            </script>
            <?php
        else:
            ?>
            <script>
                $('document').ready(function(){
                    $('#update_info').removeClass('alert-success alert-info');
                    $('#update_info').addClass('alert-danger');
                    $('#update_info').html("Error Updating Content");
                });
            </script>
    <?php
        endif;
    endif;

    if(isset($_GET['id'])):
        $uname=$_GET['id'];
        $user=new User();
        $eUser=$user->showUsers(array('username'=>$uname));
        $row=mysqli_fetch_assoc($eUser);
        /*print_r($row);*/
        $name=$row['name'];
        $dob=$row['dob'];
        $password=$row['password'];
        $email=$row['email'];
        $gender=$row['gender'];
        ?>
        <div class="container">
            <form action="<?php $_SERVER['PHP_SELF']; ?>" method="post">
                <div class="form-group">
                    <label for="uname">User name</label>
                    <input type="text" name="username" id="uname" class="form-control" onchange="checkIfUserExists()" value="<?=$uname?>">
                </div>
                <div class="form-group">
                    <label for="name">Your Name</label>
                    <input type="text" name="name" id="name" class="form-control" value="<?=$name?>">
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" class="form-control" value="<?=$email?>">
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" class="form-control" value="<?=$password?>">
                </div>
                <div class="form-group">
                    <label for="dob">DOB</label>
                    <input type="date" name="dob" id="dob" class="form-control" value="<?=$dob?>">
                </div>
                <div class="form-group">
                    <label for="gender">Gender</label>
                    <select name="gender" id="gender" class="form-control" value="<?=$gender?>">
                        <option value="f">Female</option>
                        <option value="m">Male</option>
                    </select>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-success">Register Now</button>
                    <button type="reset" class="btn btn-danger">Clear Data</button>
                </div>
                <div class="form-group">
                    <div id="update_info" class="alert alert-info">Make the necessary changes in your Account Details</div>
                </div>
            </form>
        </div>
        <?php
    endif;
    ?>
    </body>
</html>
