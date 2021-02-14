<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use App\Models\Operator;
use Illuminate\Http\Request;

class ConfigController extends Controller
{
    public function index(Operator $operator)
    {
        dd($operator);
    }
}
