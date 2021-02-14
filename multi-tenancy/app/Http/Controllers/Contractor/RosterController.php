<?php

namespace App\Http\Controllers\Contractor;

use App\Http\Controllers\Controller;
use App\Models\Contractor;
use Illuminate\Http\Request;

class RosterController extends Controller
{
    public function index(Contractor $contractor)
    {
        dd($contractor);
    }
}
