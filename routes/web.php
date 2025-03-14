<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\adminController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\AuthController;

Route::post('/register', [AuthController::class, 'register'])->name('register.addUser');;
// Route::post('/login', [AuthController::class, 'login']);
// Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);


Route::get('/register', [AuthController::class, 'index']);

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

Route::get('/admin/employees', function () {
    return view('admin.employees.employee-manage');
});

Route::get('/admin/clients', function () {
    return view('admin.clients.clients-manage');
});

Route::get('/admin/services', function () {
    return view('admin.services.services-manage');
});

Route::get('/admin/add-service', function () {
    return view('admin.services.add-service');
});


Route::get('/employees/add', [RegisterController::class, 'index'])->name('add-employee.index');

Route::get('/admin/reservations', function () {
    return view('admin.reservations.reservations-manage');
});

// auth
// Route::get('/login', function () {
//     return view('auth.login');
// });
Route::get('/admin/dashboard', [adminController::class, 'index'])->name('admin.dashboard');


// Route::get('/register', [RegisterController::class, 'index'])->name('register');
// Route::post('/register', [RegisterController::class, 'createUser'])->name('register.createUser');

Route::get('/confirm-mail', function () {
    return view('auth.confirm-mail');
});

Route::get('/forgetpassword', function () {
    return view('auth.recoverpw');
});

Route::get('/reset-password', function () {
    return view('auth.reset-password');
});

Route::get('/dashboard', function () {
    return view('admin.dashboard');
})->name('dashboard');