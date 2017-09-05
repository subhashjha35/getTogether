<?php

session_start();

$self = "phpfm.php";
$selfdb = "phpfm.db";

// Has posix
$puser = "";
if (function_exists("posix_getpwuid"))
    $puser = posix_getpwuid(posix_geteuid())['name'];

// Form or HTTP Digest, depending on SSL
$loginmethod = 1;

// ***Never*** change the following CLSIDs
// {BE57D5A5-200B-4BB2-90F2-9A0FABC0FD8A}
$users = array();
$storage = 1;
// {A50180F7-90D7-45B7-B250-9C381217A6DF}


if(!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off')
{
    $loginmethod = 2;
}

// Head output
function Head()
{
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>PHP File Manager</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
    <script src="//oss.maxcdn.com/jquery.form/3.50/jquery.form.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <script src="https://www.google.com/recaptcha/api.js"></script>
    

    <link href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.6.2/chosen.css" rel="stylesheet">

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.6.2/chosen.jquery.js"></script>

    <!-- Custom Fonts -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/4.4.0/bootbox.min.js"></script>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

    <!-- Custom CSS -->
    <style>


		@media (min-width: 768px) {
		#page-wrapper {
		position: inherit;
		margin: 0 0 0 250px;
		padding: 0 30px;
		border-left: 1px solid #e7e7e7;
		}
		}

        .navbar-top-links {
		margin-right: 0;
		}
		.navbar-top-links li {
		display: inline-block;
		}
		.navbar-top-links li:last-child {
		margin-right: 15px;
		}
		.navbar-top-links li a {
		padding: 15px;
		min-height: 50px;
		}
		.navbar-top-links .dropdown-menu li {
		display: block;
		}
		.navbar-top-links .dropdown-menu li:last-child {
		margin-right: 0;
		}
		.navbar-top-links .dropdown-menu li a {
		padding: 3px 20px;
		min-height: 0;
		}
		.navbar-top-links .dropdown-menu li a div {
		white-space: normal;
		}
		.navbar-top-links .dropdown-messages,
		.navbar-top-links .dropdown-tasks,
		.navbar-top-links .dropdown-alerts {
		width: 310px;
		min-width: 0;
		}
		.navbar-top-links .dropdown-messages {
		margin-left: 5px;
		}
		.navbar-top-links .dropdown-tasks {
		margin-left: -59px;
		}
		.navbar-top-links .dropdown-alerts {
		margin-left: -123px;
		}
		.navbar-top-links .dropdown-user {
		right: 0;
		left: auto;
		}
		.sidebar .sidebar-nav.navbar-collapse {
		padding-left: 0;
		padding-right: 0;
		}
		.sidebar .sidebar-search {
		padding: 15px;
		}
		.sidebar ul li {
		border-bottom: 1px solid #e7e7e7;
		}
		.sidebar ul li a.active {
		background-color: #eeeeee;
		}
		.sidebar .arrow {
		float: right;
		}
		.sidebar .fa.arrow:before {
		content: "\f104";
		}
		.sidebar .active > a > .fa.arrow:before {
		content: "\f107";
		}
		.sidebar .nav-second-level li,
		.sidebar .nav-third-level li {
		border-bottom: none !important;
		}
		.sidebar .nav-second-level li a {
		padding-left: 37px;
		}
		.sidebar .nav-third-level li a {
		padding-left: 52px;
		}
		@media (min-width: 768px) {
		.sidebar {
		z-index: 1;
		position: absolute;
		width: 250px;
		margin-top: 51px;
		}
		.navbar-top-links .dropdown-messages,
		.navbar-top-links .dropdown-tasks,
		.navbar-top-links .dropdown-alerts {
		margin-left: auto;
		}
		}
		.btn-outline {
		color: inherit;
		background-color: transparent;
		transition: all .5s;
		}
		.btn-primary.btn-outline {
		color: #428bca;
		}
		.btn-success.btn-outline {
		color: #5cb85c;
		}
		.btn-info.btn-outline {
		color: #5bc0de;
		}
		.btn-warning.btn-outline {
		color: #f0ad4e;
		}
		.btn-danger.btn-outline {
		color: #d9534f;
		}
		.btn-primary.btn-outline:hover,
		.btn-success.btn-outline:hover,
		.btn-info.btn-outline:hover,
		.btn-warning.btn-outline:hover,
		.btn-danger.btn-outline:hover {
		color: white;
		}
		.panel .slidedown .glyphicon,
		.chat .glyphicon {
		margin-right: 5px;
		}
		.chat-panel .panel-body {
		height: 350px;
		overflow-y: scroll;
		}
		.login-panel {
		margin-top: 25%;
		}
		.flot-chart {
		display: block;
		height: 400px;
		}
		.flot-chart-content {
		width: 100%;
		height: 100%;
		}
		.show-grid [class^="col-"] {
		padding-top: 10px;
		padding-bottom: 10px;
		border: 1px solid #ddd;
		background-color: #eee !important;
		}
		.show-grid {
		margin: 15px 0;
		}
		.huge {
		font-size: 40px;
		}
		.panel-green {
		border-color: #5cb85c;
		}
		.panel-green > .panel-heading {
		border-color: #5cb85c;
		color: white;
		background-color: #5cb85c;
		}
		.panel-green > a {
		color: #5cb85c;
		}
		.panel-green > a:hover {
		color: #3d8b3d;
		}
		.panel-red {
		border-color: #d9534f;
		}
		.panel-red > .panel-heading {
		border-color: #d9534f;
		color: white;
		background-color: #d9534f;
		}
		.panel-red > a {
		color: #d9534f;
		}
		.panel-red > a:hover {
		color: #b52b27;
		}
		.panel-yellow {
		border-color: #f0ad4e;
		}
		.panel-yellow > .panel-heading {
		border-color: #f0ad4e;
		color: white;
		background-color: #f0ad4e;
		}
		.panel-yellow > a {
		color: #f0ad4e;
		}
		.panel-yellow > a:hover {
		color: #df8a13;
		}
		.timeline {
		position: relative;
		padding: 20px 0 20px;
		list-style: none;
		}
		.timeline:before {
		content: " ";
		position: absolute;
		top: 0;
		bottom: 0;
		left: 50%;
		width: 3px;
		margin-left: -1.5px;
		background-color: #eeeeee;
		}
		}

        a:link { text-decoration: none; }
        a:visited { text-decoration: none; }
        a:hover { text-decoration: none; }
        a:active { text-decoration: none; }


        #filemenu { position: absolute; display:none; }
        #foldermenu { position: absolute; display:none; }
    </style>

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs/jqc-1.12.3/pdfmake-0.1.18/dt-1.10.12/b-1.2.1/b-html5-1.2.1/b-print-1.2.1/fh-3.1.2/r-2.1.0/datatables.min.css" />
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs/jqc-1.12.3/pdfmake-0.1.18/dt-1.10.12/b-1.2.1/b-html5-1.2.1/b-print-1.2.1/fh-3.1.2/r-2.1.0/datatables.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.blockUI/2.70/jquery.blockUI.min.js"></script>


