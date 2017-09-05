<?php
include("adminController.php");
?>

<!DOCTYPE html>
<html>
<head>
    <title></title>
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="../css/font-awesome.min.css">
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=no">
    <script type="text/javascript" src="../js/jquery.min.js"></script>
    <script type="text/javascript" src="../js/bootstrap.js"></script>
    <script>
        function get_page(name){
            $.get('get_page.php',{page_id:name},function(data){
                $("#page_destination").html(data);
            });
        }

        function get_table(name){
            $("#page_destination").html("<center style='padding-top:100px;'><img src='../resources/images/spinner.gif' alt=''></center>");
            $.get('page/db_list.php',{tname:name},function(data){
                $("#page_destination").html(data);
            });
        }

    </script>

    <style type="text/css">
        /*.rotate{
            animation-name:a1;
            animation-delay:0.2s;
            animation-style:

        }
        animation a1{
            0%{

            }
            100%{

            }
        }*/
        .jumbotron{
            margin-bottom: 0px !important;
        }
        .navbar{
            margin-bottom: 0px !important;
        }
        .no-margin{
            margin:0px;
        }
        .no-padding{
            padding:0px;
        }
        .tags{
            position: absolute;
            top:5px;
            right: 5px;
            background:#fff;
            border-radius: 5px;
            display: inline-block;
            padding:0px 5px;
        }
        .tags p{
            /*		vertical-align: middle;
            */	}
        .dashbox .fa{
            font-size: 40px;
        }
        .panel-footer .fa{
            font-size:16px;
            float: right;
            background: inherit;
            color:inherit;
        }
        .dashbox .row .alert{
            margin:0px !important;
            border-radius: 0px;
            padding: 10px;
            text-align: center;
        }
        .dashbox>div{
            padding: 0px;
            overflow: hidden;
        }
        @media screen and (min-width: 768px) {
            #userListModal .modal-dialog  {width:900px;}
            #left-nav-column{
                padding-bottom:99999px;
                margin-bottom: -99999px;
                overflow:hidden;
            }
        }

    </style>
