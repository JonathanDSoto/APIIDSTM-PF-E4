<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('login');
});

Route::get('/buildings', function () {
    return view('buildings');
});

Route::get('/roles', function () {
    return view('roles');
});

Route::get('/permisos', function () {
    return view('permission');
});

Route::get('/usuarios', function () {
    return view('users');
});

Route::get('/calendario/general', function () {
    return view('calendar');
});

Route::get('/reportes', function () {
    return view('report');
});

Route::get('/iniciativas', function () {
    return view('initiative');
});

Route::get('/departamentos', function () {
    return view('departament');
});