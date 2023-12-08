<?php

use App\Http\Controllers\UserController;
use App\Http\Middleware\loginMiddleWare;
use App\Http\Middleware\RequireTokenWeb;
use App\Http\Middleware\WebSpecificMiddleware;
use App\Models\Session;
use Illuminate\Http\Request;
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

Route::get('/', [UserController::class, 'showLogin']) -> name('login');

Route::middleware([WebSpecificMiddleware::class]) -> group(function() {
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

    Route::get('/materias', function () {
        return view('subject');
    });

    Route::get('/dashboard', function () {
        return view('dashboard');
    });

});
