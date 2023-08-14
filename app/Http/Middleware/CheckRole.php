<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Exceptions\RoleNotAuthorizedException;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Auth\Access\AuthorizationException;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     * @throws RoleNotAuthorizedException
     * @throws RoleNotAuthorizedException
     * @throws RoleNotAuthorizedException
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        return auth()->user()->role->value == $role
        ? $next($request)
        : throw new RoleNotAuthorizedException('Vaš tip profila nema pristup ovoj stranici',418);
    }
}
