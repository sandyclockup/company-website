<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\CMS\Visitor;

class VisitorMiddleware
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

        if(env('APP_ENV') == 'production'){
            
            $ip_address = $request->ip();
            $url = $request->url();

            $check = Visitor::where("url", $url)
                ->where("ip_address", $ip_address)
                ->whereRaw('Date(created_at) = CURDATE()')
                ->first();

            if(is_null($check)){
                Visitor::create([
                    "ip_address"=> $ip_address,
                    "url"=> $url
                ]);
            }
        }   
        return $next($request);
    }
}
