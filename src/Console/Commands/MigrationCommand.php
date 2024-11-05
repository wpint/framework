<?php 
namespace WPINT\Framework\Console\Commands;

use WPINT\Framework\Console\Command;
use WPINT\Framework\Console\CommandAttribute;
use WPINT\Framework\Console\SubCommandAttribute;
use Wpint\Support\Facades\CLI;
use Wpint\Support\Facades\Migration;

#[CommandAttribute(['shortdesc' => 'WPINT: Migrate constructed tables in the wpint framework'])]
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
    #[SubCommandAttribute('Creates all tables that constructed in wpint framework')]
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
    #[SubCommandAttribute('Drops all tables that constructed in wpint framework')]
    private function down()
    {
        CLI::log("Dropint the tables ....");
        Migration::down();
        CLI::success("the tables has been droped successfuly.");
    }

    /**
     * migrate refresh
     *
     * @return void
     */
    #[SubCommandAttribute('Runs down and up commands respectively')]
    private function refresh()
    {
        CLI::log("Refreshing the database ....");
        Migration::refresh();
        CLI::success("the database has been cleaned successfuly.");
    }

}       
