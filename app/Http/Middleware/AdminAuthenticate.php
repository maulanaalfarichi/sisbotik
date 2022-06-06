<?php

namespace hs\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;

class AdminAuthenticate
{
    
        /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth;

    /**
     * Create a new filter instance.
     *
     * @param  Guard  $auth
     * @return void
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($this->auth->guest()) {
            if ($request->ajax()) {
                return response('Unauthorized.', 401);
            } else {
                return redirect()->guest('auth/login');
            }
        }else{
            if ($this->auth->user()->level) {
                return $next($request);
                //return 'is admin';
            }else{
                return redirect()->guest('/');
                //return 'not admin';
            }
        }

        return $next($request);
    }
}
