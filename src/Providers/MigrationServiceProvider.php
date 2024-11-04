<?php 
namespace WPINT\Framework\Providers;

use WPINT\Framework\Foundation\Application;
use WPINT\Framework\Include\Migration\Migration;
use WPINT\Framework\ServiceProvider;

class MigrationServiceProvider extends ServiceProvider
{
   
    /**
     * Register migration service.
     *
     * @return void
     */
    public function register() : void 
    {
        $this->app->singleton('migration', function(Application $app){
            return  new Migration();
        });
    }

}