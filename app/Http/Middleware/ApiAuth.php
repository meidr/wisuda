<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ApiAuth
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
        try {
            $key = $request->header('apikey');
            if ($key != config('api.key')) {
                return response()->json([
                    "status" => false,
                    "message" => "Gagal otentikasi",
                ]);
            }

            return $next($request);
        } catch (\Throwable $th) {
            return response()->json([
                "status" => false,
                "message" => "Error",
            ]);
        }
    }
}