</head>
<?php
}

function LastError()
{
    $r = print_r(error_get_last(),true);
    return $r;
}

function PrintSessionErrors()
{
    if (array_key_exists("error",$_SESSION))
    {
?>
<div class="alert alert-danger alert-dismissable">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">x</a>
    <?= $_SESSION['error'] ?>
</div>
<?php
        unset($_SESSION['error']);
    }
    if (array_key_exists("success",$_SESSION))
    {
?>
<div class="alert alert-success alert-dismissable">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">x</a>
    <?= $_SESSION['success'] ?>
</div>
<?php
        unset($_SESSION['success']);
    }

}

function enumDir($path,&$arr = array())
{
    if (is_dir($path) === true)
    {
        $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path), RecursiveIteratorIterator::CHILD_FIRST);

        foreach ($files as $file)
        {
            if (in_array($file->getBasename(), array('.', '..')) !== true)
            {
                array_push($arr,$file->getPathName());
            }
        }

        array_push($arr,$path);
    }

    else if ((is_file($path) === true) || (is_link($path) === true))
    {
        array_push($arr,$path);
    }

    return;
}

function deleteDir($path)
{
    if (is_dir($path) === true)
    {
        $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path), RecursiveIteratorIterator::CHILD_FIRST);

        foreach ($files as $file)
        {
            if (in_array($file->getBasename(), array('.', '..')) !== true)
            {
                if ($file->isDir() === true)
                {
                    rmdir($file->getPathName());
                }

                else if (($file->isFile() === true) || ($file->isLink() === true))
                {
                    unlink($file->getPathname());
                }
            }
        }

        return rmdir($path);
    }

    else if ((is_file($path) === true) || (is_link($path) === true))
    {
        return unlink($path);
    }

    return false;
}


if ($storage == 2)
{
    $db = new SQLite3($selfdb);
    $db->query("CREATE TABLE IF NOT EXISTS USERS (ID INTEGER,USERNAME,ADMIN,PASSWORD,ROOT)");
    $db->query("CREATE TABLE IF NOT EXISTS ACCESS (ID INTEGER,UID INTEGER,FOLD TEXT,ACC INTEGER)");
    $d = $db->query("SELECT * FROM USERS");

    $users = array();
    while($row = $d->fetchArray())
    {
        $users[$row['USERNAME']]['admin'] = $row['ADMIN'];
        $users[$row['USERNAME']]['password'] = $row['PASSWORD'];
        $users[$row['USERNAME']]['root'] = $row['ROOT'];

        $d2 = $db->query(sprintf("SELECT * FROM ACCESS WHERE UID = %s",$row['ID']));
        $acc = array();
        while($row2 = $d2->fetchArray())
        {
            $acc[$row2['FOLD']] = $row2['ACC'];
        }
        $users[$row['USERNAME']]['access'] = $acc;

    }
}

function SaveDB()
{
    global $users;
    global $storage;
    global $selfdb;
    if ($storage != 2)
        return;

    $db = new SQLite3($selfdb);
    $db->query("DELETE FROM USERS");
    $db->query("DELETE FROM ACCESS");


    if (count($users) == 1 && $users['root']['password'] == "")
        return;

    $i = 0;
    $k = 0;
    foreach($users as $un => $user)
    {
        $i++;
        $db->query("INSERT INTO USERS (ID,USERNAME,ADMIN,PASSWORD,ROOT) VALUES ('$i','$un','{$user['admin']}','{$user['password']}','{$user['root']}')");
        foreach($user['access'] as $a1 => $a2)
        {
            $k++;
            $db->query("INSERT INTO ACCESS (ID,UID,FOLD,ACC) VALUES ('$k','$i','$a1','$a2')");
        }

    }

}

$string1 = "";
$string2 = "";
function BeforeUsersUpdate()
{
    global $storage;
    global $self;
    global $string1;
    global $string2;

    $stri1 = "// {BE57D5A5-200B-4BB2-90F2-9A0FABC0FD8A}";
    $stri2 = "// {A50180F7-90D7-45B7-B250-9C381217A6DF}";
    $fr = file_get_contents($self);
    $a = strpos($fr,$stri1);
    if ($a === false)
        die;
    $string1 = substr($fr,0,$a + strlen($stri1));
    $a = strpos($fr,$stri2);
    if ($a === false)
        die;
    $string2 = substr($fr,$a);
}

