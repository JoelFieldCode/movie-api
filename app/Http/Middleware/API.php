<?php 
namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;

class API {

    public function handle($request, Closure $next)
    {

            $response = $next($request);
            $response->header('Access-Control-Allow-Headers', 'Origin, Content-Type');
            $response->header('Access-Control-Allow-Origin', '*');
            return $response;
    }
}