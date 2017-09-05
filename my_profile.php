<?php
/**
 * Created by PhpStorm.
 * User: subhash
 * Date: 9/3/17
 * Time: 4:31 AM
 */
session_start();
    include "interestsLists.php";
    include_once "dbController.php";
    $iArray =explode("\n", $interestsLists);
    if(isset($_POST['interests'])){
        $user=new User();
        $user->updateInterests($_POST['interests']);
    }

    if(isset($_POST['location'])){
        $user=new User();
        $user->updateUserProfile(array("country_id"=>$_POST['country'],"state_id"=>$_POST['state']),$_SESSION['username']);
    }
    if(isset($_POST['biography'])){
        $user=new User();
        $bio=mysqli_real_escape_string($user->dbase,$_POST['biography']);
        $user->updateUserProfile(array("biography"=>$bio),$_SESSION['username']);
    }

    if(isset($_POST['learn_lan'])){
        $learn=$_POST['learn_lan'];
        $native=$_POST['native_lan'];
        $user=new User();
        $user->updateUserProfile(array("learn_lan"=>$learn,"native_lan"=>$native),$_SESSION['username']);
    }
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script type="text/javascript" src="./js/jquery-1.8.3.min.js"></script>
    <script type="text/javascript" src="./js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <title>Profile Page - GetTogether</title>

    <!--- For setting the online status of the User --->

    <script>

        var intArray=new Array();
        var natLanArray=new Array();
        var learnLanArray=new Array();
        $(document).ready(function(){
            if($("#country").val()!=-1){
                $ctr=$("#country").val();
                $.get("get_location.php",{country:$ctr},function(data){
                    $("#state").html(data);
                });


            }
            <?php
            $user=new User();
            $result=$user->showUserProfile($_SESSION['username']);

            if($result->num_rows){
                while($row=$result->fetch_assoc()){
                    $interests=$row['interests'];
                    $interests=explode(", ",$interests);
                    $nLan=$row['native_lan'];
                    $natLan=explode(", ",$nLan);
                    $learnLan=$row['learn_lan'];
                    $learnLan=explode(", ",$learnLan);
                }
                foreach($interests as $int){
                    if($int!=""){
                        ?>
                        var d1=document.createElement("div");
                        d1.innerHTML="<?php echo $int; ?>";
                        intArray.push("<?php echo $int; ?>");
                        d1.setAttribute("id","<?php echo $int; ?>"+"box");
                        d1.setAttribute("class", "alert alert-success");
                        d1.setAttribute("style", "display:inline-block; margin:2px; padding:5px;");
                        document.querySelector("#intDiv").appendChild(d1);
                        var a1=document.createElement("a");
                        a1.setAttribute("id","<?php echo $int; ?>");
                        a1.setAttribute("onclick","popArray(this.id,intArray)");
                        d1.appendChild(a1);
                        var i1=document.createElement("i");
                        i1.setAttribute("class","text-success remove glyphicon glyphicon-remove-sign glyphicon-white");
                        i1.setAttribute("style","margin-left: 5px;vertical-align:middle;");
                        a1.appendChild(i1);
                    <?php
                    }
            }

                foreach($natLan as $nat){

                    if ($nat!=""){ ?>
                        var d1=document.createElement("div");
                        d1.innerHTML="<?php echo $nat; ?>";
                        natLanArray.push("<?php echo $nat;?>");
                        console.log(natLanArray);
                        d1.setAttribute("id","<?php echo $nat; ?>"+"box");
                        d1.setAttribute("class", "alert alert-success");
                        d1.setAttribute("style", "display:inline-block; margin:2px; padding:5px;");
                        document.querySelector("#natLanDiv").appendChild(d1);
                        var a1=document.createElement("a");
                        a1.setAttribute("id","<?php echo $nat; ?>");
                        a1.setAttribute("onclick","popArray(this.id,natLanArray)");
                        d1.appendChild(a1);
                        var i1=document.createElement("i");
                        i1.setAttribute("class","text-success remove glyphicon glyphicon-remove-sign glyphicon-white");
                        i1.setAttribute("style","margin-left: 5px;vertical-align:middle;");
                        a1.appendChild(i1);
                    <?php
                    }
                }
                foreach($learnLan as $learn){

                    if($learn!=""){ ?>
                        var d1=document.createElement("div");
                        d1.innerHTML="<?php echo $learn; ?>";
                        learnLanArray.push("<?php echo $learn;?>");
                        console.log(natLanArray);
                        d1.setAttribute("id","<?php echo $learn; ?>"+"box");
                        d1.setAttribute("class", "alert alert-success");
                        d1.setAttribute("style", "display:inline-block; margin:2px; padding:5px;");
                        document.querySelector("#learnLanDiv").appendChild(d1);
                        var a1=document.createElement("a");
                        a1.setAttribute("id","<?php echo $learn; ?>");
                        a1.setAttribute("onclick","popArray(this.id,learnLanArray)");
                        d1.appendChild(a1);
                        var i1=document.createElement("i");
                        i1.setAttribute("class","text-success remove glyphicon glyphicon-remove-sign glyphicon-white");
                        i1.setAttribute("style","margin-left: 5px;vertical-align:middle;");
                        a1.appendChild(i1);
                    <?php
                    }
                }
            }

            ?>
            $("#interests").on('input', function () {
                var val = this.value;
                if($('#ilist option').filter(function(){
                        return this.value === val;
                    }).length) {
                    if(val){
                        /*alert(val);*/
                        var d1=document.createElement("div");
                        d1.innerHTML=val;
                        d1.setAttribute("id",val+"box");
                        d1.setAttribute("class", "alert alert-success");
                        d1.setAttribute("style", "display:inline-block; margin:2px; padding:5px;");
                        document.querySelector("#intDiv").appendChild(d1);
                        var a1=document.createElement("a");
                        a1.setAttribute("id",val);
                        var ids=val;
                        a1.setAttribute("onclick","popArray(this.id,intArray)");
                        d1.appendChild(a1);
                        var i1=document.createElement("i");
                        i1.setAttribute("class","text-success remove glyphicon glyphicon-remove-sign glyphicon-white");
                        i1.setAttribute("style","margin-left: 5px;vertical-align:middle;");
                        a1.appendChild(i1);
                        pushArray(val,intArray);
                        $("#interests").val("");
                    }
                }
            });
            $("#natLan").on('input', function () {
                var val = this.value;
                if($('#nllist option').filter(function(){
                        return this.value === val;
                    }).length) {
                    if(val){
                        /*alert(val);*/
                        var d1=document.createElement("div");
                        d1.innerHTML=val;
                        d1.setAttribute("id",val+"box");
                        d1.setAttribute("class", "alert alert-success");
                        d1.setAttribute("style", "display:inline-block; margin:2px; padding:5px;");
                        document.querySelector("#natLanDiv").appendChild(d1);
                        var a1=document.createElement("a");
                        a1.setAttribute("id",val);
                        var ids=val;
                        a1.setAttribute("onclick","popArray(this.id,natLanArray)");
                        d1.appendChild(a1);
                        var i1=document.createElement("i");
                        i1.setAttribute("class","text-success remove glyphicon glyphicon-remove-sign glyphicon-white");
                        i1.setAttribute("style","margin-left: 5px;vertical-align:middle;");
                        a1.appendChild(i1);
                        pushArray(val,natLanArray);
                        $("#natLan").val("");
                    }
                }
            });
            $("#learnLan").on('input', function () {
                var val = this.value;
                if($('#lllist option').filter(function(){
                        return this.value === val;
                    }).length) {
                    if(val){
                        /*alert(val);*/
                        var d1=document.createElement("div");
                        d1.innerHTML=val;
                        d1.setAttribute("id",val+"box");
                        d1.setAttribute("class", "alert alert-success");
                        d1.setAttribute("style", "display:inline-block; margin:2px; padding:5px;");
                        document.querySelector("#learnLanDiv").appendChild(d1);
                        var a1=document.createElement("a");
                        a1.setAttribute("id",val);
                        var ids=val;
                        a1.setAttribute("onclick","popArray(this.id,learnLanArray)");
                        d1.appendChild(a1);
                        var i1=document.createElement("i");
                        i1.setAttribute("class","text-success remove glyphicon glyphicon-remove-sign glyphicon-white");
                        i1.setAttribute("style","margin-left: 5px;vertical-align:middle;");
                        a1.appendChild(i1);
                        pushArray(val,learnLanArray);
                        $("#learnLan").val("");
                    }
                }
            });
            $("#updateInterestsBtn").click(function(){
                var data_str=intArray.join(", ");
                console.log(data_str);
                $.post('<?=$_SERVER['PHP_SELF'];?>',{interests:data_str},function(data){
                    console.log(data);
                });
            });
            $("#updateLanguageBtn").click(function(){
                var learn_lan=learnLanArray.join(", ");
                var native_lan=natLanArray.join(", ");
                console.log(learn_lan);
                console.log(native_lan);
                $.post('<?=$_SERVER['PHP_SELF'];?>',{native_lan:native_lan,learn_lan:learn_lan},function(data){
                    console.log(data);
                });
            });

        });

        function pushArray(v,$a){
            $a.push(v);
            console.log($a);
        }
        function popArray(v,$a){
            console.log(v);
            console.log($a);
            var index=$a.indexOf(v);
            console.log(index);
            if (index > -1) {
                $a.splice(index, 1);
                document.getElementById(v+"box").remove();
            }
            console.log($a);

        }


        setInterval("onlineStatusUpdate()", 5000); // Update every 10 seconds
        setTimeout(function(){
            onlineStatusUpdate();
        },1000)
        function onlineStatusUpdate()
        {
            $.post("onlineStatusUpdate.php"); // Sends request to update.php
            $.post("getOnlineUsers.php",null,function(data){
                $("#onlineUsersList").html(data);
            });
        }

        function makeFriend(user) {
            $.get("make_friend.php",{id:user,u:"<?=$_SESSION['username'];?>",act:"friend_request"});
        }

        function get_state(){
            $ctr=$("#country").val();
            $.get("get_location.php",{country:$ctr},function(data){
                $("#state").html(data);
            });
        }
        function get_city(){
            $state=$("#state").val();
            $.get("get_location.php",{state:$state},function(data){
                $("#city").html(data);
            });
        }
    </script>

    <!--- xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx --->

    <style>
        body{
            background: #efefef;
        }
        .no-margin{
            margin:0px;!important;
        }
        .no-padding{
            padding:0px;!important;
        }
        .profile-image{
            max-width:100px;
        }

        .left-div, .chat-div{
            padding:10px;
            background-color: #fff;
            border: solid #d6d6d6;
            border-width: 0px 1px;
            box-sizing: border-box;
            padding-bottom: 10000px;
            margin-bottom: -10000px;
            overflow: hidden;
        }
        .chat-div .onlineBox{
            display:block;
        }
        .chat-div .onlineBox ul{
            list-style: none;
            padding:0px;
        }
        .chat-div .onlineBox ul li{
            display: block;
        }
        .chat-div .onlineBox ul li a{
            display: block;
            padding:10px;
            color:#444;
            text-decoration:none;
        }
        .chat-div .onlineBox ul img{
            height:28px;
            border-radius:14px;
        }
        .chat-div .onlineBox ul li a{
            position: relative;
        }
        .chat-div .onlineBox ul a .online-color{
            color: #f09400;
        }
        .chat-div .onlineBox ul li a .conv_option{
            position:absolute;
            display:inline-block;!important;
            right:10px;
        }
        .m10{
            margin:10px;
        }
        .p10{
            padding: 10px;
        }
        @media screen and (min-width: 768px) {
            .user-block-container{
                padding:10px; !important;
            }
        }
        @media screen and (max-width: 768px) {
            .user-block-container{
                padding:5px; !important;
            }
        }

        .user-block-container{
            border: 1px solid #d6d6d6;
            background: #fff;
        }
        .user-block{
            position: relative;
        }
        .user-block .fa-user-plus{
            position: absolute;
            right:7%;
            top:7%;
            font-size: 20px;
        }
        #user_profile_modal .interests{
            padding:5px;
        }

        @media screen and (max-width:768px){
            .col-md-4, .col-xs-6 {
                padding: 2px;!important;
            }
        }
        @media screen and (min-width:768px){
            .col-md-4, .col-xs-6 {
                padding: 10px;!important;
            }
        }

    </style>
