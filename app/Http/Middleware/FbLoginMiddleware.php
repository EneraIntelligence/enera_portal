<?php

namespace Portal\Http\Middleware;

use Closure;
use Portal\Libraries\FacebookUtils;

class FbLoginMiddleware
{
    protected $fbutils;

    public function __construct()
    {
        $this->fbutils = new FacebookUtils();
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        /*
        if (!$this->fbutils->isUserLoggedIn()) {
            return redirect()->route('welcome');
        }*/
        return $next($request);
    }
}
