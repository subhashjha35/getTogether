<?php
    session_start();
    require_once __DIR__ . '/src/facebook-sdk-5/autoload.php';
    $fb = new Facebook\Facebook([
        'app_id' => '1205338979587191',
        'app_secret' => 'dd35602eb311195f0100b4eeeae167b9',
        'default_graph_version' => 'v2.8',
    ]);
    $helper = $fb->getRedirectLoginHelper();
    try {
        $accessToken = $helper->getAccessToken();
    } catch(Facebook\Exceptions\FacebookResponseException $e) {
        // When Graph returns an error
        echo 'Graph returned an error: ' . $e->getMessage();
        exit;
    } catch(Facebook\Exceptions\FacebookSDKException $e) {
        // When validation fails or other local issues
        echo 'Facebook SDK returned an error: ' . $e->getMessage();
        exit;
    }

    if (isset($accessToken)) {
        // Logged in!
        $_SESSION['facebook_access_token'] = (string) $accessToken;
        echo $_SESSION['facebook_access_token'];
        // Now you can redirect to another page and use the
        // access token from $_SESSION['facebook_access_token']
    }

?>