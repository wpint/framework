<?php 
namespace WPINT\Framework\Include\Controller;

use WPINT\Framework\Include\Middleware\Handler;

abstract class BaseController
{

    /**
     * Middewares of the controller
     *
     * @var array
     */
    private $middleware = [];

    /**
     * Compact all the middlewares
     *
     * @param array $middleware
     * @return void
     */
    public function middleware(array $middleware = []) : self
    {
        for ($i=0; $i < count($middleware); $i++) { 
            $this->middleware[] = $middleware[$i];
        }
        return $this;
    }

    /**
     * Get The middlewares
     *
     * @return array
     */
    public function getMiddleware() : array
    {
        if(!$this->middleware) return [];
        return $this->middleware;
    }

    /**
     * Execute all the middlewares before going forward to the specified method
     *
     * @param [type] $closure
     * @param array $params
     * @return Mixed
     */
    public function callAction($closure, array $params = []) : mixed
    { 
        $class = get_called_class();
        $request = app('request');

        $next = function($request) use ($class, $closure, $params) {
            return  app()->call("$class@$closure", $params);
        };

        // Run all the middlewares
        Handler::evaluate($this->getMiddleware(), $next);

        return $next($request);
    }


}