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