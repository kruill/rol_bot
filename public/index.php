<?php

//chroot(dirname(__DIR__));
use GuzzleHttp\Client;

require '../vendor/autoload.php';

$client = new Client();
define('TOKEN', '711874680:AAGjVbWznVJOoV-3PpTDnxC-IbqaXRICb9Y');

//$body = $client
//    ->get('https://api.telegram.org/bot' . TOKEN . '/getUpdates')
//    ->getBody()
//;
//
//print_r(json_decode($body));

syslog(LOG_ERR, print_r(json_decode(file_get_contents('php://input')), true));
