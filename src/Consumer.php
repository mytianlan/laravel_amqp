<?php
namespace Colors\Amqp;

use Closure;
use PhpAmqpLib\Exception\AMQPException;
use PhpAmqpLib\Exception\AMQPIOException;

class Consumer extends Connection
{
    private $_consumerTag = '';

    public function consume($queue, Closure $closure, $properties = [])
    {
        try {
            $object = $this;

            //queue: Queue from where to get the messages
            //consumer_tag: Consumer identifier
            //no_local: Don't receive messages published by this consumer.
            //no_ack: Tells the server if the consumer will acknowledge the messages.
            //exclusive: Request exclusive consumer access, meaning only this consumer can access the queue
            //nowait:
            //callback: A PHP Callback
            $this->_consumerTag = $this->getChannel()->basic_consume($queue, '', false, $properties['noAck'] ?? true, false, false, function ($message) use ($closure, $object) {
                    $closure($message, $object);
                }   
            );

            while(count($this->getChannel()->callbacks)) {
                $this->getChannel()->wait();
            }
        } catch (\Exception $e) {
            if ($e instanceof AMQPException) {
                return true;
            }

            if ($e instanceof AMQPIOException) {
                echo "AMQP catch AMQPIOException\n";
                $this->getChannel()->basic_cancel($this->_consumerTag);
                return true;
            }

            if ($e instanceof Exception\Stop) {
                return true;
            }
            throw $e; 
        }  
        return true;
    }


    /**
     * Acknowledges a message
     *
     * @param Message $message
     */
    public function acknowledge($message)
    {
        $message->delivery_info['channel']->basic_ack($message->delivery_info['delivery_tag']);
        if ($message->body === 'quit') {
            $message->delivery_info['channel']->basic_cancel($message->delivery_info['consumer_tag']);
        }
    }

    /**
     * Stops consumer when no message is left
     *
     * @throws Exception\Stop
     */
    public function stopWhenProcessed()
    {
        throw new Exception\Stop();
    }
}
