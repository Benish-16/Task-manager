<?php

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureCompanyAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user(); 

        if (! $user) {
            abort(401, 'Unauthorized');
        }


        setPermissionsTeamId(tenant()->id);

        if (! $user->hasRole('admin')) {
            abort(403, 'Only company admin can access this.');
        }

        return $next($request);
    }
}
