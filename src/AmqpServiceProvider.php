<?php

namespace Colors\Amqp;

use Illuminate\Support\ServiceProvider;

class AmqpServiceProvider extends ServiceProvider
{
    /** 
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {   
        $this->app->bind('Amqp', 'Colors\Amqp\Amqp');
        if (!class_exists('Amqp')) {
            class_alias('Colors\Amqp\Facades\Amqp', 'Amqp');
        }   

        //$this->app->bind('Amqp', 'App\Tools\Amqp\Amqp');
        //if (!class_exists('Amqp')) {
            //class_alias('App\Tools\Amqp\Facades\Amqp', 'Amqp');
        //} 
    }   

    /** 
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {   
        //$this->app->singleton('App\Tools\Amqp\Publisher', function ($app) {
            //$obj = new Publisher(config());
            //$obj->connect();
            //return $obj;
        //});
    }
}
