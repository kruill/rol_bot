<?php

use GuzzleHttp\Client;

chroot(dirname(__DIR__));
require 'vendor/autoload.php';
require_once 'vendor/simple-html-dom/simple-html-dom/simple_html_dom.php';

$client = new Client();
define('TOKEN', '711874680:AAGjVbWznVJOoV-3PpTDnxC-IbqaXRICb9Y');
define('URL', 'https://api.telegram.org/bot' . TOKEN . '/');

$body = json_decode(file_get_contents('php://input'));
$chat = $body->message->chat;

$mentioned = null;
if (isset($body->message->entities) && is_array($body->message->entities)) {
    $mentioned = $body->message->entities[0]->user->first_name ?? '';
}

syslog(LOG_ERR, var_export($mentioned, true));
syslog(LOG_ERR, print_r($body->message->entities, true));

$get_damn = function (string $name) use ($client) {
    $body = $client->get('https://damn.ru/?name=' . $name . '&sex=m')->getBody();

    return html_entity_decode(strip_tags((string)str_get_html($body)->find('div[class=damn]')[0]));
};
$cmd = explode(' ', $body->message->text)[0];

switch ($cmd) {
    case '/try':
        $user = $body->message->from->first_name;
        if ($mentioned) {
            $user = $mentioned;
        }

        $client->post(URL . 'sendMessage', [
            'json' => [
                'chat_id'             => $chat->id,
                'text'                => $get_damn($user),
                'reply_to_message_id' => $body->message->message_id,
            ],
        ]);
        break;

    case '/roll':
        $rand = rand(0, 100);
        $txt = '';

        $user = $body->message->from->first_name;
        if ($mentioned) {
            $user = $mentioned;
        }

        if ($rand == 0) {
            $txt = 'Ебать ты лох, убил сам себя!';
            $client->post(URL . 'sendPhoto', [
                'json' => [
                    'chat_id' => $chat->id,
                    'photo'   => "https://memepedia.ru/wp-content/uploads/2017/04/%D0%B5%D0%B1%D0%B0%D1%82%D1%8C-%D1%82%D1%8B-%D0%BB%D0%BE%D1%85-%D0%BE%D1%80%D0%B8%D0%B3%D0%B8%D0%BD%D0%B0%D0%BB.jpg",
                ],
            ]);
        } else {
            if ($rand == 100) {
                $txt = 'Убил к хуям, афелка!';
            } else {
                $txt = $get_damn($user);
            }
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
                'text'                => "Ролл - {$rand}. {$txt}",
                'reply_to_message_id' => $body->message->message_id,
            ],
        ]);
        break;

    default:
        //        $client->post(URL . 'sendMessage', [
//            'json' => [
//                'chat_id'             => $chat->id,
//                'text'                => 'Завали ебало!',
//                'reply_to_message_id' => $body->message->message_id,
//            ],
//        ]);
}

syslog(LOG_ERR, print_r($body, true));
