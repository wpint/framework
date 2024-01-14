<?php 
namespace WPINT\Framework\Providers;

use Illuminate\Support\ServiceProvider;
use ReflectionClass;

class ConsoleServiceProvider extends ServiceProvider
{
   
    /**
     * Register Applicatin's service.
     *
     * @return void
     */
    public function register() : void 
    {
        // nothing yet
    }

    public function boot() : void
    {
        $cli = $this->app->make('cli');
        $commands = $this->app->make('config')->get('CLI');
        $commands = collect($commands['commands']);
        $commands->each(function($c) use ($cli) 
        {
            $class = new ReflectionClass($c);
            $instance = $class->newInstance();
            $methods = Collect($class->getMethods());
            
            $hooks = $methods->filter(function($m) {
                preg_match("/^hook_(\w+)/", $m->name, $match);
                if($match) {
                    $m->hook = $match[1];
                    return $m;
                };

            })->mapWithKeys(function($m, $key) use ($instance) {
                return [
                    $m->hook => [$instance, $m->name]
                ];
            })->all();
            
            $cli::add_command( $instance->command, [$instance, "handle"], $hooks );

        });
    }

}