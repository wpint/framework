<?php 
namespace WPINT\Framework\Include;

use Illuminate\Support\Collection;
use ReflectionClass;
use WP_CLI;

class CLI extends WP_CLI
{

    /**
     * CLI commands
     *
     * @var array
     */
    protected $commands = [];

    /**
     * The construct method
     */
    public function __construct()
    {
        $commands = config('cli.commands');
        $this->commands = $commands;
    } 

    /**
     * Register commands
     *
     * @return void
     */
    public function register()
    {
        $this->commands()->each(function($c) 
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
            
            $this::add_command( $instance->command, $instance, $hooks );

        }); 
    }

    /**
     * Get collection of all CLI commands
     *
     * @return void
     */
    public function commands() : Collection
    {
        $this->getProvidersCommands();
        return collect($this->commands);
    }

    protected function getProvidersCommands()
    {
        $providers = config('app.providers');
            if($providers)
            {
                foreach($providers as $provider)
                {
                    $reflection = new ReflectionClass($provider);
                    if($reflection->hasProperty('commands'))
                    {
                        $this->commands = array_merge($this->commands, $provider::$commands);
                    }
                }
            }
    }

}