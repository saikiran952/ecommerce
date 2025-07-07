<?php
require 'vendor/autoload.php';

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

session_start();

$client = new Google_Client();
$client->setClientId($_ENV['GOOGLE_CLIENT_ID']);
$client->setClientSecret($_ENV['GOOGLE_CLIENT_SECRET']);
$client->setRedirectUri($_ENV['GOOGLE_REDIRECT_URI']);
$client->addScope('email');
$client->addScope('profile');

if (isset($_GET['code'])) {
    try {
        $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);

        if (is_array($token) && !isset($token['error'])) {
            $client->setAccessToken($token['access_token']);

            $google_oauth = new Google_Service_Oauth2($client);
            $google_user = $google_oauth->userinfo->get();

            $_SESSION['user_email'] = $google_user->email;
            $_SESSION['user_name'] = $google_user->name;

            header('Location: index.php');
            exit;
        } else {
            $errorMsg = $token['error_description'] ?? 'Unknown error';
            echo "❌ Token error: " . htmlspecialchars($errorMsg);
        }
    } catch (Exception $e) {
        echo "❌ Exception: " . $e->getMessage();
    }
} else {
    echo "❌ No code received!";
}
