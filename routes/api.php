<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\RegisterController;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\TaskBoardController;
use App\Http\Controllers\Api\TaskController;
use App\Http\Controllers\Api\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
*/
Route::post('register', [RegisterController::class, 'register']);
Route::get('login', [LoginController::class, 'login']);

Route::middleware('auth:api')->group(function () {
    /* All Routes for User */
    Route::group([
        'prefix' => 'user',
        'as' => 'user.',
    ], function () {
        Route::get('/list', [UserController::class, 'index'])->name('list');
    });
    /* All Routes for task boards */
    Route::group([
        'prefix' => 'board',
        'as' => 'board.',
    ], function () {
        Route::get('/list', [TaskBoardController::class, 'index'])->name('list');
        Route::post('/create', [TaskBoardController::class, 'store'])->name('create');
        Route::put('/{taskBoard}/update', [TaskBoardController::class, 'update'])->name('update');
        Route::delete('/{taskBoard}', [TaskBoardController::class, 'destroy'])->name('delete');
    });
    /* All Routes for tasks */
    Route::group([
        'prefix' => 'task',
        'as' => 'task.',
    ], function () {
        Route::get('/list', [TaskController::class, 'index'])->name('list');
        Route::post('/create', [TaskController::class, 'store'])->name('create');
        Route::put('/{task}/update', [TaskController::class, 'update'])->name('update');
        Route::delete('/{task}', [TaskController::class, 'destroy'])->name('delete');
    });
});