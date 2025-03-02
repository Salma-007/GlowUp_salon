<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\adminController;

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
    return view('admin.employee-manage');
});

Route::get('/admin/clients', function () {
    return view('admin.clients-manage');
});

Route::get('/admin/services', function () {
    return view('admin.services-manage');
});

Route::get('/admin/reservations', function () {
    return view('admin.reservations-manage');
});