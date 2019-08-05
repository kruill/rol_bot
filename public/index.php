<?php

//chroot(dirname(__DIR__));
use GuzzleHttp\Client;

require '../vendor/autoload.php';

$client = new Client();
define('TOKEN', '711874680:AAGjVbWznVJOoV-3PpTDnxC-IbqaXRICb9Y');
define('URL', 'https://api.telegram.org/bot' . TOKEN . '/');

$body = json_decode(file_get_contents('php://input'));
$chat = $body->message->chat;

function primeCheck($number) {
    if ($number == 1) {
        return 0;
    }
    for ($i = 2; $i <= $number / 2; $i++) {
        if ($number % $i == 0) {
            return 0;
        }
    }

    return 1;
}

if ($body->message->text == '/roll') {
    $rand = rand(0, 100);

    $txt = '';
    if ($rand % 2) {
        $txt = 'Пизда те жирный!';
    }

    if (primeCheck($rand)) {
        $txt = 'Простое число, всех уебал, бежим!';
    }

    if ($rand == 0) {
        $txt = 'Тобi пiзда, тiкай з хаты!';
    }

    if ($rand == 100) {
        $txt = 'Ахуел?';
    }

    $client->post(URL . 'sendMessage', [
        'json' => [
            'chat_id' => $chat->id,
            'text'    => "{$rand} {$txt}",
        ],
    ]);
} else {
    if ($body->message->from->first_name == 'Гримлий') {
        $client->post(URL . 'sendMessage', [
            'json' => [
                'chat_id' => $chat->id,
                'text'    => 'Завали ебало!',
            ],
        ]);
    }
}

syslog(LOG_ERR, print_r($body, true));