</head>
<body>
<?php include "header.php"; ?>
<div class="container-fluid no-margin no-padding" id="main_container">
    <div class="col-md-3 left-div">
        <div class="text-center">
            <?php
            $db=mysqli_connect("localhost","root","123456","gettogether");
            $username=$_SESSION['username'];
            $sql="select * from users,user_profile where users.username='$username' and users.username=user_profile.user_id";
            $res=mysqli_query($db,$sql);
            $row=mysqli_fetch_assoc($res);
            $user_img=$row['profile_pic'];
            $name=$row['name'];
            ?>
            <a href="intermediate.php"><img src="<?=$user_img;?>" alt="" class="img-circle profile-image"></a>
            <div><strong><a href="profile.php"><?=$name;?></a></strong></div>
            <div class=""><?=$_SESSION['username'];?></div>
        </div>
        <div>
            <form action="" method="post">
                <div class="form-group">
                    <label for="country">Country</label>
                    <select name="country" id="country" class="form-control" onchange="get_state();">
                        <?php
                            $user=new User();
                            $res_user=$user->showUserProfile($_SESSION['username']);
                            $row_user=$res_user->fetch_assoc();

                            $location=new Location();
                            $res=$location->getCountry();
                            while($row=$res->fetch_assoc()):

                        ?>
                        <option value="<?=$row['id'];?>" <?php if($row['id']==$row_user['country_id']) echo "selected";?>><?=$row['name'];?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="state">State</label>
                    <select name="state" id="state" class="form-control" onchange="get_city()">
                        <?php if($row['state']!=null){
                            $state=$location->getState($row['country_id']);
                            while($row=$state->fetch_assoc()){
                                $name=$row['name'];
                                echo "<option value='$name'>$name</option>";
                            }
                        }?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="city">City</label>
                    <select name="city" id="city" class="form-control">

                    </select>
                </div>
                <div class="form-group">
                    <button class="btn btn-success">Update Location</button>
                    <button class="btn btn-default"type="reset">Reset Fields</button>
                </div>
                <input type="hidden" name="location">
            </form>
        </div>
    </div>

    <div class="col-md-7">
        <div class="row" style="padding:10px;">
            <div class="col-md-6">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <span class="panel-title">Interests & Hobbies</span>
                    </div>
                    <div class="panel-body">
                        <form method="post" action="" class="">
                            <div class="form-group" id="intDiv">
                                <label class="control-label" for="interests">Hobbies/Interests : </label>
                                <input list="ilist" name="interests" id="interests" class="form-control">
                                <datalist id="ilist">
                                    <?php
                                    foreach ($iArray as $key => $arr) {
                                    ?>
                                    <option value="<?php echo"$arr"; ?>">
                                        <?php
                                        }
                                        ?>
                                </datalist>
                            </div>
                            <div class="form-group btn-group btn-group-justified">
                                <div class="btn-group" role="group">
                                    <button type="button" class="btn btn-primary" id="updateInterestsBtn">Update Details</button>
                                </div>
                                <div class="btn-group" role="group">
                                    <button type="reset" class="btn btn-default">Cancel</button>
                                </div>
                            </div>
                            <input type="hidden" name="interestsArray" id="interestsArray">
                        </form>
                    </div>
                </div>
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <span class="panel-title">Language Section</span>
                    </div>
                    <div class="panel-body">
                        <form method="post" action="" class="">
                            <div class="form-group" id="natLanDiv">
                                <label class="control-label" for="natLan">Native Language(s) : </label>
                                <input list="nllist" name="natLan" id="natLan" class="form-control">
                                <datalist id="nllist">
                                    <?php
                                    $lang=new Language();
                                    $res=$lang->showLanguage();
                                    while($row=$res->fetch_assoc()):
                                    ?>
                                    <option value="<?=$row['name'];?>">
                                        <?php
                                        endwhile;
                                        ?>
                                </datalist>
                                <input type="hidden" name="natLanArray" id="natLanArray">
                            </div>
                            <div class="form-group">

                            </div>
                            <div class="form-group" id="learnLanDiv">
                                <label class="control-label" for="learnLan">Preferred Learning Language(s) : </label>
                                <input list="lllist" name="learnLan" id="learnLan" class="form-control">
                                <datalist id="lllist">
                                    <?php
                                    $lang=new Language();
                                    $res=$lang->showLanguage();
                                    while($row=$res->fetch_assoc()):
                                    ?>
                                    <option value="<?=$row['name'];?>">
                                        <?php
                                        endwhile;
                                        ?>
                                </datalist>
                                <input type="hidden" name="learnLanArray" id="learnLanArray">
                            </div>
                            <div class="form-group btn-group btn-group-justified">
                                <div class="btn-group" role="group">
                                    <button type="button" class="btn btn-primary" id="updateLanguageBtn">Update Details</button>
                                </div>
                                <div class="btn-group" role="group">
                                    <button type="reset" class="btn btn-default">Cancel</button>
                                </div>
                            </div>
                            <input type="hidden" name="learnLanArray" id="learnLanArray">
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="panel panel-warning">
                    <div class="panel-heading">
                        <span class="panel-title">Biography Section</span>
                    </div>
                    <div class="panel-body">
                        <form action="" method="post">
                            <div class="form-group">
                                <label for="biography">Write something About yourself:</label>
                                <?php
                                $user=new User();
                                $res=$user->showUserProfile($_SESSION['username']);
                                $row=$res->fetch_assoc(); ?>
                                <textarea name="biography" id="biog" class="form-control" style="resize: vertical; height:362px"><?=$row['biography'];?></textarea>
                            </div>
                            <div class="form-group">
                                <button class="btn btn-success" type="submit">Update Biography</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="panel panel-danger col-md-2 chat-div">
        <div class="panel-heading">
            <span class="panel-title">Online Users</span>
        </div>
        <div class="onlineBox panel-body" style="padding:0px;">
            <ul class="" id="onlineUsersList">

            </ul>
        </div>
    </div>
</div>
<div id="user_profile_modal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content" style="position: relative">

        </div>
    </div>
</div>
<script>
    function getUserProfileDetails(userid){
        $.get("get_user_profile_details.php",{user:userid},function(data){
            $("#user_profile_modal .modal-content").html(data);
        });
        $("#user_profile_modal").modal('show');
    }
</script>
</body>
</html>
