<?php

use App\Http\Controllers\Contractor\RosterController;
use App\Http\Controllers\DashboardController;
use App\Models\Operator;
use App\Models\Tenant;
use App\Models\TenantUser;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('login/{id}', function($id) {
    $tenantUser = TenantUser::findOrFail($id);
    session()->put('tenant_user_id', $tenantUser->id);
});

Route::get('logout', function() {
    session()->forget('tenant_user_id');
});



Route::get('/', function() {
   return view('welcome');
});



Route::middleware(['session-tenant-context'])->group(function() {
   Route::get('home', [DashboardController::class, 'index']);
});

Route::get('{tenant}/home', [DashboardController::class, 'index']);


// Current tenant contractor routes
Route::middleware(['session-tenant-context', 'contractor-only'])->group(function() {
    Route::get('roster', [RosterController::class, 'index']);
});

// Other tenant contractor routes
Route::get('{contractor}/roster', [RosterController::class, 'index']);


Route::get('{thing?}/thing', function($thing) {
    dd($thing);
});

// Current tenant  operator routes
Route::middleware(['session-tenant-context', 'operator-only'])->group(function() {
    Route::get('config', function(Operator $operator) {
        dd($operator);
    });
});

// Other tenant operator routes
Route::get('{operator}/config', function(Operator $operator) {
    dd($operator);
});