function AfterUsersUpdate()
{
    global $storage;
    if ($storage == 2)
        SaveDB();

    global $self;
    global $string1;
    global $string2;

    if (!strlen($string1) || !strlen($string2))
        return; // duh

    $r = LoadUsers();
    if ($storage == 2)
        $r = '$users = array();';
    $r2 = sprintf('$storage = %s;',$storage);
    $fstr = $string1 . "\r\n" . $r . "\r\n" . $r2 . "\r\n" . $string2;
    file_put_contents($self,$fstr);
}



// HTTP Digest Authentication stuff
function http_digest_parse($txt)
{
    // protect against missing data
    $needed_parts = array('nonce'=>1, 'nc'=>1, 'cnonce'=>1, 'qop'=>1, 'username'=>1, 'uri'=>1, 'response'=>1);
    $data = array();
    $keys = implode('|', array_keys($needed_parts));
    preg_match_all('@(' . $keys . ')=(?:([\'"])([^\2]+?)\2|([^\s,]+))@', $txt, $matches, PREG_SET_ORDER);
    foreach ($matches as $m) {
        $data[$m[1]] = $m[3] ? $m[3] : $m[4];
        unset($needed_parts[$m[1]]);
    }
    return $needed_parts ? false : $data;
}
$realm = 'PHP FileManager';
if (count($users) == 0)
{
    $users = array('root' => array('admin' => '1','password' => '','root' => '.','access' => array('.' => 2)));
    if ($loginmethod == 2)
        $users = array('root' => array('admin' => '1','password' => sha1(''),'root' => '.','access' => array('.' => 2)));

}
if ($loginmethod == 1)
{
    if (empty($_SERVER['PHP_AUTH_DIGEST'])) {
        header('HTTP/1.1 401 Unauthorized');
        header('WWW-Authenticate: Digest realm="'.$realm.
               '",qop="auth",nonce="'.uniqid().'",opaque="'.md5($realm).'"');
        die('403');
    }

    // analyze the PHP_AUTH_DIGEST variable
    if (!($data = http_digest_parse($_SERVER['PHP_AUTH_DIGEST'])) ||
        !isset($users[$data['username']]))
        die('403');

    // generate the valid response
    $A1 = md5($data['username'] . ':' . $realm . ':' . $users[$data['username']]['password']);
    $A2 = md5($_SERVER['REQUEST_METHOD'].':'.$data['uri']);
    $valid_response = md5($A1.':'.$data['nonce'].':'.$data['nc'].':'.$data['cnonce'].':'.$data['qop'].':'.$A2);

    if ($data['response'] != $valid_response)
        die('403');

    // ok, valid username & password
    // echo 'You are logged in as: ' . $data['username'];
    $user = $data['username'];
    $access = $users[$data['username']]['access'];
    $root = $users[$data['username']]['root'];

}
else // SSL
{
    if (isset($_POST['login']))
    {
        $_SESSION['error'] = "Access denied.";
        foreach($users as $un => $u)
        {
            if ($un == $_POST['uname'] && $u['password'] == sha1($_POST['pass']))
            {
                unset($_SESSION['error']);
                $_SESSION['login'] = $un;
                $user = $un;
                break;
            }
        }
    }

    // Session based
    if (array_key_exists("login",$_SESSION))
    {
        $access = $users[$_SESSION['login']]['access'];
        $root = $users[$_SESSION['login']]['root'];
        $user = $_SESSION['login'];
    }
    else
    {
        // Show login
        Head();
        PrintSessionErrors();
        ?>

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-6">
            <br><br>
            <form id="login" method="POST" action="<?= $self ?>">

                <input type="hidden" name="login" value="1" ?>
                <label for="uname">Username</label>
                <input class="form-control" name="uname" id="uname" />
                <br />
                <label for="pass">Password</label>
                <input type="password" class="form-control" name="pass" id="pass" />
                <br />
                <button class="btn btn-primary">Submit</button>

            </form>
        </div>
    </div>

        <?php
        die;
    }
}

// Root Folder
if (!array_key_exists('current',$_SESSION))
    $_SESSION['current'] = $root;
// Permitted ?
if (AccessType($_SESSION['current']) == 0)
    $_SESSION['current'] = $root;
    


// All users in array, so we save them back to self
function LoadUsers()
{
    global $users;

    if (count($users) == 1 && $users['root']['password'] == "")
        return "\$users = array();\r\n";

    $u = "\$users = array(\r\n";
    $i = 0;
    foreach($users as $username => $user)
    {
        if ($i > 0)
            $u .= ",\r\n";
        $acc = "array(";// array("." => 2)
        $ii = 0;
        foreach($user['access'] as $acxd => $acx)
        {
            if ($ii > 0)
                $acc .= ",";
            $acc .= sprintf("'%s' => %s",$acxd,$acx);
            $ii++;
        }
        $acc .= ")";
        $u .= sprintf("'%s' => array('admin' => '%s','password' => '%s','root' => '%s','access' => %s)",$username,$user['admin'],$user['password'],$user['root'],$acc);
        $i++;
    }

    $u .= "\r\n);";
    return $u;
}

if (isset($_GET['logout']))
{
    session_destroy();
    header("Location: $self");
    die;
}

if (isset($_GET['profile']))
{
    ?>
        <br><br>
    	<div class="container-fluid">
		<div class="row">
			<div  class="col-md-2">
			</div>
			<div  class="col-md-6">
            <form action="<?= $self ?>" method="POST" >
                <input type="hidden" name="profilechange" value="1" ?>
                <label for="uname">Username</label>
                <input class="form-control" name="uname" id="uname" value="<?= $user ?>" readonly/>
                <br>
                <label for="pwd1">Password</label>
                <input type="password" class="form-control" name="pwd1" id="pwd2" pwd2" />
                <br>
                <label for="pwd2">(Again)</label>
                <input type="password" class="form-control" name="pwd2" id="pwd2"  pwd2" />
                <br>
                <button class="btn btn-primary">Submit</button>
            </form>
        </div>
		</div>
	</div>


    <?php
    die;
}

