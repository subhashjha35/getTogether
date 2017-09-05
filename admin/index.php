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
		font-size: 60px;
	}
	.panel-footer .fa{
		font-size:16px;
		float: right;
		background: inherit;
		color:inherit;
	}
	.alert{
		margin:0px !important;
		border-radius: 0px;
	}
	.dashbox>div{
		padding: 0px;
		overflow: hidden;
	}
    @media screen and (min-width: 768px) {
        #userListModal .modal-dialog  {width:900px;}
        #left-nav-column{
            margin-bottom:-99999px;
            padding-bottom:99999px;
            overflow:hidden;
        }
    }
	</style>
</head>
<body>
	<?php include_once "adminHeader.php";?>
	<div class="container-fluid" style="padding: 0px !important;">
		<div class="no-margin col-md-2  text-center bg-dark alert-danger" id="left-nav-column">
				<div class="btn-group-vertical col-md-12 alert">
					<a onclick="get_page('index.php')" class="btn btn-danger btn-lg">ADMIN PANEL</a>
					<a onclick="get_page('manage_users.php')" class="btn btn-success btn-lg">Manage Users</a>
					<a onclick="get_page('change_password.php')" class="btn btn-success btn-lg">Change Password</a>
					<a onclick="get_page('statistics.php')" class="btn btn-success btn-lg">Statistics</a>
					<a onclick="get_page('db_list.php')" class="btn btn-success btn-lg">Database List</a>
					<a onclick="get_page('admin_profile.php')" class="btn btn-success btn-lg">Admin Profile</a>
				</div>

		</div>
		<div class="right col-md-10" style="padding: 0px !important;">
			<div class="container-fluid dashbox text-center alert">
				<div class="col-md-2 no-padding btn-success col-md-offset-0 img-rounded">
					<div class="alert">
						<i class="fa fa-bell"></i><span class="tags text-success">45</span>
					</div>
					<div class="panel-footer alert-success alert">
						<a onclick="get_page('db_list.php?tname=post_comments')" class="text-success"><div>View Details <i class="fa fa-arrow-right"></i></div></a>
					</div>
				</div>
				<div class="col-md-2 no-padding btn-warning col-md-offset-1 img-rounded">
					<div class="alert">
						<i class="fa fa-comments"></i><span class="tags text-warning">45</span>
					</div>
					<div class="panel-footer alert-warning alert">
						<a onclick="get_page('feedbacks.php')" href="#" class="text-warning"><div>View Details <i class="fa fa-arrow-right"></i></div></a>
					</div>

				</div>
				<div class="col-md-2 no-padding btn-info col-md-offset-1 img-rounded">
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
					<div class="panel-footer alert-info alert">
						<a onclick="get_page('user_list.php')" href="#" class="text-info"><div>View Details <i class="fa fa-arrow-right"></i></div></a>
					</div>
				</div>
				<div class="col-md-2 no-padding btn-danger col-md-offset-1 img-rounded">
					<div class="alert">
						<i class="fa fa-gear"></i>
					</div>
					<div class="panel-footer alert alert-danger">
						<a href="#" class="text-danger"><div>Admin Settings <i class="fa fa-arrow-right"></i></div></a>
					</div>
				</div>
			</div>
			<div class="container-fluid" id="page_destination">

			</div>
		</div>
	</div>
</body>
</html>
