<?php

namespace App\Http\Middleware;

use Closure;
use Spatie\Permission\PermissionRegistrar;

class SetTenantTeam
{
    public function handle($request, Closure $next)
    {
        if (tenant()) {
            app(PermissionRegistrar::class)
                ->setPermissionsTeamId(tenant('id'));
        }

        return $next($request);
    }
}