<?php 
namespace WPINT\Framework\Providers;

use WPINT\Framework\Foundation\Application;
use Illuminate\Config\Repository;
use Illuminate\Support\ServiceProvider;

class ConfigServiceProvider extends ServiceProvider
{
   
    /**
     * Register App's config service.
     *
     * @return void
     */
    public function register() : void 
    {
        $this->app->singleton('config', function(Application $app){
            return $app['config'];
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $file = $this->app->make('file.direct');
        $path = WPDF_PLUGIN_PATH . '/Config';
        $configs = $file->dirlist($path);
        $repository = new Repository();
        foreach ($configs as $key => $value) {
            $data = include "$path/$key";
            $key = explode('.', $key);
            $repository->set($key[0], $data);
        }
        $this->app->instance('config', $repository);
    }

}