<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\User;

class warehouse_worker
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->hasCookie('token')) {
            return response()->json(['error' => 'Auth token has not been found'], 404);
        }

        $user = User::where('token', $request->cookie('token'))->first();
        if(!$user){
            return response()->json(['error' => 'Incorrect token passed!'], 403);
        }

        if($user->privilage < 1){
            return response()->json(['error' => 'This route is for warehouse workers and admins only'], 403);
        }
        

        return $next($request);
    }
}
