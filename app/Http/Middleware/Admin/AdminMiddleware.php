<?php

namespace App\Http\Middleware\Admin;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::user()) { //when your stay login
            if (Auth::user()->role == 'admin' || Auth::user()->role == 'superAdmin') {

                //user call login and register page when he login , but kill this url because admin middleware
                if ($request->route()->getName() == 'authLogin' || $request->route()->getName() == 'authRegister') {
                    return back();
                }
                //user call all request rul excepts login and register url
                return $next($request);
            }
            return abort(404);
        } else {
            //when user not login , can call login and register url
            if ($request->route()->getName() == 'authLogin' || $request->route()->getName() == 'authRegister') {
                return $next($request);
            } else {
                return abort(404);
            }
        }
    }
}
