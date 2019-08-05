<?php

//chroot(dirname(__DIR__));
use GuzzleHttp\Client;

require '../vendor/autoload.php';

$client = new Client();
define('TOKEN', '711874680:AAGjVbWznVJOoV-3PpTDnxC-IbqaXRICb9Y');
define('URL', 'https://api.telegram.org/bot' . TOKEN . '/');

$body = json_decode(file_get_contents('php://input'));
$chat = $body->message->chat;

$client->post(URL . 'sendMessage', [
    'json' => [
        'chat_id' => $chat->id,
        'text'    => rand(0, 100),
    ],
]);

