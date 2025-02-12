<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request; 
use Symfony\Component\HttpFoundation\Response;


class PharmacyMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
         if(pharmacy_access()){
              return $next($request);
          }
        return redirect()->back();  
    }
}