if (isset($_GET['createprofile']))
{
    if ($users[$user]['admin'] != 1)
        die;
    ?>
        <br><br>
    	<div class="container-fluid">
		<div class="row">
			<div  class="col-md-2">
			</div>
			<div  class="col-md-6">
            <form action="<?= $self ?>" method="POST" >
                <input type="hidden" name="newprofile" value="1" ?>
                <label for="uname">Username</label>
                <input class="form-control" name="uname" id="uname" />
                <br>
                <label for="root">Root folder</label>
                <input class="form-control" name="root" id="root" value="./" />
                <br>
                <label for="pwd1">Password</label>
                <input type="password" class="form-control" name="pwd1" id="pwd2" pwd2" />
                <br>
                <label for="pwd2">(Again)</label>
                <input type="password" class="form-control" name="pwd2" id="pwd2"  pwd2" />
                <br>
                <button class="btn btn-primary">Submit</button>
            </form>
        </div>
		</div>
	</div>


    <?php
    die;
}

if (isset($_GET['options']))
{
    if ($users[$user]['admin'] != 1)
        die;
    ?>
        <br><br>
    	<div class="container-fluid">
		<div class="row">
			<div  class="col-md-2">
			</div>
			<div  class="col-md-6">
            <form action="<?= $self ?>" method="POST" >
                <input type="hidden" name="setoptions" value="1" ?>
                <label for="stmethod">Storage method</label>
                <select class="form-control" name="stmethod" id="stmethod" <?= (count($users) == 1 && $users["root"]["password"] === "") ? "" : "disabled"  ?>>
                    <option value="1" <?= $storage == 1 ? "selected" : "" ?>>Self</option>
                    <option value="2" <?= $storage == 2 ? "selected" : "" ?>>SQLite database</option>
                </select>
                <br>
                <button class="btn btn-primary">Submit</button>
            </form>
        </div>
		</div>
	</div>


    <?php
    die;
}

if (isset($_POST['setoptions']))
{
    if ($users[$user]['admin'] != 1)
        die;

    // Before Users Update
    BeforeUsersUpdate();

    $storage = $_POST['stmethod'];

    // After Users Update
    AfterUsersUpdate();

}


if (isset($_POST['profilechange']))
{
    if ($_POST['pwd1'] !== $_POST['pwd2'] || !strlen($_POST['pwd1']))
        die("Password error");

    // Before Users Update
    BeforeUsersUpdate();

    $users[$user]['password'] = $_POST['pwd1'];
    if ($loginmethod == 2)
        $users[$user]['password'] = sha1($_POST['pwd1']);

    // After Users Update
    AfterUsersUpdate();

    if ($loginmethod == 2)
        header("Location: $self?logout");
    else
        die("Password changed. You have to close your browser and reload it now.");
}


if (isset($_POST['newprofile']))
{
    if ($users[$user]['admin'] != 1)
        die;

    if ($_POST['pwd1'] !== $_POST['pwd2'] || !strlen($_POST['pwd1']))
        die("Password error");

    // Before Users Update
    BeforeUsersUpdate();

    $jack = array('admin' => '0','password' => $_POST['pwd1'],'root' => $_POST['root'],'access' => array($_POST['root'] => 2));
    if ($loginmethod == 2)
        $jack = array('admin' => '0','password' => sha1($_POST['pwd1']),'root' => $_POST['root'],'access' => array($_POST['root'] => 2));
    $users[$_POST['uname']] = $jack;

    // After Users Update
    AfterUsersUpdate();

    header("Location: $self");
}


function PermissionString($perms)
{
    $info = '';
    switch ($perms & 0xF000) {
        case 0xC000: // socket
            $info = 's';
            break;
        case 0xA000: // symbolic link
            $info = 'l';
            break;
        case 0x8000: // regular
            $info = 'r';
            break;
        case 0x6000: // block special
            $info = 'b';
            break;
        case 0x4000: // directory
            $info = 'd';
            break;
        case 0x2000: // character special
            $info = 'c';
            break;
        case 0x1000: // FIFO pipe
            $info = 'p';
            break;
        default: // unknown
            $info = 'u';
    }

    // Owner
    $info .= (($perms & 0x0100) ? 'r' : '-');
    $info .= (($perms & 0x0080) ? 'w' : '-');
    $info .= (($perms & 0x0040) ?
                (($perms & 0x0800) ? 's' : 'x' ) :
                (($perms & 0x0800) ? 'S' : '-'));

    // Group
    $info .= (($perms & 0x0020) ? 'r' : '-');
    $info .= (($perms & 0x0010) ? 'w' : '-');
    $info .= (($perms & 0x0008) ?
                (($perms & 0x0400) ? 's' : 'x' ) :
                (($perms & 0x0400) ? 'S' : '-'));

    // World
    $info .= (($perms & 0x0004) ? 'r' : '-');
    $info .= (($perms & 0x0002) ? 'w' : '-');
    $info .= (($perms & 0x0001) ?
                (($perms & 0x0200) ? 't' : 'x' ) :
                (($perms & 0x0200) ? 'T' : '-'));

    return $info;
}


function dirSize($directory) {
    $size = 0;
    foreach(new RecursiveIteratorIterator(new RecursiveDirectoryIterator($directory)) as $file){
        $size+=$file->getSize();
    }
    return $size;
}

function AccessType($it)
{
    global $access;
    global $self;
    global $selfdb;
    global $user;

    if (strstr($it,"..") !== false)
        return 0;
    if (strpos($it,"/") === 0)
        return 0;
    if (strpos($it,".") !== 0)
        return 0;
    if ($it == $self && $user != "root")
        return 0;
    if ($it == $selfdb)
        return 0;

    $maxa = 0;
    foreach($access as $dir => $acc)
    {
        if (strpos($it,$dir) === 0)
        {
            // Matches
            if ($maxa < $acc)
                $maxa = $acc;
        }

    }

    return $maxa;
}


