<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EnvDashboardController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/env-dashboard',[EnvDashboardController::class,'index']);

Route::get('/export-report',[EnvDashboardController::class,'export']);