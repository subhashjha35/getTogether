<?php
session_start();

//Include Google client library
include_once 'src/Google/Google_Client.php';
include_once 'src/Google/contrib/Google_Oauth2Service.php';
require_once 'src/Google/contrib/Google_PlusService.php';

/*include_once 'src/Google/autoload.php';*/

/*
 * Configuration and setup Google API
 */
$clientId = '173021924352-rqq4ebapt36nn34v3j1m4kdgs2c7tnin.apps.googleusercontent.com';
$clientSecret = 'bJYPhc4eYOPD50a1SxxJyqJC';
$redirectURL = 'http://localhost/login_with_google_using_php/';
$key="AIzaSyDfVgKCYJRH7eqm-1oOZD3Pekb2MgR9xXg";
//Call Google API
$gClient = new Google_Client();
$gClient->setApplicationName('Login to Get Together');
$gClient->setClientId($clientId);
$gClient->setClientSecret($clientSecret);
$gClient->setRedirectUri($redirectURL);

$google_oauthV2 = new Google_Oauth2Service($gClient);
?>