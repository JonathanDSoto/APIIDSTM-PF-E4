<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\DepartamentController;
use App\Http\Controllers\PlaceController;
use App\Http\Controllers\SubjectController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Usuarios
Route::get('/user/{id}', [UserController::class, 'show']);
// Route::put('/user/{id}', [UserController::class, 'edit']);
Route::get('/user', [UserController::class, 'index']);
Route::post('/user', [UserController::class, 'register']);


// Roles
Route::get('/roles', [RoleController::class, 'index']);
Route::post('/roles', [RoleController::class, 'create']);

// Departamentos
Route::get('/department/{id}', [DepartamentController::class, 'show']);
Route::get('/department', [DepartamentController::class, 'index']);
Route::post('/department', [DepartamentController::class, 'create']);

// Materias
Route::post('/subjects', [SubjectController::class, 'store']);

// Edificios
Route::get('/buildings', [PlaceController::class, 'index']);
Route::post('/buildings', [PlaceController::class, 'store']);
Route::put('/buildings/{id}', [PlaceController::class, 'edit']);


