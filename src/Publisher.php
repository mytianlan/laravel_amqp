<?php
namespace Colors\Amqp;

use PhpAmqpLib\Message\AMQPMessage;
use Config;

class Publisher extends Connection
{

    public function publish($message, $exchange, $routing='')
    {
        $msg = new AMQPMessage($message, array('content_type' => 'text/plain', 'delivery_mode' => 2));
        $this->getChannel()->basic_publish($msg, $exchange, $routing);
    }
}
