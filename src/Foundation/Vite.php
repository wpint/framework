<?php

namespace WPINT\Framework\Foundation;

use Illuminate\Support\Facades\Blade;

class Vite
{

    /**
     * The build direction
     *
     * @var string
     */
    protected static string $outDir = 'resources/scripts/dist';

    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     * @var string
     */
    protected static  string $rootView =   'app';

    /**
     * The root ID in the rootView.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     * @var string
     */
    protected string $rootID =   'app';

    /**
     * Vite's host
     *
     * @var string
     */
    protected string $host = 'http://localhost';

    /**
     * Vites's port
     *
     * @var [type]
     */
    protected string $port = '5173';

    /**
     * Thze Vite's typescript configuration
     *
     * @var boolean
     */
    protected $typescript = false;

    /**
     * Register Vite to theapplication
     *
     * @return void
     */
    public function __construct()
    {

        // blade directive based on env
        Blade::directive('script', function () {
            return $this->scriptElements();
        });

        Blade::directive('root', function () {
            return $this->rootElement();
        });
    }

    /**
     * Root HTML element 
     *
     * @return void
     */
    public function rootElement()
    {
        return '<div id="'.$this->rootID().'" data-page="{{ json_encode($page) }}"></div>';
    }

    /**
     * Script HTML element
     *
     * @return void
     */
    public function scriptElements()
    {
        if(env('APP_ENV') === 'local')
        {
            $connection = $this->connection();
            $root = $this->root();
            return <<<EOT
                <script type="module">
                import RefreshRuntime from '$connection/@react-refresh'
                RefreshRuntime.injectIntoGlobalHook(window)
                window.\$RefreshReg$ = () => {}
                window.\$RefreshSig$ = () => (type) => type
                window.__vite_plugin_react_preamble_installed__ = true
                </script>
                <script type="module" src="$connection/@vite/client"></script>
                <script type="module" src="$connection/resources/scripts/src/$root"></script>
                <?php if (isset(\$page) && isset(\$page['headManager']) && \$page['headManager']->tags()): ?>
                    <?= \$page['headManager']->tags(); ?>
                <?php endif; ?>
            EOT;
        }
    }
 
    /**
     * Root View with extention
     *
     * @return void
     */
    private  function root()
    {
        return $this->isTypescript() ? $this->rootView() . '.tsx' : $this->rootView() . '.jsx';
    }

    /**
     * Host and port setup
     *
     * @return void
     */
    private  function connection()
    {
        return $this->host().":".$this->port();
    } 

    /**
     * server Host 
     *
     * @return void
     */
    private function host()
    {
        return env('VITE_HOST', $this->host);   
    }

    /**
     * server port
     *
     * @return void
     */
    private function port()
    {
        return env('VITE_PORT', $this->port);   
    }
    
    /**
     * Is typescript or not
     *
     * @return boolean
     */
    private function isTypescript()
    {
        return env('VITE_TYPESCRIPT', $this->typescript);   
    }
    
    /**
     * Root ID
     *
     * @return void
     */
    private function rootID()
    {
        return env('VITE_ROOT_ID', $this->rootID);   
    }

    /**
     * Root View
     *
     * @return void
     */
    public static function rootView()
    {
        return env('VITE_ROOT_VIEW', self::$rootView);   
    }

    /**
     * Vite's Output Directory 
     *
     * @return void
     */
    public static function outDir()
    {
        return env('VITE_OUT_DIR', self::$outDir);   
    }
}