<?php 
namespace WPINT\Framework\Providers;

use WPINT\Framework\Foundation\Application;
use Illuminate\Http\Request;
use WPINT\Framework\ServiceProvider;

class RequestServiceProvider extends ServiceProvider
{
   
    /**
     * Register request service.
     *
     * @return void
     */
    public function register() : void 
    {
        $this->app->singleton('request', function(Application $app){
            return Request::capture();
        });
    }

}