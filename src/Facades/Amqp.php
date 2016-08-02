<?php
namespace Colors\Amqp\Facades;

use Illuminate\Support\Facades\Facade;

class Amqp extends Facade
{
    protected static function getFacadeAccessor()
    {   
        return 'Colors\Amqp\Amqp';
    }   
}
