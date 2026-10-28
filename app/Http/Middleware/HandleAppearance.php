<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class HandleAppearance
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // ปิดการแชร์ค่า appearance เพื่อแก้ไขปัญหา 500 Internal Server Error
        // \Illuminate\Support\Facades\View::share('appearance', $request->cookie('appearance') ?? 'system');

        return $next($request);
    }
}