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

if (!isset($_GET['code'])) {
    $authUrl = $provider->getAuthorizationUrl([
        'scope' => ['email']
    ]);
    $_SESSION['oauth2state'] = $provider->getState();
    header('Location: ' . $authUrl);
    exit;
} elseif (empty($_GET['state']) || $_GET['state'] !== $_SESSION['oauth2state']) {
    unset($_SESSION['oauth2state']);
    exit('Invalid state');
}
