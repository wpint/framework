<?php 
namespace WPINT\Framework\Providers;

use WPINT\Framework\Foundation\Application;
use WPINT\Framework\ServiceProvider;
use Symfony\Component\Dotenv\Dotenv;

class EnvServiceProvider extends ServiceProvider
{
   
    /**
     * Register env service.
     *
     * @return void
     */
    public function register() : void 
    {
        $this->app->singleton('env', function(Application $app){
            return new Dotenv();
        });
    }


    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        app('env')->load(config('app.plugin_path').'/.env');
    }

}