<?php
include "dbController.php";

if(isset($_GET['country'])){
    $loc=new Location();
    $res=$loc->getState($_GET['country']);
    $user=new User();
    $res_user=$user->showUserProfile($_SESSION['username']);
    $row_user=$res_user->fetch_assoc();
    while($row=$res->fetch_assoc()):
        ?>
        <option value="<?=$row['id'];?>" <?php if($row['id']==$row_user['state_id']) echo "selected";?>><?=$row['name'];?></option>
        <?php
    endwhile;
}

if(isset($_GET['state'])) {
    $loc = new Location();
    $res = $loc->getCity($_GET['state']);
    while ($row = $res->fetch_assoc()):
        ?>
        <option value="<?= $row['id']; ?>"><?= $row['name']; ?></option>
        <?php
    endwhile;
}
?>


