<?php 
namespace WPINT\Framework\Include\Middleware;

use Closure;
use Illuminate\Http\Request;
use WP_Error;
use Wpint\Contracts\Middleware\MiddlewareContract;

abstract class Handler implements MiddlewareContract
{

    /**
     * Handle method
     *
     * @param Request $request
     * @param Closure $next
     * @return void
     */
    public function handle(Request $request, Closure $next)
    {
        throw new WP_Error('This method must be implemented in concrete classes');
    }

    /**
     * Build-in Evaluate method
     *
     * @param [type] $middlewares
     * @param [type] $next
     * @return void
     */
    public static function  evaluate($middlewares, $final) : mixed
    {
        $request = app('request');
        if(!$middlewares) $final($request);

        $chain = $middlewares->reverse()->reduce(function($next, $middleware){
            return function ($request) use ($middleware, $next) {
                return app($middleware)->handle($request, $next);
            };
        }, $final );

        return $chain($request);

    } 

}