<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleNotEmployee
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check())
            return false;

        $user = Auth::user();

        if (User::with('department')
            ->find($user->id)
            ->department->slug === 'employee'){
            return resp(
                false,
                'Pelanggaran',
                [],
                403,
                0,
                [
                    'message' => 'Anda tidak memiliki izin untuk mengakses bagian ini!'
                ]
            );
        }
        return $next($request);
    }
}
