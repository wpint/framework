<?php 
namespace WPINT\Framework;

use Illuminate\Support\ServiceProvider as SupportServiceProvider;

class ServiceProvider extends SupportServiceProvider{

    /**
     * Provider's commands
     *
     * @var array
     */
    public static $commands = [];

    // Remove command method
    public function commands($commands)
    {
        return;   
    }
    
}