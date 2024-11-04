<?php 
namespace WPINT\Framework\Console;

use Wpint\Support\Facades\CLI;
use Wpint\Support\Facades\WPFileDirect;

class VendorCommand extends Command
{

    /**
     * Command base name
     *
     * @var string
     */
    public string $command = 'vendor';

    /**
     * Command Provider class 
     */
    protected $provider;


    /**
     * migrate up
     *
     * @return void
     */
    #[SubCommandAttribute]
    protected function publish()
    {
        CLI::log("Publishing vendors' config....");
        if($this->provider)
        {
            if( ! $provider = app()->getProvider($this->provider)) CLI::error("Provided service doesn't exist.");
            if($provider::$publishGroups)
            {
                collect($provider::$publishGroups)->each(function($sources, $dest){
                    
                    if(is_array($sources))
                    {
                        foreach ($sources as $source) {
                            $basename = basename($source);
                            WPFileDirect::copy($source, $dest . '/' . $basename, true);
                        }
                    }
                    
                });

            }
            CLI::success("$this->provider's configs have been published successfuly.");
        }
        else {
            CLI::warning("Please specify a Provider class by the --provider flag");
        }
    }

}       
