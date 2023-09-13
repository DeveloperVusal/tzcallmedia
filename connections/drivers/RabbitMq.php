<?php
namespace Connections\Drivers;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Channel\AMQPChannel;

final class RabbitMq {

    private AMQPChannel $channel;
    private AMQPStreamConnection $connection;
    
    public function __construct(string $host, int $port, string $user, string $passwd)
    {
        $this->connection = new AMQPStreamConnection($host, $port, $user, $passwd);
        $this->channel = $this->connection->channel();
    }

    public function channel(): AMQPChannel
    {
        return $this->channel;
    }

    public function close()
    {
        $this->channel->close();
        $this->connection->close();
    }
}