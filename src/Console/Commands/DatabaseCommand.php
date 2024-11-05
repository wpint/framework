<?php 
namespace WPINT\Framework\Console\Commands;

use WPINT\Framework\Console\Command;
use WPINT\Framework\Console\CommandAttribute;
use WPINT\Framework\Console\SubCommandAttribute;
use Wpint\Support\Facades\CLI;

#[CommandAttribute(['shortdesc' => 'WPINT: database related command'])]
class DatabaseCommand extends Command
{

    /**
     * Base Command name
     *
     * @var string
     */
    public string $command = 'database';

    /**
     * The target class
     *
     * @var [type]
     */
    private $class = null;

    /**
     * db Seed command
     * fill the database with your DatabaseSeeder::Class
     *  
     * @return void
     */
    #[SubCommandAttribute('runs exsiting seeders in wpint framework')]
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
