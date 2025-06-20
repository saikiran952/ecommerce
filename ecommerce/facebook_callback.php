<?php
require 'vendor/autoload.php';

use League\OAuth2\Client\Provider\Facebook;

session_start();

$provider = new Facebook([
    'clientId'        => 'YOUR_FACEBOOK_APP_ID',
    'clientSecret'    => 'YOUR_FACEBOOK_APP_SECRET',
    'redirectUri'     => 'http://localhost/facebook_callback.php',
    'graphApiVersion' => 'v17.0',
]);

try {
    $accessToken = $provider->getAccessToken('authorization_code', [
        'code' => $_GET['code']
    ]);

    $user = $provider->getResourceOwner($accessToken);
    $fbUser = $user->toArray();

    $_SESSION['user_email'] = $fbUser['email'];
    header('Location: dashboard.php');
    exit();

} catch (Exception $e) {
    exit('Facebook login failed: ' . $e->getMessage());
}
