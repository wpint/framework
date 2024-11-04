<?php 
namespace WPINT\Framework\Providers;

use WPINT\Framework\Foundation\Application;
use WPINT\Framework\ServiceProvider;
use WP_Filesystem_Direct;

class FileDirectServiceProvider extends ServiceProvider
{
   
    /**
     * Register wp filesystem service.
     *
     * @return void
     */
    public function register() : void 
    {
        if( !class_exists( 'WP_Filesystem_Direct' ) ) {
            require_once ABSPATH . 'wp-admin/includes/class-wp-filesystem-base.php';
            require_once ABSPATH . 'wp-admin/includes/class-wp-filesystem-direct.php';
        }

        $this->app->singleton('wp.file.direct', function(Application $app){
            return  new WP_Filesystem_Direct([]);
        });
    }

}