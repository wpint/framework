<?php 
namespace WPINT\Framework\Include\Controller;

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
            return app()->call("$class@$closure", ['data' => $params]);
        };

        $middlewares = $this->getMiddleware();
        if($middlewares)
        {
            foreach ($middlewares as $middleware) 
            {
                $next = function($request) use ($middleware, $next)
                {
                    return app($middleware)->handle($request, $next);
                };
                        
            }

        }

        return $next($request);
    }


}