<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Auth;

class EnsureAdminEmailIsVerified
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

        if (! $request->user() ||
            ($request->user() instanceof MustVerifyEmail &&
                ! $request->user()->hasVerifiedEmail())) {

            return $request->expectsJson()
                ? abort(403, 'Your email address is not verified.')
                : Redirect::route('admin.verification.notice');
        }

        return $next($request);
    }



//    public function handle($request, Closure $next)
//    {
//
//        $guards = array_keys(config('auth.guards'));
//
//
//
//
//        foreach($guards as $guard)
//        {
//            if($guard == 'admin'){
//                if(Auth::guard($guard)->check()){
//                    if (! Auth::guard($guard)->user() ||
//                        (Auth::guard($guard)->user() instanceof MustVerifyEmail &&
//                            ! Auth::guard($guard)->user()->hasVerifiedEmail())) {
//                        return $request->expectsJson()
//                            ? abort(403, 'Your email address is not verified.')
//                            : Redirect::route('admin.verification.notice');
//                    }
//                }
//            }
//        }
//
//
//        return $next($request);
//    }
}
