<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Tenant\RoleController;


Route::middleware('auth:sanctum')->get('/roles', [RoleController::class, 'index']);