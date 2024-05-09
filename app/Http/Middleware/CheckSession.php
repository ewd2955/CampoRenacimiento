<?php
namespace App\Http\Middleware;
use Illuminate\Support\Facades\Session;
use Closure;
use Auth;


class CheckSession
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::user() ) {
            return $next($request);
        }

        return redirect('/auth.login')->with('error', 'Session expired! Please login again.');
    }
}
