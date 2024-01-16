<?php 
namespace WPINT\Framework\Console;

use Wpint\Contracts\Console\ConsoleContract;
use Wpint\Support\Facades\CLI;

class DatabaseCommand extends Command implements ConsoleContract
{

    public string $command = 'database';

    private $class = null;

    /**
     * command logic
     *
     * @param [type] $args
     * @param [type] $assoc_args
     * @return void
     */
    public function handle($args, $assoc_args)
    {

        $this->class =  isset($assoc_args['class']) ? $assoc_args['class'] : null ;

        if($args)
            $this->{$args[0]}(); 
    }


    /**
     * db Seed command
     * fill the database with your DatabaseSeeder::Class
     *  
     * @return void
     */
    private function seed()
    {
        
        CLI::log("Seeding the database ....");
        
        if($this->class)
            class_exists($class = "\\Database\\Seeders\\".$this->class) ? app($class)->run() :   CLI::error( $this->class ." not found.");
        else
            app(\Database\Seeders\DatabaseSeeder::class)->run();
        
        CLI::success("Your database has seeded successfuly.");
    }
    



}       
