<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IpMiddleware
{
    /**
     * List of allowed IP addresses.
     *
     * @var array
     */
    protected $allowedIps = [
        '127.0.0.1', // Localhost
        '192.168.1.1', // Example IP address
    ];

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Check if the client's IP address is in the allowed list
        if (!in_array($request->ip(), $this->allowedIps)) {
            // Optionally, you can return a custom response here
            //return response()->json(['message' => 'Unauthorized IP address'], 403);
        }

        return $next($request);
    }
}
