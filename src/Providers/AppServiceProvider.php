<?php 
namespace WPINT\Framework\Providers;

use WPINT\Framework\Foundation\Application;
use WPINT\Framework\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
   
    /**
     * Register application Service.
     *
     * @return void
     */
    public function register() : void 
    {
        $this->app->instance('app', function(Application $app){
            return $app::getInstance();
        });
    }

    public function boot() : void
    {

    }

}