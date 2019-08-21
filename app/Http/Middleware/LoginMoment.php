<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Support\Facades\Auth;

class LoginMoment
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
        $moment = Carbon::now();
        if (Auth::user() === null) {
            return $next($request);
        }

        if ((int) Auth::user()->position_id === 1) {
            return $next($request);
        } else {
            if ((int) $moment->hour >= 8 && (int) $moment->hour <= 20 &&  (int) $moment->dayOfWeek !== 0)  {
                return $next($request);
            } else {
                return redirect('at_time');
            }
        }
    }
}
