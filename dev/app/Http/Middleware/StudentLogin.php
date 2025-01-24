<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class StudentLogin
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
        $userInfo = $request->session()->get('userInfo');
  
        if (empty($userInfo)) {

            return redirect(url('/userlogin'));
        }
        return $next($request);
    }
}
