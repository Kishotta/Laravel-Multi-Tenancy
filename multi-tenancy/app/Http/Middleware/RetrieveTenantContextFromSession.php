<?php

namespace App\Http\Middleware;

use App\Models\Tenant;
use App\Models\TenantUser;
use Closure;
use Illuminate\Http\Request;

class RetrieveTenantContextFromSession
{
    public function handle(Request $request, Closure $next)
    {
        $tenantUser = TenantUser::findOrFail(session()->get('tenant_user_id'));

        app()->instance(Tenant::class, $tenantUser->tenant);

        return $next($request);
    }
}
