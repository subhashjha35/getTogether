<?php
session_start();
require_once __DIR__ . '/src/facebook-sdk-5/autoload.php';

$fb = new Facebook\Facebook([
    'app_id' => '1205338979587191',
    'app_secret' => 'dd35602eb311195f0100b4eeeae167b9',
    'default_graph_version' => 'v2.8',
]);
$helper = $fb->getRedirectLoginHelper();
$permissions = ['email', 'user_likes']; // optional
$loginUrl = $helper->getLoginUrl('http://localhost/getTogether/login-callback.php', $permissions);

echo '<a href="' . $loginUrl . '">Log in with Facebook!</a>';


?>
