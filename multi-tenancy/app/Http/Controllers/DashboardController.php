<?php

namespace App\Http\Controllers;

use App\Models\Contractor;
use App\Models\Operator;
use App\Models\Tenant;

class DashboardController extends Controller
{
    public function index(Tenant $tenant) {
        $concreteTenant = $tenant->resolve();
        switch(get_class($concreteTenant)) {
            case Contractor::class:
                return view('contractor.dashboard', ['contractor' => $concreteTenant]);
            case Operator::class:
                return view('operator.dashboard', ['operator' => $concreteTenant]);
        }
    }
}
