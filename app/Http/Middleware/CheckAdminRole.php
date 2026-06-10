<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckAdminRole
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();
        
        if (!$user || !in_array($user->role, ['super-admin', 'staff-admin'])) {
            return redirect('/user/dashboard')
                ->with('error', 'Anda tidak memiliki akses ke halaman admin.');
        }
        
        return $next($request);
    }
}