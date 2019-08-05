<?php

//chroot(dirname(__DIR__));
use GuzzleHttp\Client;

require '../vendor/autoload.php';

$client = new Client();
define('TOKEN', '711874680:AAGjVbWznVJOoV-3PpTDnxC-IbqaXRICb9Y');
define('URL', 'https://api.telegram.org/bot' . TOKEN . '/');

$body = $client->post(URL . 'setWebhook', [
    'multipart' => [
        'name'     => 'certificate',
        'contents' => file_get_contents(''),
    ],
])->getBody();

syslog(LOG_ERR, print_r($body, true));
