<?php
require 'vendor/autoload.php';

use League\OAuth2\Client\Provider\Google;

session_start();

$provider = new Google([
    'clientId'     => 'YOUR_GOOGLE_CLIENT_ID',
    'clientSecret' => 'YOUR_GOOGLE_CLIENT_SECRET',
    'redirectUri'  => 'http://localhost/google_callback.php',
]);

if (!isset($_GET['code'])) {
    // Redirect to Google
    $authUrl = $provider->getAuthorizationUrl();
    $_SESSION['oauth2state'] = $provider->getState();
    header('Location: ' . $authUrl);
    exit;
} elseif (empty($_GET['state']) || $_GET['state'] !== $_SESSION['oauth2state']) {
    unset($_SESSION['oauth2state']);
    exit('Invalid state');
}
