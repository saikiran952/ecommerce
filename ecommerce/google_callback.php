<?php
require 'vendor/autoload.php';

use League\OAuth2\Client\Provider\Google;

session_start();

$provider = new Google([
    'clientId'     => 'YOUR_GOOGLE_CLIENT_ID',
    'clientSecret' => 'YOUR_GOOGLE_CLIENT_SECRET',
    'redirectUri'  => 'http://localhost/google_callback.php',
]);

if (isset($_GET['code'])) {
    $token = $provider->getAccessToken('authorization_code', [
        'code' => $_GET['code']
    ]);

    try {
        $user = $provider->getResourceOwner($token);
        $googleUser = $user->toArray();

        // Example: Use $googleUser['email'] to log in / register user
        $_SESSION['user_email'] = $googleUser['email'];
        header('Location: dashboard.php');
        exit();

    } catch (Exception $e) {
        exit('Failed to get user details: ' . $e->getMessage());
    }
}