if (isset($_FILES['file']))
{
	$file = $_FILES['file'];
	$fn = $file['name'];
    $cr = $_SESSION['current'];
    if (strstr($fn,"\\") != 0 || strstr($fn,"/") != 0)
        {
        $_SESSION['error'] = "Write access denied to folder <b>$cr</b>.";
        die;
        }
    if (AccessType($cr) !== 2)
        {
        $_SESSION['error'] = "Write access denied to folder <b>$cr</b>.";
        die;
        }

    $tempfile = $file['tmp_name'];

    if (array_key_exists("zip",$_POST) && $_POST['zip'] == 1)
    {
        $zip = new ZipArchive;
        $zip->open($tempfile);
        $nf = $zip->numFiles;
        for($i = 0; $i < $nf ; $i++)
        {
            $fn2 = $zip->getNameIndex($i);
            if (strstr($fn2,"..") !== false || strstr($fn2,"/") === $fn2)
            {
            unlink($tempfile);
            $_SESSION['error'] = "File contains files with .. or /, not allowed.";
            die;
            }

        }
        $zip->extractTo($cr);
    }
    else
    {
	$dbdata = file_get_contents($tempfile);
    $full = $_SESSION['current'].'/'.$fn;
    file_put_contents($full,$dbdata);
    }
    unlink($tempfile);

    $_SESSION['success'] = "File <b>$fn</b> uploaded successfully.";
    die;
}


function PrintDir($fulldir)
{
    global $self;
    global $selfdb;
    global $user;

    $_SESSION['current'] = $fulldir;
    $li = explode("/",$fulldir);
    printf('<nav class="breadcrumb">');
    $j = 0;
    $e2 = "";
    
    foreach($li as $entry)
    {
        $e = $e2.$entry;
        if ($entry == ".")
            $entry = "(root)";
        if (AccessType($e) == 0)
        {
            if ($j == 0)
                printf("<a class=\"breadcrumb-item\" href=\"#\">$entry</a>");
            else
                printf(" &mdash; <a class=\"breadcrumb-item\" href=\"#\">$entry</a>");
        }
        else
        {
            if ($j == 0)
                printf("<a class=\"breadcrumb-item\" href=\"javascript:g('$self?dir=%s');\">$entry</a>",$e);
            else
                printf(" &mdash; <a class=\"breadcrumb-item\" href=\"javascript:g('$self?dir=%s');\">$entry</a>",$e);
        }
        $j++;
        $e2 = $e;
        $e2 .= "/";
        /*
        
        <a class="breadcrumb-item" href="#">Library</a>
        <a class="breadcrumb-item" href="#">Data</a>
        <span class="breadcrumb-item active">Bootstrap</span>
        </nav>
         */
    }
    printf('</nav>');
    if (AccessType($fulldir) == 0)
    {
        $_SESSION['error'] = "Read access denied to folder $fulldir.";
        die;
    }

    $items = scandir($fulldir);
    
    function cmp($a, $b) {

        $full1 = $_SESSION['current']."/".$a;
        $full2 = $_SESSION['current']."/".$b;
        if (is_dir($full1) && !is_dir($full2))
            return -1;
        if (!is_dir($full1) && is_dir($full2))
            return 1;
        if ($a == $b) 
            return 0;
        return ($a < $b) ? -1 : 1;
    }

    uasort($items,"cmp")
    ?>

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">

    </<form id="dirform">
    <table class="table" id="datatable" width="100%">
    <thead>
        <th width="40"><input type="checkbox" onclick="pickall(this)"></th>
        <th>Name</th>
        <th>Size</th>
        <th>Owner</th>
        <th>Group</th>
        <th>Permissions</th>
    </thead>
    <tbody>
    <?php
    foreach($items as $item)
    {
        if ($item == "." || $item == "..")
            continue;
        if ($item == $self)
            continue;
        if ($item == $selfdb)
            continue;

        $full = $fulldir."/".$item;
        $fs = filesize($full);
        $dir = is_dir($full);

        printf("<tr>");
        printf("<td><input type=\"checkbox\" class=\"fcb\" data-name=\"%s\"></td>",$item);

        if ($dir)
            printf("<td><i class=\"fa fa-folder-o\"></i> <a class=\"foldermenu\" data-name=\"%s\" href=\"javascript:g('$self?dir=%s');\">$item</a></td>",$item,$full);
        else
            printf("<td><i class=\"fa fa-file\"> <a class=\"filemenu\" data-name=\"%s\" data-fullname=\"%s\" target=\"_blank\" href=\"$full\">$item</a></td>",$item,$full,$full);


        if ($dir)   
            printf("<td></td>");
        else
            printf("<td>$fs</td>");

        $oid = fileowner($full);
        $ogr = filegroup($full);
        if (function_exists("posix_getpwuid"))
            $ow = posix_getpwuid($oid);
        else
            $ow = array("name" => $oid);
        if (function_exists("posix_getgrgid"))
            $ow2 = posix_getgrgid($ogr);
        else
            $ow2 = array("name" => $ogr);

        printf("<td>%s</td>",$ow['name']);
        printf("<td>%s</td>",$ow2['name']);


//        print_r(posix_getgrgid(filegroup($full)));
        

        $perms = fileperms($full);
        $pinfo = PermissionString($perms);
        printf('<td style="font-family: monospace;">%s &mdash; %o</td>', $pinfo,$perms);


        printf("</tr>");
        }
        ?>

    </tbody>
    </table>
    <hr>
    <form id="massdownloadform" action="<?= $self ?>" method="POST"> 
    <input id="massdownloadformvalue" type="hidden" name="massdownload" value="">
    </form>
    <form id="massdeleteform" action="<?= $self ?>" method="POST"> 
    <input id="massdeleteformvalue" type="hidden" name="massdelete" value="">
    </form>
        With selected files: <button class="btn btn-default" type="button" onclick="DownloadSelected();">Download</button> &nbsp; <button type="button" onclick="confirm3('Are you ABSOLUTELY sure you want to MASS DELETE selected files?',DeleteSelected);" class="btn btn-default">Delete</button>
    </form>
                </div>
        </div>
    </div>

    <br><br>
    <?php

    
}

