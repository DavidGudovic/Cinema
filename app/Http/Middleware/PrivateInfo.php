<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Auth\Access\AuthorizationException;

class PrivateInfo
{
    /**
    *  If the user is requesting private info of another user throw 403
    */
    public function handle(Request $request, Closure $next)
    {
        if($request->route('user') == auth()->user()){
            Session::forget('url.intended');
            return $next($request);
        }
        session(['url.intended' => url()->previous()]);
        return throw new AuthorizationException(403, 'You are not authorized to view this page');
    }
}
