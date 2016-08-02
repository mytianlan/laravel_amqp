<?php
namespace Colors\Amqp;

use App;
use Closure;

class Amqp
{
    private $_publisher;
    private $_consumer;
    private $_conn;

    public function __construct()
    {
        //$this->_publisher = App::make('\App\Tools\Amqp\Publisher');
        //$this->_publisher->connect();
        //$this->_consumer = App::make('\app\tools\amqp\consumer');
        //$this->_consumer->connect();
    }

    public function connection($conn)
    {
        $this->_conn = $conn;
        return $this;
    }

    public function publish($message, $exchange, $routing='')
    {
        if (!$this->_publisher) {
            $this->_publisher = App::make('namespace Colors\Amqp\Publisher');
            $this->_publisher->connect($this->_conn);
        }
        $this->_publisher->publish($message, $exchange, $routing);
    }

    /**
     * @param string  $queue
     * @param Closure $callback
     * @param array   $properties
     * @throws Exception\Configuration
     */
    public function consume($queue, Closure $callback, $properties = [])
    {
        if (!$this->_consumer) {
            $this->_consumer = App::make('namespace Colors\Amqp\Consumer');
            $this->_consumer->connect($this->_conn);
        }
        $properties['queue'] = $queue;  

        /* @var Consumer $consumer */   
        //$consumer
            //->mergeProperties($properties)  
            //->setup();

        $this->_consumer->consume($queue, $callback);
    }
}