// Download database
function Down($u,$f = 0)
{
    if ($f == 0)
    {
    if (AccessType($u) == 0)
         die;
    }
    header('Content-Description: Download');
    header('Content-Type: application/octet-stream');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header(sprintf("Content-disposition: attachment;filename=%s",basename($u)));
    header('Content-Length: ' . filesize($u));
    readfile($u);
}

if (array_key_exists("newfolder",$_POST))
{
    $f = $_POST['newfolder'];
    $root = $_SESSION['current'];
    if (AccessType($root) !== 2)
        {
        $_SESSION['error'] = "Write access denied to folder $root.";
        }

    if (strstr($f,"/") === false && strstr($f,"\\") === false)
        {
            $fd = $root.'/'.$f;
            if (!mkdir($fd))
            {
                $lerr = LastError();
                $_SESSION['error'] = "Directory creation failed <b>$fd</b><br>$lerr.";
            }
            else
            {
                $_SESSION['success'] = "Directory <b>$fd</b> created successfully.";
            }
        }
    else
        {
            $_SESSION['error'] = "Write access denied to folder <b>$root</b>.";
        }
    
    die;
}


if (array_key_exists("deletefile",$_POST))
{
    $f = $_POST['deletefile'];

    $fuf = $_SESSION['current'].'/';
 
    if (AccessType($fuf) !== 2)
    {
        $_SESSION['error'] = "Write access denied to $f.";
    }

    if (strstr($f,"/") === false && strstr($f,"\\") === false)
    {
        if (!unlink($_SESSION['current'].'/'.$f))
        {
            $_SESSION['error'] = "Operation on <b>$f</b> failed.";
        }
        else
        {
            $_SESSION['success'] = "File <b>$f</b> deleted successfully.";
        }
    }
    else
    {
        $_SESSION['error'] = "Write access denied to <b>$f</b>.";
    }

    die;
}

if (array_key_exists("deletefolder",$_POST))
{
    $f = $_POST['deletefolder'];

    $fuf = $_SESSION['current'].'/';
 
    if (AccessType($fuf) !== 2)
    {
        $_SESSION['error'] = "Write access denied to $f.";
    }

    if (strstr($f,"/") === false && strstr($f,"\\") === false)
    {
        if (!rmdir($_SESSION['current'].'/'.$f))
        {
            $_SESSION['error'] = "Operation on <b>$f</b> failed.";
        }
        else
        {
            $_SESSION['success'] = "Folder <b>$f</b> deleted successfully.";
        }
    }
    else
    {
        $_SESSION['error'] = "Write access denied to <b>$f</b>.";
    }

    die;
}

if (array_key_exists("deletefolder2",$_POST))
{
    $f = $_POST['deletefolder2'];

    $fuf = $_SESSION['current'].'/';
 
    if (AccessType($fuf) !== 2)
    {
        $_SESSION['error'] = "Write access denied to $f.";
    }

    if (strstr($f,"/") === false && strstr($f,"\\") === false)
    {
        if (!deleteDir($_SESSION['current'].'/'.$f))
        {
            $_SESSION['error'] = "Operation on <b>$f</b> failed.";
        }
        else
        {
            $_SESSION['success'] = "Folder <b>$f</b> deleted successfully.";
        }
    }
    else
    {
        $_SESSION['error'] = "Write access denied to <b>$f</b>.";
    }

    die;
}

if (array_key_exists("massdownload",$_POST))
{
    $what = $_POST['massdownload'];
    $fuf = "";
    $dp = strrpos($_POST['massdownload'],"/");
    if ($dp === false)
        $fuf = $_SESSION['current'].'/';
    else
        $fuf = substr($_GET['down'],0,$dp);

    if (AccessType($fuf) === 0)
    {
        $_SESSION['error'] = "Read access denied to folder <b>$root</b>.";
    }
    else
    {
        $arr = array();
        $items = explode(',',$what);
        foreach($items as $item)
        {
            if (strstr($item,"/") == $item)
                die;
            if (strstr($item,"..") !== false)
                die;
            $full = $_SESSION['current'].'/'.$item;
            enumDir($full,$arr);
        }

        $tz = tempnam(".","zip");
        if (file_exists($tz))
            unlink($tz);
        $tz .= ".zip";
        if (file_exists($tz))
            unlink($tz);
        $zip = new ZipArchive;
        $zipo = $zip->open($tz,ZipArchive::CREATE | ZipArchive::OVERWRITE);
        foreach($arr as $a)
        {
            if (is_dir($a))
                continue;
        //          printf("<pre>%s</pre>",substr($a,2));
            $rs = $zip->addFile($a,substr($a,2));
            if (!$rs)
                die;
        }
        $zip->close();
        Down($tz,1);
        unlink($tz);
        die;
    }


}


if (array_key_exists("massdelete",$_POST))
{
    $what = $_POST['massdelete'];
    $fuf = "";
    $dp = strrpos($_POST['massdelete'],"/");
    if ($dp === false)
        $fuf = $_SESSION['current'].'/';
    else
        $fuf = substr($_GET['down'],0,$dp);

    $itd = "";
    if (AccessType($fuf) !== 2)
    {
        $_SESSION['error'] = "Write access denied to folder <b>$root</b>.";
    }
    else
    {
        $items = explode(',',$what);
        foreach($items as $item)
        {
            if (strstr($item,"/") == $item)
                die;
            if (strstr($item,"..") !== false)
                die;
            $full = $_SESSION['current'].'/'.$item;
            if (deleteDir($full))
                $itd .= sprintf("$full<br>");

        }
    }

    $_SESSION['success'] = "Mass delete operation completed:<br><br>$itd<br>Items deleted.";
    header("Location: $self");
    die;
}

