<?php

namespace App\Http\Middleware\Custom;

use Closure;
use App\Helpers\Qs;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class TeamSAT
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
        // Debug: Log middleware check
        if (Auth::check()) {
            $userType = Auth::user()->user_type;
            $isTeamSAT = Qs::userIsTeamSAT();
            Log::info('TeamSAT middleware check - User type: ' . $userType . ', Is TeamSAT: ' . ($isTeamSAT ? 'true' : 'false'));
            
            if ($isTeamSAT) {
                return $next($request);
            }
        }
        
        Log::info('TeamSAT middleware redirecting to login');
        return redirect()->route('login');
    }
}
