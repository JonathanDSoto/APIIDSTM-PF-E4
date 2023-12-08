<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\DepartamentController;
use App\Http\Controllers\InitiativeController;
use App\Http\Controllers\PlaceController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\SessionController;
use App\Http\Middleware\ApiSpecificMiddleware;

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
Route::middleware([ApiSpecificMiddleware::class]) -> group(function() {
    Route::prefix('user')->group(function () {
        Route::get('/', [UserController::class, 'index']);
        Route::post('/{id}', [UserController::class, 'edit']);
        Route::delete('/{id}', [UserController::class, 'destroy']);
        Route::get('/{id}', [UserController::class, 'show']);
    });
    
    Route::prefix('roles')->group(function () {
        Route::get('/', [RoleController::class, 'index']);
        Route::post('/', [RoleController::class, 'create']);
        Route::post('/{id}', [RoleController::class, 'update']);
        Route::post('/delete/{id}', [RoleController::class, 'destroy']);
    });
    
    Route::prefix('department')->group(function () {
        // Departamentos
        Route::get('/', [DepartamentController::class, 'index']);
        Route::post('/', [DepartamentController::class, 'store']);
        Route::post('/{id}', [DepartamentController::class, 'update']);
        Route::get('/{id}', [DepartamentController::class, 'show']);
        Route::delete('/{id}', [DepartamentController::class, 'destroy']);
    });    

    Route::prefix('initiative')->group(function () {
        // Departamentos
        Route::get('/', [InitiativeController::class, 'index']);
        Route::post('/', [InitiativeController::class, 'store']);

        Route::post('/{id}', [InitiativeController::class, 'update']);
        // Route::get('/{id}', [InitiativeController::class, 'show']);
        Route::delete('/{id}', [InitiativeController::class, 'destroy']);
    });  
        
    Route::prefix('subjects')->group(function () {
        Route::post('/', [SubjectController::class, 'store']);
        Route::get('/', [SubjectController::class, 'index']);
    });
    
    Route::prefix('buildings')->group(function () {
        Route::get('/', [PlaceController::class, 'index']);
        Route::post('/', [PlaceController::class, 'store']);
        Route::post('/{id}', [PlaceController::class, 'update']);
        Route::delete('/{id}', [PlaceController::class, 'destroy']);
    });

    Route::prefix('reports')->group(function () {
        Route::get('/', [ReportController::class, 'index']);
        Route::post('/', [ReportController::class, 'store']);
        Route::post('/{id}', [ReportController::class, 'update']);
        Route::delete('/{id}', [ReportController::class, 'destroy']);
    });
});

Route::post('/login', [UserController::class, 'login']);
// Route::post('user/', [UserController::class, 'register']);
