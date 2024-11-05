<?php 
namespace WPINT\Framework\Console;

use ReflectionClass;
use Wpint\Support\Exceptions\MethodDoesNotExistException;
use Wpint\Support\Facades\CLI;

abstract class Command
{

    /**
     * Command base name
     *
     * @var string
     */
    public string $command;

    /**
     * command logic
     *
     * @param [type] $args
     * @param [type] $assoc_args
     * @return void
     */
    public function __invoke($args, $assoc_args)
    {
        if( ! $this->command ) CLI::error('Provided command doesn`t exists');
        if( ! $args && !$assoc_args) return $this->help();

        $method = $args[0];
        if(method_exists($this, $method))
        {   
            if($assoc_args) $this->flagsToProperties($assoc_args);
            return $this->$method();
        }else{
            CLI::confirm('Provided subcommand doesn\'t exist, Need help?');
            return $this->help();
        }

    }

    /**
     * Make a call to a static method of the Command class.
     *
     * @param [type] $name
     * @param [type] $arguments
     * 
     * @throws MethodDoesNotExistException
     * @return void
     */
    public static function __callStatic($name, $arguments)
    {

        if(!method_exists(get_called_class(), $name))
        {
            throw new MethodDoesNotExistException($name, __CLASS__);
        }   
        self::$name($arguments); 
    }

    /**
     * Make a call to a method of the Command class.
     *
     * @param [type] $name
     * @param [type] $arguments
     * 
     * @throws MethodDoesNotExistException
     * @return void
     */
    public function __call($name, $arguments)
    {
        if(!method_exists(get_called_class(), $name))
        {
            throw new MethodDoesNotExistException($name, __CLASS__);
        }   
        
        $this->$name($arguments);
    }


    
    /**
     * Help method for the command
     *
     * @return void
     */
    public function help()
    {
        CLI::log( ' --------------- ' . $this->command . ' help --------------- ' );
        $command = new ReflectionClass($this);
        $methods = collect($command->getMethods()); 
        CLI::log(CLI::colorize("%YProvided subcommands for {$this->command}: %n"));
        $methods->each(function($m){
            $atts = $m->getAttributes(SubCommandAttribute::class);
            if(count($atts) > 0)
            {
                $text = CLI::colorize("%G ".$m->getName()." %n") ;
                foreach($atts as $att)
                {
                    $instance = $att->newInstance();
                    $descArg = $instance->description ?? ' ';
                    $text .= ' ' . $descArg;
                }
                CLI::log($text);
            }
        });
    }

    /**
     * Convert Flags to command's class's property
     *
     * @param array $flags
     * @return void
     */
    protected function flagsToProperties(array $flags)
    {
        $command = new ReflectionClass($this);
        foreach($flags as $flag => $value)
        {
            if( $command->hasProperty($flag) === false ) CLI::error("the $flag flag doesn't exist in the provided command.");
            $this->{$flag} = $value ?? true;
        }
    }

}