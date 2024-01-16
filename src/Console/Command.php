<?php 
namespace WPINT\Framework\Console;

use Wpint\Contracts\Console\ConsoleContract;
use Wpint\Support\Exceptions\MethodDoesNotExistException;

abstract class Command
{

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

}