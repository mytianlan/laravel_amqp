<?php
namespace App\Services\Common\Amqp;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use Config;

class Connection 
{
    private $_connection;
    private $_channel;

    public function connect($conn='basic')
    {
        if (!$conn) {
            $conn = 'basic';
        }
        $conf = Config::get('amqp.' . $conn);
        $this->_connection = new AMQPStreamConnection(
            $conf['host'],
            $conf['port'],
            $conf['username'],
            $conf['password'],
            $conf['vhost']
        );

        $this->_channel = $this->_connection->channel();
    }

    protected function getChannel()
    {
        return $this->_channel;
    }
}
