<?php

namespace App\Http\Middleware;

use App\Models\Contractor;
use App\Models\Tenant;
use Closure;
use Illuminate\Http\Request;

class ContractorOnly
{
    private $tenant;

    public function __construct (Tenant $tenant)
    {
        $this->tenant = $tenant;
    }

    public function handle(Request $request, Closure $next)
    {
        $contractor = $this->tenant->resolve();

        if ( ! is_a($contractor, Contractor::class)) {
            abort(404);
        }

        app()->instance(Contractor::class, $contractor);

        return $next($request);
    }
}
