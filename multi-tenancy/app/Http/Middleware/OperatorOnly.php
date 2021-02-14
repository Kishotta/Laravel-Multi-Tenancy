<?php

namespace App\Http\Middleware;

use App\Models\Operator;
use App\Models\Tenant;
use Closure;
use Illuminate\Http\Request;

class OperatorOnly
{
    private $tenant;

    public function __construct (Tenant $tenant)
    {
        $this->tenant = $tenant;
    }

    public function handle(Request $request, Closure $next)
    {
        if ($this->tenant->id == null) {
            $this->tenant = Tenant::whereSlug($request->route('tenantSlug'))->firstOrFail();
        }

        $operator = $this->tenant->resolve();

        if ( ! is_a($operator, Operator::class)) {
            abort(404);
        }

        app()->instance(Operator::class, $operator);

        return $next($request);
    }
}
