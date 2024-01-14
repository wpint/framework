<?php 
namespace WPINT\Framework\Include\Migration;

use Illuminate\Support\Facades\App;
use Wpint\Support\Facades\WPFileDirect;
use Wpint\Support\ClassExtractor;

/**
 * @method \WPINT\Framework\Services\Migration\Migration up()
 * @method \WPINT\Framework\Services\Migration\Migration down()
 * @method \WPINT\Framework\Services\Migration\Migration refresh()
 * 
 * @see \WPINT\Framework\Services\Migration\Migration
 */
class Migration 
{

    /**
     * Create and register all tables
     *
     * @return void
     */
    public static function up($classes = [])
    {

        if($classes)
        {
            collect($classes)->each(fn($class) => $class::up());
            return;
        } 

        $files = WPFileDirect::dirlist(self::dbDir());
        foreach ($files as $name => $meta) 
        {
            $class = ClassExtractor::getClassFromFile($name, self::dbDir());
            if($class)
            {
                $class::up();                               
            }

        }

    }

    /**
     * Drop all tables
     *
     * @return void
     */
    public static function down($classes = [])
    {

        if($classes) 
        {
            collect($classes)->each(fn($class) => $class::down());
            return;
        }

        $files = WPFileDirect::dirlist(self::dbDir());
        foreach ($files as $name => $meta) 
        {
            $class = ClassExtractor::getClassFromFile($name, self::dbDir());
            if($class)
            {
                $class::down();                               
            }

        }

    }

    /**
     * refresh all tables
     *
     * @param array $classes
     * @return void
     */
    public static function refresh($classes = []) : void
    {
        self::down($classes);
        self::up($classes);
    }

    /**
     * get migrations directory
     *
     * @return string
     */
    private static function dbDir() : string
    {
        return app()->databasePath() . '/Migrations';
    }

    
}
