<?php

declare(strict_types=1);

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Tenant\RoleController;
use App\Http\Controllers\TenantController;
use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;


/*
|--------------------------------------------------------------------------
| Tenant Routes
|--------------------------------------------------------------------------
|
| Here you can register the tenant routes for your application.
| These routes are loaded by the TenantRouteServiceProvider.
|
| Feel free to customize them however you want. Good luck!
|
*/
Route::middleware([
    'web',
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,
      'setTenantTeam',
])->group(function () {

    // =========================
    // PUBLIC TENANT ROUTES
    // =========================
    Route::get('/', function () {
    return view('tenants.welcome');
});

    Route::get('/logint',[AuthController::class,'login'])->name('tenants.login');
    Route::post('/logint',[AuthController::class,'loginStore'])->name('tenants.login.store');

    Route::get('/registert',[AuthController::class,'register'])->name('tenants.register');
    Route::post('/registert',[AuthController::class,'registerStore'])->name('tenants.register.store');

    // =========================
    // PROTECTED TENANT ROUTES
    // =========================
    Route::middleware('auth')->group(function () {
   Route::get('/profile', [ProfileController::class, 'edit'])
    ->name('tenant.profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('tenant.profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('tenant.profile.destroy');
 
});

    Route::middleware(['auth'])->group(function () {

        Route::get('/dashboardt',[AuthController::class,'dashboard'])
            ->name('tenants.dashboard');

        Route::get('/logout',[AuthController::class,'logout'])
            ->name('tenants.logout');

        Route::get('/userlist', [AuthController::class, 'userlist'])
            ->name('tenants.userlist');

        Route::get('/users/{id}/edit', [AuthController::class, 'useredit'])
            ->name('users.edit');

        Route::put('/users/{id}', [AuthController::class, 'updateuser'])
            ->name('users.update');
             Route::delete('/users/{id}/destroy', [AuthController::class, 'destroyuser'])
            ->name('users.destroy');

      
        Route::get('/roles', [RoleController::class, 'index'])
            ->name('roles.index');

        Route::post('/roles', [RoleController::class, 'store'])
            ->name('roles.store');

        Route::get('/rolesview', [RoleController::class, 'show'])
            ->name('roles.view');

        Route::get('/role/{role}/edit', [RoleController::class, 'edit'])
            ->name('role.edit');

        Route::put('/role/{role}', [RoleController::class, 'update'])
            ->name('role.update');

        Route::delete('/roles/{id}', [RoleController::class, 'destroy'])->name('role.delete');

Route::get('/tasks/create', [TaskController::class, 'create'])
    ->name('tasks.create');

Route::post('/tasks', [TaskController::class, 'store'])
    ->name('tasks.store');
    Route::get('/tasks/index', [TaskController::class, 'index'])
    ->name('tasks.index');
     Route::get('/tasks/{task}/edit', [TaskController::class, 'edit'])
    ->name('tasks.edit');
     Route::put('/tasks/{task}/update', [TaskController::class, 'update'])
    ->name('tasks.update');
        Route::get('/tasks', [AuthController::class, 'viewTasks'])
    ->name('tasks.employee.index');
Route::patch('/employee/tasks/{task}/status', [EmployeeController::class, 'updateStatus'])
    ->name('employee.tasks.updateStatus');
Route::delete('/tasks/{task}', [TaskController::class, 'destroy'])->name('tasks.destroy');

    Route::get('/tasks/{task}/pdf', [TaskController::class, 'printTask'])->name('tasks.print');
    //
       Route::get('verify-email', EmailVerificationPromptController::class)
        ->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->middleware('throttle:6,1')
        ->name('verification.send');

    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
        ->name('password.confirm');

    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    Route::put('password', [PasswordController::class, 'update'])->name('password.update');

    Route::post('logout', [AuthController::class, 'logout'])
        ->name('tenant.logout');
 
    });
    
    

});