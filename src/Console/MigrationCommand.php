<?php 
namespace WPINT\Framework\Console;

use Wpint\Support\Facades\CLI;
use Wpint\Support\Facades\Migration;

class MigrationCommand extends Command
{

    public string $command = 'migrate';

    /**
     * command logic
     *
     * @param [type] $args
     * @param [type] $assoc_args
     * @return void
     */
    public function handle($args, $assoc_args)
    {
        if($args)
            $this->{$args[0]}(); 
    }

    /**
     * migrate up
     *
     * @return void
     */
    private function up()
    {
        CLI::log("droping the tables ....");
        Migration::up();
        CLI::success("Tables has created successfuly.");
    }
    
    /**
     * migrate down
     * 
     *
     * @return void
     */
    private function down()
    {
        CLI::log("Removing the tables ....");
        Migration::down();
        CLI::success("Tables has removed successfuly.");
    }

    /**
     * migrate refresh
     *
     * @return void
     */
    private function refresh()
    {
        CLI::log("Refreshing the database ....");
        Migration::refresh();
        CLI::success("Your database has cleaned successfuly.");
    }

}       
