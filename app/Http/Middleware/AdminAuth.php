<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminAuth
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
        if(auth()->check()){
            if(auth()->user()->role == 'admin'){
                return $next($request);
            }else if(auth()->user()->role == 'alumno'){
                return redirect()->to('/alumno');
            }
            else if(auth()->user()->role == 'profesor'){
                return redirect()->to('/profesor');
            }

            
        }
        return redirect()->to('/login');
        
    }
}
