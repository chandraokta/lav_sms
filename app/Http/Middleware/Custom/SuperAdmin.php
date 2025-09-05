<?php

namespace App\Http\Middleware\Custom;

use Closure;
use App\Helpers\Qs;
use Illuminate\Support\Facades\Auth;

class SuperAdmin
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
        // Semua guru dianggap sebagai super admin
        return (Auth::check() && (Qs::userIsSuperAdmin() || Auth::user()->user_type == 'teacher')) ? $next($request) : redirect()->route('login');
    }
}
