<?php 
	include_once("dbController.php");

 ?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/font-awesome.min.css">
	<meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=no">
    <script type="text/javascript" src="../js/jquery-1.8.3.min.js"></script>
    <script type="text/javascript" src="../js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="../css/font-awesome.min.css">

	<style type="text/css">
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
	</style>
</head>
<body>
	<?php include_once "adminHeader.php";?>
	<div class="container-fluid" style="padding: 0px !important;">
		<div class="no-margin col-md-2  text-center bg-dark alert-danger">
				<div class="btn-group-vertical col-md-12 alert">
					<button class="btn btn-danger btn-lg">ADMIN PANEL</button>
					<button class="btn btn-success btn-lg">Manage Users</button>
					<button class="btn btn-success btn-lg">Change Passwords</button>
					<button class="btn btn-success btn-lg">Statistics</button>
					<button class="btn btn-success btn-lg">Database List</button>
					<button class="btn btn-success btn-lg">Admin Users</button>
				</div>
			</nav>
		</div>
		<div class="right col-md-10" style="padding: 0px !important;">
			<div class="container-fluid dashbox text-center alert">
				<div class="col-md-2 no-padding btn-success col-md-offset-0 img-rounded">
					<div class="alert">
						<i class="fa fa-bell"></i><span class="tags text-success">45</span>
					</div>
					<div class="panel-footer alert-success alert">
						<a href="#" class="text-success"><div>View Details <i class="fa fa-arrow-right"></i></div></a>
					</div>
				</div>
				<div class="col-md-2 no-padding btn-warning col-md-offset-1 img-rounded">
					<div class="alert">
						<i class="fa fa-comments"></i><span class="tags text-warning">45</span>
					</div>
					<div class="panel-footer alert-warning alert">
						<a href="#" class="text-warning"><div>View Details <i class="fa fa-arrow-right"></i></div></a>
					</div>

				</div>
				<div class="col-md-2 no-padding btn-info col-md-offset-1 img-rounded">
					<div class="alert">
						<i class="fa fa-users"></i>
						<span class="tags text-info">
							<?php 
								$sql="select id from `userProfile`";
								global $db;echo mysqli_num_rows(mysqli_query($db,$sql));
							?>
						</span>
					</div>
					<div class="panel-footer alert-info alert">
						<a href="#" class="text-info"><div>View Details <i class="fa fa-arrow-right"></i></div></a>	
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
			<div class="container-fluid">
				<table class="table table-bordered table-responsive table-striped table-hover bg-success col-md-10">
					<?php 
						$sql="select * from userProfile";
						$result=mysqli_query($db,$sql);
						while($row=mysqli_fetch_assoc($result)){
							?>
							<tr>
								<td><?php echo $row['name']; ?></td>
								<td><?php echo $row['email']; ?></td>
								<td><?php echo $row['natLan']; ?></td>
								<td><?php echo $row['interest_list']; ?></td>
							</tr>
							<?php
						}
					?>
				</table>
			</div>
				<div class="container-fluid">
					<?php
						function get_tables()
						{
							global $db;
							$tableList = array();
							$res=mysqli_query($db,"SHOW TABLES");

							while($cRow = mysqli_fetch_array($res))
							{
								$tableList[] = $cRow[0];
							}
							return $tableList;
						}
						function table_structures(){
							global $db;
							$table_name=get_tables();
							foreach($table_name as $tname){
								echo "<br><strong>".$tname." :</strong><br>";
								$sql="describe $tname";
								$res=mysqli_query($db, $sql);
								echo "<table class='table table-bordered table-striped'>";
								while($row=mysqli_fetch_array($res)){
									echo "<tr>";
                                    echo "<td width='30%'>".$row['0']."</td>";
                                    echo "<td width='30%'>".$row['1']."</td>";
                                    echo "<td width='20%'>".$row['3']."</td>";
                                    echo "</tr>";
								}
								echo "</table>";
							}
						}
						$tablesList=get_tables();
						foreach($tablesList as $tab){
							?>
							<div class="col-md-4 col-md-offset-1 img-rounded">
								<div class="alert-danger alert text-center">
									<?php echo strtoupper($tab); ?>
								</div>
							</div>
							<?php
								}
					 	?>
			</div>
			<div>
				<?php 
					global $db;
					if(isset($_GET['tname'])){
						?>
						<table class="table table-responsive table-bordered table-striped"><tr>
						<?php
						$tname=$_GET['tname'];
						$sql="describe $tname";
						$arr=array();
						$res=mysqli_query($db,$sql);
						while($row=mysqli_fetch_array($res)){
						$arr[]=$row["0"];
							?>
							<th><?php echo $row["0"]; ?></th>
							<?php
						}
						?>
						</tr>
						<?php
						$sql="select * from $tname limit 200";
						$result=mysqli_query($db,$sql);
						while($row=mysqli_fetch_array($result)){
							echo "<tr>";
							foreach($arr as $a){
							?>
							<td><?php echo $row[$a] ?></td>
							<?php
							}
							echo "</tr>";
						}
					}
				?>
			</div>
							<?php table_structures($tablesList); ?>
		</div>
	</div>
</body>
</html>