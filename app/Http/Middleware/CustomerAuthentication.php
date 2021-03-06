<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CustomerAuthentication
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if(!session()->has('LoggedCustomer') && ($request->path() != 'customer/auth')){
            return redirect('customer/auth')->with('fail','You must be logged in.');
        }
        if(session()->has('LoggedCustomer') && ($request->path() == 'customer/auth')){
            return back();
        }

        if(isset($_COOKIE['customer_email']) && ($request->path() == 'customer/auth')){
            $request->session()->put('LoggedCustomer', $_COOKIE['customer_email']);
            return redirect('/');
        }
        return $next($request)->header('Cache-Control','no-cache','no-store','max-age=0','must-revalidate')->header('Pragma','no-cache')->header('Expires','Sat 01 Jan 1990 00:00:00 GMT');
    }
}
