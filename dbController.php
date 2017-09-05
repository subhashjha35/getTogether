<?php

define('HOST','localhost');
define('USER','root');
define('PASSWORD','123456');
define('DATABASE','gettogether');


class DbConnection
{
    protected $host=HOST;
    protected $user=USER;
    protected $pass=PASSWORD;
    protected $dbName=DATABASE;

    public function connect()
    {
        return new mysqli($this->host,$this->user,$this->pass,$this->dbName);
    }

}

class User {
    protected $db;
    public $dbase;
    function User(){
        $this->db=new DbConnection();
        $this->dbase=$this->db->connect();
    }
    function createUser($username, $name, $email, $password, $dob, $gender){
        $username=mysqli_real_escape_string($this->dbase,$username);
        $name=mysqli_real_escape_string($this->dbase,$name);
        $email=mysqli_real_escape_string($this->dbase,$email);
        $password=mysqli_real_escape_string($this->dbase,$password);
        $dob=mysqli_real_escape_string($this->dbase,$dob);
        echo $sql="insert into `users` values (0,'$username', '$name', '$email', '$password', '$gender', '$dob',now(),now())";
        $res=$this->dbase->query($sql);
        if($res){
            $sql="INSERT INTO `user_profile`(`user_id`) VALUES ('$username')";
            if($this->dbase->query($sql)){
                if(!file_exists("./resources/users/$username")){
                    mkdir("./resources/users/$username",0777);
                    mkdir("./resources/users/$username/profile_data",0777);
                    mkdir("./resources/users/$username/avatar_pics",0777);
                    mkdir("./resources/users/$username/avatar_pics/jpg-256",0777);
                    mkdir("./resources/users/$username/chat_data",0777);
                    mkdir("./resources/users/$username/chat_data/images",0777);
                    mkdir("./resources/users/$username/chat_data/videos",0777);
                    mkdir("./resources/users/$username/chat_data/audios",0777);
                    mkdir("./resources/users/$username/chat_data/documents",0777);
                }
                return "success";
            }

        }
    }

    function showUsers($param=null){
        $where='';
        if(is_array($param)){
            foreach($param as $key=> $val){
                $where.=" and $key='$val'";
            }
            $sql="select * from users where 1=1 $where";
        }

        else{
            $sql="select * from users";
        }
        $res=$this->dbase->query($sql);
        return $res;
    }

    function showUserProfile($param=null, $user=null){
        $where='';
        if(is_array($param)){
            foreach($param as $key=> $val){
                $where.=" and $key='$val'";
            }
            $sql="select * from users,user_profile where 1=1 and users.username=user_profile.user_id $where";
        }
        else if($param!=null){
            $sql="select * from users,user_profile where users.username='$param' and users.username=user_profile.user_id";
        }
        else{
            $sql="select * from users,user_profile where users.username=user_profile.user_id and users.username!='$user'";
        }
        $res=$this->dbase->query($sql);
        return $res;
    }

    function loginCheck($filters){
        $this->showUsers($filters);
        return $this->dbase->affected_rows;
    }
    /*function showUsers($filters,$var){
        $where='';
        foreach($filters as $key =>$value){
            $where.=$key."='".$value."' AND ";
        }
        $where=substr($where,0,strlen($where)-5);
        $sql="select * from users where $where";
        $res=mysqli_query($this->dbase, $sql);
        if($var=="check"){
            return mysqli_num_rows($res);
        }
        elseif ($var="show"){
            return $res;
        }

    }*/


    function updateUserDetails($username, $name, $email, $password, $dob, $gender){
        $sql="UPDATE `users` SET `name`='$name',`email`='$email',`password`='$password',`gender`='$gender',`dob`='$dob' WHERE username='$username'";
        $result=$this->dbase->query($sql);
        if($result)
            return 1;
        else
            return 0;
    }

    function updateInterests($interests){
        $username=$_SESSION["username"];
        echo $sql="UPDATE `user_profile` SET `interests` = '$interests' WHERE `user_id`='$username'";
        $result=$this->dbase->query($sql);
        if($result)
            echo "";
        else
            echo $this->dbase->error;
    }

    function updateUserProfile($arr,$user){
        $cond='';
        foreach ($arr as $key=>$value)
            $cond.=$key."='".$value."',";
        $cond=substr($cond,0,strlen($cond)-1);
        $sql="UPDATE user_profile SET $cond where user_id='$user'";
        $result=$this->dbase->query($sql);
        if($result)
            echo "";
        else
            echo $this->dbase->error;
    }

    function deleteUser($username){
        $sql="delete from users where username='$username'";
        if($this->dbase->query($sql)){
            shell_exec("rm -R ./resources/users/$username");
            return 1;
        }
        else
            return 0;
    }
}

class Language{
    protected $db;
    protected $dbase;

    function __construct(){
        $db=new DbConnection();
        $this->dbase=$db->connect();
    }

    function showLanguage(){
        $sql="select * from `languages`";
        $res=$this->dbase->query($sql);
        return $res;
    }
}


