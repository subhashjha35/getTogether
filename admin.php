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
    <style>
        @media screen and (min-width: 768px) {

            #userListModal .modal-dialog  {width:900px;}

        }
    </style>
    <script>
           function deleteUser($id) {
               $.post("deleteUser.php",{username:$id}, function(data){
                   $('#userDetails').html(data);
               });
           }
    </script>
</head>
<body>
    <?php include "header.php" ?>
    <div class="container">
        <div class="text-center">
            <button class="btn btn-default" data-toggle="modal" data-target="#userListModal">User List</button>
        </div>

        <div class="modal" id="userListModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">User List</h4>
                    </div>
                    <div class="modal-body" style="overflow: scroll">
                        <div id="userDetails">
                            <table class="table table-bordered" style="min-width:600px;">
                                <tr><th>Username</th><th>Name</th><th>Email</th><th>Action</th></tr>
                                <?php
                                $user=new User();
                                $all_users=$user->showUsers();
                                while($row=mysqli_fetch_assoc($all_users)):
                                    $username =$row['username'];
                                    $name=$row['name'];
                                    $email=$row['email'];
                                    ?>
                                    <tr>
                                        <td><?=$username?></td>
                                        <td><?=$name?></td>
                                        <td><?=$email?></td>
                                        <td>
                                            <a class="btn-success btn btn-xs" href="edit.php?id=<?=$username?>"><span class="fa fa-pencil"></a>
                                            <a class="btn-danger btn btn-xs" onclick="deleteUser('<?=$username?>')"><span class="fa fa-times"></a>
                                            <a class="btn-default btn btn-xs" href="view.php?id=<?=$username?>"><span class="fa fa-eye"></a>
                                        </td>
                                    </tr>
                                    <?php
                                endwhile;
                                ?>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</body>
</html>
