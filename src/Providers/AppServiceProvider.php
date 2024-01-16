<?php 
namespace WPINT\Framework\Providers;

use Illuminate\Config\Repository;
use WPINT\Framework\Foundation\Application;
use Illuminate\Support\ServiceProvider;

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