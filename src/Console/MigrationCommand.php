<?php 
namespace WPINT\Framework\Console;

use Wpint\Support\Facades\CLI;
use Wpint\Support\Facades\Migration;

class MigrationCommand extends Command
{   

    /**
     * Command base name
     *
     * @var string
     */
    public string $command = 'migrate';

    /**
     * migrate up
     *
     * @return void
     */
    #[SubCommandAttribute]
    private function up()
    {
        CLI::log("Creating the tables ....");
        Migration::up();
        CLI::success("The tables has been created successfuly.");
    }
    
    /**
     * migrate down
     * 
     *
     * @return void
     */
    #[SubCommandAttribute]
    private function down()
    {
        CLI::log("Removing the tables ....");
        Migration::down();
        CLI::success("the tables has been removed successfuly.");
    }

    /**
     * migrate refresh
     *
     * @return void
     */
    #[SubCommandAttribute]
    private function refresh()
    {
        CLI::log("Refreshing the database ....");
        Migration::refresh();
        CLI::success("the database has been cleaned successfuly.");
    }

}       
