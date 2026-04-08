<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // Auth :: user(): lay user đa đang nhap va luu trong session
        // Auth :: user()->role: kiểm tra gia trị cua thuoc tinh role co nam trong gia tri cua tham so $roles
        if (!in_array(Auth::user()->role, $roles)) {
            // Neu khong nam trong role cho phep => dieu huong ve trang abort voi ma loi 403
            abort(403, 'Bạn Không có quyền truy cập');
        }

        return $next($request);
    }
}