</head>
<body>
<?php include_once "adminHeader.php";?>
<div class="container-fluid" style="padding: 0px !important;">
    <div class="no-padding col-md-2 col-sm-12 text-center bg-dark alert-danger" id="left-nav-column">
        <div class="btn-group-vertical col-md-12 col-sm-6 col-xs-6 alert">
            <a href="#" class="btn btn-warning col-sm-6 col-xs-6" style="padding:5px;!important;"><img src="../resources/users/subhashjha35/avatar_pics/58db5c2dc5732sub.jpg" style="width:100%;background-color: black;"></a>
        </div>
        <div class="btn-group-vertical col-md-12 col-sm-6 col-xs-6 alert">
            <a onclick="get_page('index')" class="btn btn-danger btn-lg">ADMIN PANEL</a>
            <div class="container-fluid dashbox text-center" style="border-radius: 0 0px 10px 10px;overflow:hidden;">
                <div class="row">
                    <div class="no-padding btn-success col-md-6 col-xs-6 col-sm-6">
                        <div class="alert">
                            <i class="fa fa-bell"></i><span class="tags text-success">45</span>
                        </div>
                    </div>
                    <div class="no-padding btn-warning col-md-6 col-xs-6 col-sm-6">
                        <div class="alert">
                            <i class="fa fa-comments"></i><span class="tags text-warning">45</span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="no-padding btn-info col-md-6 col-xs-6 col-sm-6">
                        <div class="alert">
                            <i class="fa fa-users"></i>
                            <span class="tags text-info">
							<?php
                            $user=new User();
                            $res=$user->showUsers();
                            echo mysqli_num_rows($res);
                            ?>
						</span>
                        </div>
                    </div>
                    <div class="no-padding btn-danger col-md-6 col-xs-6 col-sm-6">
                        <div class="alert">
                            <i class="fa fa-gear"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="">
                <div class="text-left no-margin text-success" style="overflow:hidden;border-radius:3px;margin:5px 0px;padding:0px;background-color: #fff;">
                    <span class="bg-success text-center" style="min-width:35px;display: inline-block;padding:7px">
                        <i class="fa fa-bell"></i>
                    </span>
                    <span style="padding:7px 10px;">Notifications</span>
                    <span style="float:right;padding:7px 10px;">45</span>
                </div>
                <div class="text-left no-margin text-warning" style="overflow:hidden;border-radius:3px;margin:5px 0px;padding:0px;background-color: #fff;">
                    <span class="bg-warning text-center" style="min-width:35px;display: inline-block;padding:7px">
                        <i class="fa fa-comments"></i>
                    </span>
                    <span style="padding:5px 10px;">Messages</span>
                    <span style="float:right;padding:7px 10px;">45</span>
                </div>
                <div class="text-left no-margin text-info" style="overflow:hidden;border-radius:3px;margin:5px 0px;padding:0px;background-color: #fff;">
                    <span class="bg-info text-center" style="min-width:35px;display: inline-block;padding:7px">
                        <i class="fa fa-users"></i>
                    </span>
                    <span style="padding:5px 10px;">Users</span>
                    <span style="float:right;padding:7px 10px;">45</span>
                </div>
                <div class="text-left no-margin text-danger" style="overflow:hidden;border-radius:3px;margin:5px 0px;padding:0px;background-color: #fff;">
                    <span class="bg-danger text-center" style="min-width:35px;display: inline-block;padding:7px">
                        <i class="fa fa-gear"></i>
                    </span>
                    <span style="padding:5px 10px;">Settings</span>
                    <span style="float:right;padding:7px 10px;">45</span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-10">
        <div class="jumbotron alert-warning" style="border-radius: 0px;padding:10px 20px;!important;">
            <h2>Welcome Subhash Jha</h2>
            <p>Change your settings as required</p>
        </div>
        <div class="row">
            <div class="col-md-9">
                <div class="container-fluid">

                    <ul class="nav nav-tabs" style="margin:10px 0">
                        <li class="active"><a data-toggle="tab" href="#home">Personal Detail</a></li>
                        <li><a data-toggle="tab" href="#menu1">Contact Details</a></li>
                        <li><a data-toggle="tab" href="#menu2">Change Password</a></li>
                    </ul>

                    <div class="tab-content">
                        <div id="home" class="tab-pane fade in active">
                            <form action="#" style="">
                                <h4>Update Personal Details</h4>
                                <div class="form-group-sm">
                                    <label for="">Name</label>
                                    <input type="text" class="form-control alert-warning">
                                </div>

                                <div class="form-group-sm">
                                    <label for="">Company's Name</label>
                                    <input type="text" class="form-control alert-warning">
                                </div>
                                <div class="form-group-sm">
                                    <label for="">Gender</label><br>
                                    <input type="radio" name="gender" id="male"> <label for="male">Male</label>
                                    <input type="radio" name="gender" id="female"> <label for="female">Female</label>
                                </div>
                                <div class="form-group-sm">
                                    <label for="">Date Of Birth</label>
                                    <input type="date" class="form-control alert-warning">
                                </div>

                                <div class="form-group">
                                    <label for=""></label><br>
                                    <button class="btn btn-sm btn-warning">Submit Details</button>
                                    <button class="btn btn-default btn-sm" type="reset">Reset Details</button>
                                </div>

                            </form>
                        </div>
                        <div id="menu1" class="tab-pane fade">
                            <form action="">
                                <div class="form-group-sm">
                                    <label for="">Email</label>
                                    <input type="text" class="form-control alert-warning">
                                </div>
                                <div class="form-group-sm">
                                    <label for="">Contact No.</label>
                                    <input type="number" class="form-control alert-warning">
                                </div>
                                <div class="form-group-sm">
                                    <label for="">Address</label>
                                    <textarea class="form-control alert-warning"></textarea>
                                </div>
                                <div class="form-group">
                                    <label for=""></label><br>
                                    <button class="btn btn-sm btn-warning">Submit Details</button>
                                    <button class="btn btn-default btn-sm" type="reset">Reset Details</button>
                                </div>
                            </form>
                        </div>
                        <div id="menu2" class="tab-pane fade">
                            <form action="#" class="">
                                <h4>Change Your Password Here</h4>
                                <div class="form-group-sm">
                                    <label for="">Current Password</label>
                                    <input type="text" class="form-control alert-warning">
                                </div>
                                <div class="form-group-sm">
                                    <label for="">New Password</label>
                                    <input type="text" class="form-control alert-warning">
                                </div>
                                <div class="form-group-sm">
                                    <label for="">Re-type New Password</label>
                                    <input type="text" class="form-control alert-warning">
                                </div>
                                <div class="form-group">
                                    <label for=""> </label><br>
                                    <button class="btn btn-sm btn-warning">Submit Details</button>
                                    <button class="btn btn-default btn-sm" type="reset">Reset Details</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="">
                    <div class="text-left no-margin text-success" style="border:1px solid;overflow:hidden;border-radius:3px;margin:5px 0px;padding:0px;background-color: #fff;">
                    <span class="bg-success text-center" style="min-width:35px;display: inline-block;padding:7px">
                        <i class="fa fa-bell"></i>
                    </span>
                        <span style="padding:7px 10px;">Notifications</span>
                        <span style="float:right;padding:7px 10px;">45</span>
                    </div>
                    <div class="text-left no-margin text-warning" style="border:1px solid;overflow:hidden;border-radius:3px;margin:5px 0px;padding:0px;background-color: #fff;">
                    <span class="bg-warning text-center" style="min-width:35px;display: inline-block;padding:7px">
                        <i class="fa fa-comments"></i>
                    </span>
                        <span style="padding:5px 10px;">Messages</span>
                        <span style="float:right;padding:7px 10px;">45</span>
                    </div>
                    <div class="text-left no-margin text-info" style="border:1px solid;border:1px solid;overflow:hidden;border-radius:3px;margin:5px 0px;padding:0px;background-color: #fff;">
                    <span class="bg-info text-center" style="min-width:35px;display: inline-block;padding:7px">
                        <i class="fa fa-users"></i>
                    </span>
                        <span style="padding:5px 10px;">Users</span>
                        <span style="float:right;padding:7px 10px;">45</span>
                    </div>
                    <div class="text-left no-margin text-danger" style="border:1px solid;overflow:hidden;border-radius:3px;margin:5px 0px;padding:0px;background-color: #fff;">
                    <span class="bg-danger text-center" style="min-width:35px;display: inline-block;padding:7px">
                        <i class="fa fa-gear"></i>
                    </span>
                        <span style="padding:5px 10px;">Settings</span>
                        <span style="float:right;padding:7px 10px;">45</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

</body>
</html>
