<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\adminController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\PlanningController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;

use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Admin\RolePermissionController;


Route::middleware('auth')->group(function () { 
    //planning
    Route::get('/plannings', [PlanningController::class, 'show'])->name('plannings.show');

    // reservations
    Route::get('/reservations/add', [ReservationController::class, 'create'])->name("reservation-ajout");
    Route::post('/reservations/ajout', [ReservationController::class, 'store'])->name("new_reservation");
    Route::get('/mes-reservations', [ReservationController::class, 'clientReservations'])->name('client.reservations');
    Route::put('/reservations/{reservation}', [ReservationController::class, 'update'])->name('reservations.update');
    Route::delete('/reservations/{reservation}', [ReservationController::class, 'destroy'])->name('reservations.destroy');
});

//home page
Route::get('/home', [HomeController::class, 'index'])->name("home");
Route::get('/services', [HomeController::class, 'services'])->name("services");

// update profil
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/photo', [ProfileController::class, 'updatePhoto'])->name('profile.update-photo');
});

// reservations manage



//manage categories
Route::get('/admin/categories', [CategoryController::class, 'index'])->name('admin.categories.index');
Route::post('/admin/categories', [CategoryController::class, 'store'])->name('admin.categories.store');
Route::put('/admin/categories/{category}', [CategoryController::class, 'update'])->name('admin.categories.update');
Route::delete('/admin/categories/{category}', [CategoryController::class, 'destroy'])->name('admin.categories.destroy');

//manage employees
Route::get('/employees/add', [EmployeeController::class, 'create'])->name('admin.employees.add');
Route::post('/employees/ajouter', [EmployeeController::class, 'ajouter'])->name('ajouter');
Route::delete('/employees/delete/{id}', [EmployeeController::class, 'destroy'])->name('employee.destroy');
Route::get('/admin/employees', [EmployeeController::class, 'index'])->name('admin.clients/searchemployees.index');
Route::get('/employees/search', [EmployeeController::class, 'search']);
Route::get('/admin/employees/{employee}/edit', [EmployeeController::class, 'edit'])->name('admin.employees.edit');
Route::put('/admin/employees/{employee}', [EmployeeController::class, 'update'])->name('admin.employees.update');

//manage clients
Route::get('/admin/clients', [ClientController::class, 'index'])->name('admin.clients.index');
Route::get('/clients/search', [ClientController::class, 'search']);
Route::delete('/clients/delete/{id}', [ClientController::class, 'destroy'])->name('client.destroy');
Route::get('/admin/clients/{client}/edit', [ClientController::class, 'edit'])->name('admin.clients.edit');
Route::put('/admin/clients/{client}', [ClientController::class, 'update'])->name('admin.clients.update');

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

// services
Route::get('/admin/services', [ServiceController::class, 'index'])->name('admin.services.index');
Route::get('/services/ajouter', [ServiceController::class, 'create'])->name('services.add-service');
Route::post('/services/store', [ServiceController::class, 'store'])->name('services.store');
Route::get('/services/edit/{service}', [ServiceController::class, 'edit'])->name('services.edit');
Route::put('/services/update/{service}', [ServiceController::class, 'update'])->name('services.update');
Route::delete('/services/destroy/{service}', [ServiceController::class, 'destroy'])->name('services.destroy');


Route::get('/register', [AuthController::class, 'index'])->name('register');
Route::get('/login', [AuthController::class, 'loginpage'])->name('login');

Route::get('/', function () {
    return view('welcome');
});

Route::get('/employee/dashboard', function () {
    return view('employees.index');
});

// Route::get('/client/dashboard', function () {
//     return view('clients.index');
// });


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