class Feedback{
    protected $db;
    protected $dbase;

    function Feedback(){
        $db=new DbConnection();
        $this->dbase=$db->connect();

    }

    function createFeedback($username, $title=null,$body=null, $rating=0){
        $sql="INSERT INTO `website_feedback` VALUES(0,'$username','$title','$body','$rating',now())";
        if($this->dbase->query($sql))
            return 1;
        else
            return 0;
    }

    function viewFeedback($id=null){
        if($id!=null){
            $sql="select * from `website_feedback`,`user_profile`.`users` where user_profile.user_id=website_feedback.user_id and user_profile.user_id=users.username and user_id='$id'";
        }
        else{
            $sql="select * from `website_feedback`,`user_profile`,`users` where user_profile.user_id=website_feedback.user_id and user_profile.user_id=users.username ORDER BY `feedback_rating` DESC";
        }
        $res=$this->dbase->query($sql);
        return $res;
    }
}

class Post{
    protected $db;
    protected $dbase;

    function __construct(){
        $db=new DbConnection();
        $this->dbase=$db->connect();
    }

    function createPost($username,$post_text,$obj,$obj_type){
        $post_text=htmlspecialchars(mysqli_real_escape_string($this->dbase,$post_text));
        $obj=htmlspecialchars(mysqli_real_escape_string($this->dbase,$obj));
        echo $sql="INSERT INTO `postsCollection` VALUES (0,'$username','$post_text','$obj','$obj_type',now())";
        $res=$this->dbase->query($sql);
        if($res){
            $not=new Notification();
            $not->createNotification($username,"","post");
        }
        else
            return $this->dbase->error;
    }

    function showPosts($filters=null){
        if($filters==null){
            $sql="SELECT postsCollection.id AS posts_id,post_text,post_object,post_object_type,post_time,postsCollection.user_id,profile_pic,name FROM `postsCollection`,`user_profile`,`users` WHERE `postsCollection`.`user_id`=`user_profile`.`user_id` and `user_profile`.`user_id`=`users`.`username` ORDER BY `post_time` DESC";
        }
        else{
            $str='';
            foreach($filters as $fil){
                $str.="'$fil',";
            }
            $filters=substr($str,0, strlen($str)-1);
            $sql="SELECT * FROM `postsCollection` WHERE `user_id` IN ($filters)";
        }
        $res=$this->dbase->query($sql);
        return $res;
    }

}

class Message{
    protected $db;
    protected $dbase;

    function __construct()
    {
        $db=new DbConnection();
        $this->dbase=$db->connect();
    }

    function createMessage($sender,$receiver,$msg_text,$msg_obj,$msg_obj_type=null){
        $msg_text=mysqli_real_escape_string($this->dbase,$msg_text);
        $sql="INSERT INTO `msgsCollection` VALUES ( 0,'$sender','$receiver','$msg_text','$msg_obj','$msg_obj_type',now())";
        $res=$this->dbase->query($sql);
        if(!$res)
            echo "couldn't insert Message";
    }
    function showMessage($user1,$user2){
        $user2=mysqli_real_escape_string($this->dbase,$user2);
        $sql="SELECT * FROM `msgsCollection` WHERE (`sender_id`='$user1' and `receiver_id`='$user2') OR (`sender_id`='$user2' and `receiver_id`='$user1') ORDER BY msg_time ASC";
        $res=$this->dbase->query($sql);
        $arr=array();
        while($row=$res->fetch_assoc()){
            $arr[]=$row;
        }
        return $arr;
    }

    function showDistinctUser($user){
        $sql="SELECT `receiver_id` FROM `msgsCollection` WHERE `sender_id` = '$user' GROUP BY `receiver_id` UNION SELECT `sender_id` FROM `msgsCollection` WHERE `receiver_id`= '$user' GROUP BY `sender_id`";
        /*$sql="SELECT `sender_id`, `receiver_id` FROM msgsCollection WHERE `sender_id` <= `receiver_id` UNION SELECT `receiver_id`, `sender_id` FROM msgsCollection WHERE `receiver_id` < `sender_id` and (`sender_id`='$user' OR `receiver_id` ='$user')";*/
        $res=$this->dbase->query($sql);
        $arr=array();
        while ($row=$res->fetch_assoc()){
            if($row['receiver_id']!=$user)
                $arr[]=$row['receiver_id'];
            else
                $arr[]=$row['sender_id'];
        }
        return($arr);
    }
}

class Notification{
    protected $db;
    protected $dbase;

    function __construct()
    {
        $db=new DbConnection();
        $this->dbase=$db->connect();
    }

    function createNotification($from,$to=null,$text){
        $sql="INSERT INTO `notifications_table` VALUES (0,'$from','$to','$text',now(),'0')";
        $res1=$this->dbase->query($sql);
        if($res1){
            echo "inserted notification";
        }
        else
            echo "insertion of notification failed";
    }

