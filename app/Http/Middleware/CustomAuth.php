<?php
namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Session;

class CustomAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $path = $request->path();
        if( ($path == 'login' || $path == '/') && Session::get('auth')
        || (strpos($path, 'PasswordDetails') !== false && Session::has('auth'))
        )
        {
            return redirect('/dashboard');
        }
        
        if(
            ($path == 'dashboard' && !Session::get('auth'))
            || ($path == 'transactions/deposit' && !Session::get('auth'))
            || ($path == 'transactions/withdraw' && !Session::get('auth'))
        //  || (strpos($path, 'dashboard') !== false && !Session::has('auth'))
        //  || (strpos($path, 'logAuth') !== false && !Session::has('auth'))
        )
        {
            return redirect('/login');
        }

        return $next($request);
    }
}