if (array_key_exists("down",$_GET))
{
    $fuf = "";
    $dp = strrpos($_GET['down'],"/");
    if ($dp === false)
        $fuf = $_SESSION['current'].'/';
    else
        $fuf = substr($_GET['down'],0,$dp);

    if (AccessType($fuf) === 0)
    {
        $_SESSION['error'] = "Read access denied to folder <b>$root</b>.";
    }
    else
    {
        Down($_GET['down']);
        die;
    }
}

if (array_key_exists("dir",$_GET))
{
    PrintDir($_GET['dir']);
    die;
}



?>
<?php Head(); ?>
<body>

    <script>

    function confirm(pro,url) {
        bootbox.confirm(pro, function (result) {
            if (result)
                window.location = url;
        });
        }

    function confirm2(pro,xurl,xdata) {
        bootbox.confirm(pro, function (result) {
            if (result)
                {
                $.ajax({
                    url: xurl,
                    type: 'POST',
                    data: xdata,
                    success: function (result)
                    {
                    window.location = '<?= $self ?>';
                    }
                    });
                }
        });
        }

    function confirm3(pro,func) {
        bootbox.confirm(pro, function (result) {
            if (result)
                func();
        });
        }


    function DownloadSelected() {
        var z = "";
        var i = 0;
        $('.fcb').each(function(idx) 
            {
            if ($(this).prop('checked'))
                {
                var n = $(this).attr("data-name");
                if (i != 0)
                    z += ",";
                z += n;
                i++;
                }
            });

        if (i == 0)
            return;

        $('#massdownloadformvalue').val(z);
        $('#massdownloadform').submit();
        }


    function DeleteSelected() {
        var z = "";
        var i = 0;
        $('.fcb').each(function(idx) 
            {
            if ($(this).prop('checked'))
                {
                var n = $(this).attr("data-name");
                if (i != 0)
                    z += ",";
                z += n;
                i++;
                }
            });

        if (i == 0)
            return;

        $('#massdeleteformvalue').val(z);
        $('#massdeleteform').submit();
        }




    function pickall(cb)
    {
    $('.fcb').prop('checked', cb.checked);
    }

    function unblock()
        {
        $.unblockUI();
        }


    var dlg = null;
    var xhr = null;
	function updateProgress (oEvent)
	{
		if (oEvent.lengthComputable) {
			var percentComplete = (oEvent.loaded*100) / oEvent.total;
			var prg = document.getElementById("prg");
			if (!prg)
				return;
			if (percentComplete >= 99)
				percentComplete = 100;
			prg.value = percentComplete;
		} else {
			// Unable to compute progress information since the total size is unknown
		}
	}

    function SubmitForm()
    {
	var da = document.getElementById('uploaddiv');

    var formData = new FormData(document.getElementById('uploadform'));

	xhr = new XMLHttpRequest();
	da.innerHTML= "<i class=\"fa fa-circle-o-notch fa-spin\"></i> <progress id=\"prg\"  name=\"prg\" value=\"0\" max=\"100\"/>";
	xhr.upload.addEventListener("progress", function(evt)
		{
		updateProgress(evt);
		}
		, false);
	xhr.addEventListener("progress", function(evt)
		{
			updateProgress(evt);
     	}
		, false);
	xhr.onreadystatechange=function()
    	{
		if (xhr.readyState == 4)
	    	{
            bootbox.hideAll();
			if (xhr.status == 200)
				{
                // OK
                window.location = "<?= $self ?>";
                xhr = null;
				}
				else
				{
                // FAIL
                xhr = null;
				}

			}
		}
	xhr.open("POST", "<?= $self ?>");
	xhr.send(formData);
	return false;    
    }

    function newfile()
    {
    dlg = bootbox.dialog({
        message: '<h3>File upload</h3><hr><div id="uploaddiv"> <form id="uploadform" method="POST" onsubmit="return SubmitForm();" enctype="multipart/form-data"><input type="file" name="file" id="file" class="form-control" required><br><button id="submitbutton" class="btn btn-primary">Submit</button></form></div>',
        show: false,
        className: "modal2",
         onEscape: function() 
            {
            // you can do anything here you want when the user dismisses dialog
            if (xhr != null)
                xhr.abort();
            xhr = null;
            }
    });
    dlg.modal('show');
    }

    function newfilezip()
    {
    dlg = bootbox.dialog({
        message: '<h3>ZIP upload</h3><hr><div id="uploaddiv"> <form id="uploadform" method="POST" onsubmit="return SubmitForm();" enctype="multipart/form-data"><input type="hidden" name="zip" value="1"><input type="file" name="file" id="file" accept=".zip" class="form-control" required><br><button id="submitbutton" class="btn btn-primary">Submit</button></form></div>',
        show: false,
        className: "modal2",
         onEscape: function() 
            {
            // you can do anything here you want when the user dismisses dialog
            if (xhr != null)
                xhr.abort();
            xhr = null;
            }
    });
    dlg.modal('show');
    }

    function newfolder()
    {
        bootbox.prompt("New folder name:",
            function(result)
            {
            if (!result)
                return;
            if (result.length > 0)
                {
                $.ajax({
                  url: '<?= $self ?>',
                    type: 'POST',
                    data: { newfolder:result},
                    success: function (result)
                    {
                    window.location = '<?= $self ?>';
                    }
                    });

                }
            });
        }


    

    function g(url,div = "#content")
    {
        //block();
        $(div).html('<br><center><i class="fa fa-circle-o-notch fa-spin fa-4x"></i></center></br>');
        $.ajax({
            url: url,
            success: function (result)
                {
                unblock();
                $(div).css("height", '');
                $(div).html(result);

                var dt = $('#datatable');
                if (dt)
	                dt.dataTable({
		            dom: 'Brt',
		            paging: false,
		            bInfo: false,
		            fixedHeader: true,
		            responsive: true,
		            buttons: [],
		            aaSorting: []
	            });
               }
        });
    }
    function block()
    {
        $.blockUI({ message: '<button class="btn btn-default btn-lg"><i class="fa fa-circle-o-notch fa-spin"></i> Loading...</button>', css: {
            border: 'none',
            padding: '15px',
            backgroundColor: '#000',
            '-webkit-border-radius': '10px',
            '-moz-border-radius': '10px',
            opacity: .5,
            color: '#fff'
        } });

    }



    </script>

    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="<?= $self ?>">PHP File Manager (<?= $puser ?>)</a>
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">


                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-sticky-note-o"></i> New <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-alerts">
                        <li>
                            <a href="javascript:newfolder();">
                                <div>
                                    <i class="fa fa-folder fa-fw"></i>
                                    Folder
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="javascript:newfile();">
                                <div>
                                    <i class="fa fa-file fa-fw"></i>
                                    File
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="javascript:newfilezip();">
                                <div>
                                        <i class="fa fa-file-archive-o fa-fw"></i>
                                    ZIP Archive
                                </div>
                            </a>
                        </li>
                    </ul>
                    <!-- /.dropdown-messages -->
                </li>


                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i> <?= $user ?> <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="javascript:g('<?= $self ?>?profile');"><i class="fa fa-user fa-fw"></i> User Profile</a>
                        </li>
                        <?php
                        if ($users[$user]['admin'] == 1)
                            {
                            ?>
                                <li class="divider"></li>
                                <li><a href="javascript:g('<?= $self ?>?options');"><i class="fa fa-gear fa-fw"></i> Options</a>
                                </li>
                                <li class="divider"></li>
                                <li><a href="javascript:g('<?= $self ?>?createprofile');"><i class="fa fa-user-o fa-fw"></i> New Profile</a>
                                </li>
                            <?php
                            }
                        ?>
                        <?php
                        if ($loginmethod == 2)
                            {
                            ?>
                                <li class="divider"></li>
                                <li><a href="<?= $self ?>?logout"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                                </li>
                            <?php
                            }
                        ?>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->
            <!-- /.navbar-static-side -->
        </nav>
            <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->
    <?php
    PrintSessionErrors();
    ?>
    <div id="content">


    <script>
    g('<?= $self ?>?dir=<?= $_SESSION['current'] ?>');
    </script>




    </div>

