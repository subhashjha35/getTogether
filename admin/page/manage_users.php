<label>Apply Filters:</label>
<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    <i class="fa fa-plus"></i>
</button>
<div class="dropdown-menu" data-toggle="dropdown">
    <a class="btn btn-default" href="#">Action</a>
    <a class="dropdown-item" href="#">Another action</a>
    <a class="dropdown-item" href="#">Something else here</a>
</div>
<form action="" class="">
    <div class="form-group-sm col-md-4">
        <div class="input-group">
            <span class="input-group-addon">
                <input type="checkbox" name="filters" style="position:absolute;top:8px">
                <span style="margin-left:20px">Username</span>
            </span>
            <input type="text" class="form-control">
            <span class="input-group-btn">
                <a class="alert-danger btn btn-sm"><i class="fa fa-close"></i></a>
            </span>
        </div>
    </div>
    <div class="form-group-sm col-md-4">
        <div class="input-group">
            <span class="input-group-addon">
                <input type="checkbox" name="filters" style="position:absolute;top:8px">
                <span style="margin-left:20px">Name</span>
            </span>
            <input type="text" class="form-control">
            <span class="input-group-btn">
                <a class="alert-danger btn btn-sm"><i class="fa fa-close"></i></a>
            </span>
        </div>
    </div>
    <div class="form-group-sm col-md-4">
        <div class="input-group">
            <span class="input-group-addon">
                <input type="checkbox" name="filters" style="position:absolute;top:8px">
                <span style="margin-left:20px">Email</span>
            </span>
            <input type="text" class="form-control">
            <span class="input-group-btn">
                <a class="alert-danger btn btn-sm"><i class="fa fa-close"></i></a>
            </span>
        </div>
    </div>
    <hr><hr>
    <div class="col-md-12">
        <button type="submit" class="btn btn-success">Search Records <i class="fa fa-search-plus"></i></button>
    </div>
</form>
<div class="col-md-12" id="resultCounter">
    24 results found
</div>
<div class="" id="">
    <table class="table table-bordered table-striped">
        <tr class="alert-info"><th>Username</th><th>Name</th><th>Email</th><th>Action</th></tr>
        <?php
        include "adminController.php";
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
                    <a class="btn-success btn btn-xs" href="page/edit.php?id=<?=$username?>"><span class="fa fa-pencil"></a>
                    <a class="btn-danger btn btn-xs" onclick="deleteUser('<?=$username?>')"><span class="fa fa-times"></a>
                    <a class="btn-default btn btn-xs" href="view.php?id=<?=$username?>"><span class="fa fa-eye"></a>
                </td>
            </tr>
            <?php
        endwhile;
        ?>
    </table>
</div>