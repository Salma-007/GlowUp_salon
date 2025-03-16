<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\adminController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Admin\RolePermissionController;


//manage employees

Route::get('/employees/add', [EmployeeController::class, 'create'])->name('admin.employees.add');
Route::post('/employees/ajouter', [EmployeeController::class, 'ajouter'])->name('ajouter');
Route::get('/admin/employees', [EmployeeController::class, 'index'])->name('admin.employees.index');

//manage clients
Route::get('/admin/clients', [ClientController::class, 'index'])->name('admin.clients.index');


// manage roles and permission
Route::get('/admin/roles-permissions', [RolePermissionController::class, 'index'])->name('admin.roles_permissions.index');

Route::post('/admin/roles', [RolePermissionController::class, 'storeRole'])->name('admin.roles.store');
Route::post('/admin/permissions', [RolePermissionController::class, 'storePermission'])->name('admin.permissions.store');

Route::delete('admin/roles/{id}', [RolePermissionController::class, 'destroyRole'])->name('admin.roles.destroy');
Route::delete('admin/permissions/{id}', [RolePermissionController::class, 'destroyPermission'])->name('admin.permissions.destroy');

Route::get('admin/roles/{role}/edit', [RolePermissionController::class, 'editRole'])->name('admin.roles.edit');
Route::put('admin/roles/{role}', [RolePermissionController::class, 'update'])->name('admin.roles.update');

// manage authentication
Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendVerificationCode'])->name('password.email');

Route::get('/reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [ResetPasswordController::class, 'resetPassword'])->name('password.update');

Route::post('/valide-password', [ResetPasswordController::class, 'validateResetCode'])->name('password.validate');
Route::get('/reset-password-email', [ResetPasswordController::class, 'showValideToken'])->name('password.resetToken');

Route::post('/register', [AuthController::class, 'register'])->name('register.addUser');
Route::post('/login', [AuthController::class, 'login'])->name('loginIn');
// Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


Route::get('/register', [AuthController::class, 'index']);
Route::get('/login', [AuthController::class, 'loginpage'])->name('loginpage');

Route::get('/', function () {
    return view('welcome');
});

Route::get('/admin/dashboard', function () {
    return view('admin.index');
});

Route::get('/employee/dashboard', function () {
    return view('employees.index');
});

Route::get('/client/dashboard', function () {
    return view('clients.index');
});


Route::get('/admin/services', function () {
    return view('admin.services.services-manage');
});

Route::get('/admin/add-service', function () {
    return view('admin.services.add-service');
});


Route::get('/admin/reservations', function () {
    return view('admin.reservations.reservations-manage');
});


Route::get('/admin/dashboard', [adminController::class, 'index'])->name('admin.dashboard');


Route::get('/forgetpassword', function () {
    return view('auth.recoverpw');
});

Route::get('/reset-password', function () {
    return view('auth.reset-password');
});

Route::get('/dashboard', function () {
    return view('admin.dashboard');
})->name('dashboard');