<div id="filemenu" style="display:none;" class="dropdown clearfix">
    <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu" style="display:block;position:static;margin-bottom:5px;">
        <li>
            <a id="downloadfilelink" tabindex="-1" href="#">Download</a>
        </li>
        <li class="divider"></li>
        <li>
            <a id="renamefilelink" tabindex="-1" href="#">Rename</a>
        </li>
        <li>
            <a id="deletefilelink" tabindex="-1" href="#">Delete</a>
        </li>
        <li class="divider"></li>
        <li>
            <a tabindex="-1" href="#">Cancel</a>
        </li>
    </ul>
</div>

    <div id="foldermenu" style="display:none;" class="dropdown clearfix">
        <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu" style="display:block;position:static;margin-bottom:5px;">
            <li>
                <a id="deletefolderlink" tabindex="-1" href="#">Delete</a>
            </li>
            <li>
                <a id="deletefolderlink2" tabindex="-1" href="#">Delete with all contents</a>
            </li>
            <li class="divider"></li>
            <li>
                <a tabindex="-1" href="#">Cancel</a>
            </li>
        </ul>
    </div>

<script>
$(function() {

  var $contextMenu = $("#filemenu");

  $("body").on("contextmenu", ".filemenu", function(e) 
    {
    var n = $(this).attr("data-name");
    var dox = '<?= $self ?>?down=' + n;
    $('#downloadfilelink').attr("href",dox);
    var dox2 = '<?= $self ?>';
    dox = "javascript:confirm2('Sure to delete <b>" + n + "</b>?'," + "\"" + dox2 + "\"" + "," + "{ deletefile: " + "\"" +  n + "\"" + "}" + ")";
    $('#deletefilelink').attr("href",dox);
    $contextMenu.css({      display: "block",      left: e.pageX,      top: e.pageY    });
    return false;
    });

  $contextMenu.on("click", "a", function() {     $contextMenu.hide();  });

  var $contextMenu2 = $("#foldermenu");

  $("body").on("contextmenu", ".foldermenu", function(e)
    {
    var n = $(this).attr("data-name");
    var dox = '<?= $self ?>?down=' + n;
    $('#downloadfilelink').attr("href",dox);
    var dox2 = '<?= $self ?>';
    dox = "javascript:confirm2('Sure to delete <b>" + n + "</b>?'," + "\"" + dox2 + "\"" + "," + "{ deletefolder: " + "\"" +  n + "\"" + "}" + ")";
    $('#deletefolderlink').attr("href",dox);
    dox2 = '<?= $self ?>';
    dox = "javascript:confirm2('ABSOLUTELY Sure to delete <b>" + n + "</b> AND ALL ITS CONTENTS?'," + "\"" + dox2 + "\"" + "," + "{ deletefolder2: " + "\"" +  n + "\"" + "}" + ")";
    $('#deletefolderlink2').attr("href",dox);
    $contextMenu2.css({      display: "block",      left: e.pageX,      top: e.pageY    });
    return false;
    });

  $contextMenu2.on("click", "a", function() {     $contextMenu2.hide();  });


});
</script>
</body>
</html>

