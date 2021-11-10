<?php
require __DIR__ . '/vendor/autoload.php';

use Dotenv\Dotenv;
use TwitterWrap\Client;
use TwitterWrap\Credentials\UserCredentials;

$dotenv = Dotenv::createMutable(__DIR__);
$dotenv->load();

echo  $_ENV['TWITTER_CONSUMER_KEY'];

/*$credentials = new UserCredentials(
    $_ENV['TWITTER_CONSUMER_KEY'],
    $_ENV['TWITTER_CONSUMER_SECRET'],
    null,
    null,
    $_ENV['TWITTER_CALLBACK_URL']
);
$client = new Client($credentials);

$app = $client->connect();
$redirectUrl = $app->getRedirectUrlForAuth();

header('Location: ' . $redirectUrl, true, 301);
die();*/