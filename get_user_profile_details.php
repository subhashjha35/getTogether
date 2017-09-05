<?php
    if(isset($_GET['user']))
    {
        $user=$_GET['user'];
        $db=mysqli_connect("localhost","root","123456","gettogether");
        $sql="select * from users,user_profile where users.username='$user' and users.username=user_profile.user_id";
        $res=mysqli_query($db,$sql);
        $row=mysqli_fetch_assoc($res);
        $name=$row['name'];
        $biography=$row['biography'];
        $state_id=$row['state_id'];
        $country_id=$row['country_id'];
        $profile_pic=$row['profile_pic'];
        $interests=explode(", ",$row['interests']);
        $natLan=explode(", ",$row['native_lan']);
        $learnLan=explode(", ",$row['learn_lan']);

        $sql="SELECT * FROM countries where id='$country_id'";
        $res=mysqli_query($db,$sql);
        $row=mysqli_fetch_assoc($res);
        $ctr=$row['name'];
        $sql="SELECT * FROM states where id='$state_id'";
        $res=mysqli_query($db,$sql);
        $row=mysqli_fetch_assoc($res);
        $sta=$row['name'];


?>
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><?=$name;?> ( <?=$user;?> )</h4>
    </div>
    <div class="modal-body">
        <div class="container-fluid">
            <div class="col-md-6">
                <section class="col-md-6">
                    <img src="<?=$profile_pic;?>" id="" class="img-circle img-responsive" style="box-sizing:content-box;">
                </section>
                <section class="col-md-6">
                    <strong>Lives in : </strong>
                    <span><?=$sta;?>,</span>
                    <strong><?=$ctr;?></strong>

                </section>
            </div>
            <div class="col-md-6">
                <div><strong>About Me</strong></div>
                <div><?=$biography;?></div>
            </div>
            <hr class="divider">
            <div class="col-md-6">
                <strong>Languages Known :</strong><br>
                <div>
                    <div><strong>Native:</strong></div>
                    <?php   foreach($natLan as $nat){ ?>
                        <span class="alert alert-success interests"><?=($nat)?$nat:"none";?></span>
                    <?php } ?>
                    <div><strong>Learning:</strong></div>
                    <?php   foreach($learnLan as $learn){ ?>
                        <span class="alert alert-success interests"><?=($learn)?$learn:"none";?></span>
                    <?php } ?>
                </div>
            </div>
            <div class="col-md-6">
                <strong>Topics of Interest :</strong><br>
                <div>
                    <?php   foreach($interests as $int){ ?>
                    <span class="alert alert-success interests"><?=($int)?$int:"none";?></span>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
<?php }
?>
