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

    if ($rand == 0) {
        $txt = 'Ебать ты лох, убил сам себя!';
        $client->post(URL . 'sendPhoto', [
            'json' => [
                'chat_id' => $chat->id,
                'photo'   => "https://memepedia.ru/wp-content/uploads/2017/04/%D0%B5%D0%B1%D0%B0%D1%82%D1%8C-%D1%82%D1%8B-%D0%BB%D0%BE%D1%85-%D0%BE%D1%80%D0%B8%D0%B3%D0%B8%D0%BD%D0%B0%D0%BB.jpg",
            ],
        ]);
    }

    if ($rand > 0 && $rand <= 10) {
        $txt = 'От же дидько, сам себя решил пиздануть!';
    }

    if ($rand > 10 && $rand <= 20) {
        $txt = 'Промах, лох!';
    }

    if ($rand > 20 && $rand <= 80) {
        $txt = 'Думаэшь?';
    }

    if ($rand > 80 && $rand <= 90) {
        $txt = 'Кританул, пидор!';
    }

    if ($rand > 90 && $rand <= 98) {
        $txt = 'Кританул, обоссышь, двойной урон!';
    }

    if ($rand == 100) {
        $txt = 'Убил к хуям, афелка!';
    }

    if ($rand == 99) {
        $client->post(URL . 'sendPhoto', [
            'json' => [
                'chat_id' => $chat->id,
                'photo'   => "https://memepedia.ru/wp-content/uploads/2017/04/%D0%B5%D0%B1%D0%B0%D1%82%D1%8C-%D1%82%D1%8B-%D0%BB%D0%BE%D1%85-%D0%BE%D1%80%D0%B8%D0%B3%D0%B8%D0%BD%D0%B0%D0%BB.jpg",
            ],
        ]);

        $txt = 'Ебать ты лох!';
    }

    $client->post(URL . 'sendMessage', [
        'json' => [
            'chat_id'             => $chat->id,
            'text'                => "{$rand} {$txt}",
            'reply_to_message_id' => $body->message->message_id,
        ],
    ]);
} else {
    if ($body->message->from->first_name == 'Гримлий') {
        $client->post(URL . 'sendMessage', [
            'json' => [
                'chat_id'             => $chat->id,
                'text'                => 'Завали ебало!',
                'reply_to_message_id' => $body->message->message_id,
            ],
        ]);
    }
}

syslog(LOG_ERR, print_r($body, true));
