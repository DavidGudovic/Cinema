<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;

class PrivateInfo
{
    /**
    *  If the user is requesting private info of another user throw 403
    */
    public function handle(Request $request, Closure $next)
    {
        session(['url.intended' => url()->previous()]);
        return  $request->route('user') == auth()->user() ? $next($request) : throw new AuthorizationException();
    }
}
