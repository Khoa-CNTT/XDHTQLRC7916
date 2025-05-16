<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Auth;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class kiemTraKhachHangMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user   =   Auth::guard('sanctum')->user();
        if ($user && $user instanceof \App\Models\KhachHang) {
            if ($user->is_block) {
                return response()->json([
                    'status'    =>  false
                ]);
            }
            if ($user->is_active == false) {
                return response()->json([
                    'status'    =>  false
                ]);
            }
            return $next($request);
        } else {
            return response()->json([
                'status'    =>  false
            ]);
        }
    }
}
