<?php

/*
define('HOST','localhost');
define('USER','root');
define('PASSWORD','123456');
define('DATABASE','gettogether');
*/

class DbConnection
{
    protected $host='localhost';
    protected $user='root';
    protected $pass='123456';
    protected $dbName='gettogether';

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
        $sql="insert into `users` values (0,'$username', '$name', '$email', '$password', '$gender', '$dob',now(),now())";
        $res=$this->dbase->query($sql);
        if($res){
            echo "success";
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
    function showUserProfile($param=null){
        $where='';
        if(is_array($param)){
            foreach($param as $key=> $val){
                $where.=" and $key='$val'";
            }
            $sql="select * from user_profile where 1=1 $where";
        }

        else{
            $sql="select * from user_profile";
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
            $sql="select * from `website_feedback`,`user_profile`,`users` where user_profile.user_id=website_feedback.user_id and user_profile.user_id=users.username limit 1";
        }
        $res=$this->dbase->query($sql);
        return $res;
    }
}

class Post{
    protected $db;
    protected $dbase;

    function Post(){
        $db=new DbConnection();
        $this->dbase=$db->connect();
    }

    function createPost($username,$post_text,$obj,$obj_type){
        $sql="INSERT INTO `postsCollection` VALUES (0,$username,$post_text,$obj,$obj_type,now())";
        $res=$this->dbase->query($sql);
        if(!$res)
            return false;
        else
            return true;
    }

    function showPosts($filters){
        $str='';
        foreach($filters as $fil){
            $str.="'$fil',";
        }
        $filters=substr($str,0, strlen($str)-1);
        $sql="SELECT * FROM `postsCollection` WHERE `user_id` IN ($filters)";
    }

}

class DbTables{
    protected $db;
    protected $dbase;

    public function __construct()
    {
        $this->db=new DbConnection();
        $this->dbase=$this->db->connect();
    }

    public function get_tables(){
        $tableList=array();
        $res=$this->dbase->query("SHOW TABLES");
        while($cRow=$res->fetch_row())
        {
            $tableList[] = $cRow["0"];
        }
        return $tableList;
    }
    public function table_structures($tname){
        $arr=Array();
        $table_name=$tname;
        $res=$this->dbase->query("DESCRIBE $table_name");
        while($row=$res->fetch_row())
            $arr[]=$row["0"];
        return $arr;
    }

    public function show_tables($tname){
        $arr=array();
        $res=$this->dbase->query("select * from $tname limit 200");
        while($row=$res->fetch_assoc()){
            $arr[]=$row;
        }
        /*print_r($arr);*/
        return $arr;
    }
}



$tables= new DbTables();
$tables->show_tables("users");
$tables->get_tables();
/*$tables->table_structures();*/
