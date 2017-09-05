<?php
    if(isset($_POST['username'])):
        include "dbController.php";
        $user=new User();
        $res=$user->deleteUser($_POST['username']);
        if($res):
        ?>
            <table class="table table-bordered table-striped bg-info">
                <tr><th>Username</th><th>Name</th><th>Email</th><th>Action</th></tr>
                <?php
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
                            <a class="btn-success btn btn-xs" href="edit.php?id=<?=$username?>"><span class="fa fa-edit"></a>
                            <a class="btn-danger btn btn-xs" onclick="deleteUser('<?=$username?>')"><span class="fa fa-times"></a>
                            <a class="btn-default btn btn-xs" href="view.php?id=<?=$username?>"><span class="fa fa-eye"></a>
                        </td>
                    </tr>
                <?php
                    endwhile;
                ?>
            </table>
        <?php
            else:
                echo "error found while deleting the data";
            endif;
        endif;
?>