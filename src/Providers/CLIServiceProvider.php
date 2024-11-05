<?php 
namespace WPINT\Framework\Providers;

use WPINT\Framework\Foundation\Application;
use WPINT\Framework\ServiceProvider;
use WPINT\Framework\Include\CLI;

class CLIServiceProvider extends ServiceProvider
{

    /**
     * Register CLI service.
     *
     * @return void
     */
    public function register() : void 
    {
        $this->app->singleton('cli', function(Application $app){
            return  new CLI();
        });
    }

    /**
     * Boot method
     *
     * @return void
     */
    public function boot() : void
    {
    
        $this->app->make('cli')->register();
    
    }

}