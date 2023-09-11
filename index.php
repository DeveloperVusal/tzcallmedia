<?php
require_once('./registers.php');

use PhpAmqpLib\Message\AMQPMessage;

use Connections\Conn;

$dataRows = [
    'https://www.rabbitmq.com/',
    'https://www.rabbitmq.com/tutorials/tutorial-one-php.html',
    'https://callmedia.online/',
    'https://habr.com/en/',
    'https://github.com/',
    'https://clickhouse.com/',
    'https://clickhouse.com/docs/',
    'https://englex.ru/',
    'https://packagist.org/',
    'https://laravel.com/',
];
$rabbitMq = Conn::driver('\\Connections\\Drivers\\RabbitMq', 'localhost', 5672, 'guest', 'guest');

foreach ($dataRows as $url) {
    $msg = new AMQPMessage($url);
    $rabbitMq->channel()->basic_publish($msg, '', 'callmedia');

    $waitSeconds = random_int(5, 30);
    echo " [x] Sent {$url} -> wait {$waitSeconds}s\n";

    sleep(random_int(5, 30));
}

$rabbitMq->close();