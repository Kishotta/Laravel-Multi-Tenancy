<?php

use App\Http\Controllers\Contractor\RosterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Operator\ConfigController;
use App\Http\Middleware\ContractorOnly;
use App\Http\Middleware\OperatorOnly;
use App\Http\Middleware\RetrieveTenantContextFromSession;
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


// Contractor.php
Route::middleware([ContractorOnly::class])->group(function() {
    // Current contractor tenant
    Route::middleware([RetrieveTenantContextFromSession::class])->group(function() {
        Route::get('roster', [RosterController::class, 'index']);
    });

    // Other contractor tenant
    Route::get('{tenantSlug}/roster', [RosterController::class, 'index']);
});


// Operator.php
Route::middleware([OperatorOnly::class])->group(function() {
    // Current operator tenant
    Route::middleware([RetrieveTenantContextFromSession::class])->group(function() {
        Route::get('config', [ConfigController::class, 'index']);
    });

    // Other operator tenant
    Route::get('{tenantSlug}/config', [ConfigController::class, 'index']);
});
