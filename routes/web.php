<?php

use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProfileController;

use App\Http\Controllers\TenantController;
use Illuminate\Support\Facades\Route;


Route::group(['domain'=>config('tenancy.central_domains.1')],function(){


Route::get('/', function () {
    return view('welcome');
});


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

  
  

      
});
  Route::get('/permissions/create', [PermissionController::class, 'create'])->name('permissions.create');
    Route::get('/tenant', [TenantController::class, 'create'])->name('tenants.create');
        Route::post('/tenant', [TenantController::class, 'store'])->name('tenants.store');
         Route::get('/tenants/view', [TenantController::class, 'index'])->name('tenants.view');
          Route::get('/{tenant}/edit', [TenantController::class, 'edit'])->name('tenants.edit');
    Route::put('/{tenant}', [TenantController::class, 'update'])->name('tenants.update');
    Route::delete('/tenants/{tenant}/delete', [TenantController::class, 'destroy'])->name('tenants.destroy');
    Route::post('/permissions', [PermissionController::class, 'store'])->name('permission.store');
   Route::resource('tenants', TenantController::class);
     Route::get('/permissions/view', [PermissionController::class, 'index'])
            ->name('permissions.view');
              Route::get('/permissions/{permission}/edit', [PermissionController::class, 'edit'])
            ->name('permission.edit');
      Route::put('/permissions/{permission}/update', [PermissionController::class, 'update'])
    ->name('permission.update');
              Route::delete('/permissions/{id}/delete', [PermissionController::class, 'destroy'])
            ->name('permission.delete');

    require __DIR__.'/auth.php';
});