    function showRequestNotification($user,$limit=null){
        if($limit==null){
            $sql="SELECT * FROM `notifications_table`, `users`, `user_profile` WHERE `to` = '$user' and `text`='friend_request' and notifications_table.from=users.username and users.username=user_profile.user_id ORDER BY notifications_table.time";
        }
        else{
            $sql="SELECT * FROM `notifications_table`, `users`, `user_profile` WHERE `to` = '$user' and `text`='friend_request' and notifications_table.from=users.username and users.username=user_profile.user_id ORDER BY notifications_table.time limit $limit";
        }
        $res=$this->dbase->query($sql);
        $arr=array();
        while($row=$res->fetch_assoc()){
            $arr[]=$row;
        }
        return $arr;
    }

    function unreadNotification($user){
        $sql="SELECT * FROM `notifications_table`, `users`, `user_profile` WHERE `to` = '$user' and `text`='friend_request' and `read_status`='0' and notifications_table.from=users.username and users.username=user_profile.user_id ORDER BY notifications_table.time";
        $res=$this->dbase->query($sql);
        return $res;
    }

    function getUnreadNotification($user){
        $var=$this->unreadNotification($user);
        $arr=array();
        while($row=$var->fetch_assoc())
            $arr[]=$row;
        return $arr;
    }
    function countUnreadNotification($user){
        $var=$this->unreadNotification($user);
        $count=$var->num_rows;
        return $count;
    }

    function updateNotificationWithReadValue($id,$user){
        $sql="UPDATE `notifications_table` SET `read_status`='1' WHERE id='$id' and 'from'='$user'";
        $res=$this->dbase->query($sql);
        return($this->dbase->affected_rows);
    }

    function deleteNotification($from, $to, $text){
        $sql="DELETE FROM `notification_table` where `from`='$from' and `to`='$to' and `text`='$text'";
        $res=$this->dbase->query($sql);
        return $this->dbase->affected_rows;
    }

}
class Friend{
    protected $db;
    protected $dbase;

    function __construct()
    {
        $this->db=new DbConnection();
        $this->dbase=$this->db->connect();
    }

    function createFriendship($user1,$user2,$action){
        echo $sql="INSERT INTO `friend_table` VALUES (0,'$user2','$user1',now())";
        $res=$this->dbase->query($sql);
        echo $this->dbase->error;
        if($res){
            if($action=="friend_request"){
                $not=new Notification();
                $cnot=$not->createNotification($user2,$user1,"friend_request");
                return $cnot;
            }

        }

        else
            return 0;
    }

    function acceptFriendship($user1,$user2,$action){
        $sql="INSERT INTO `friend_table` VALUES (0,'$user2','$user1',now())";
        $res=$this->dbase->query($sql);
        if($res){
            if($action=="accept_request"){
                $not=new Notification();
                $cnot=$not->deleteNotification($user1,$user2,"friend_request");
                return $cnot;
            }
        }
        else
            echo "can't accept request";
    }

    function showFriends($user){
        $sql="SELECT * FROM `friend_table` where ";
    }

    function checkFriendship($user1,$user2){
        $sql="SELECT * FROM `friend_table` where (`follower`='$user1' and `being_followed`='$user2') and (`being_followed`='$user1' and `follower`='$user2')";
        $res=$this->dbase->query($sql);
        return $res->num_rows;
    }

}


class Location
{
    protected $db;
    protected $dbase;

    function __construct()
    {
        $this->db = new DbConnection();
        $this->dbase = $this->db->connect();
    }

    function getCountry($id=null)
    {
        if($id==""){
            $sql = "SELECT * FROM `countries`";
        }
        else{
            $sql = "SELECT * FROM `countries` WHERE `id`='$id'";
        }
        $res = $this->dbase->query($sql);
        return $res;
    }

    function getState($ctr)
    {
        $sql = "SELECT * FROM `states` WHERE country_id='$ctr'";
        $res = $this->dbase->query($sql);
        return $res;
    }

    function getCity($state)
    {
        $sql = "SELECT * FROM `cities` WHERE state_id='$state'";
        $res = $this->dbase->query($sql);
        return $res;
    }
}

class PostComment{
    protected $db,$dbase;

    function __construct(){
        $this->db=new DbConnection();
        $this->dbase=$this->db->connect();
    }

    function createPostComment($post_id,$user,$comment_text){
        $sql="INSERT INTO `post_comments` VALUES (0,'$post_id','$user','$comment_text',now())";
        $res=$this->dbase->query($sql);
        /*if($res){
            echo "successfull";
        }
        else echo "Failed Insertion";*/
    }

    function showPostComment($post_id,$limit){
        $sql="SELECT * FROM `post_comments` WHERE `post_id`='$post_id' ORDER BY comment_time DESC limit $limit";
        $res=$this->dbase->query($sql);
        return $res;
    }
    function countPost($post_id){
        $sql="SELECT count(*) FROM `post_comments` WHERE `post_id`='$post_id'";
        $res=$this->dbase->query($sql);
        return $res;
    }
}

?>

