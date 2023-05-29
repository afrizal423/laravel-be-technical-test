<?php

use App\Http\Controllers\Api\V1\CommentsController;
use App\Http\Controllers\Api\V1\NewsController;
use App\Http\Controllers\Api\V1\User\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::prefix('v1')->group(function () {
    Route::prefix('auth')->group(function () {
        Route::prefix('admin')->group(function () {
            Route::post('/login', [AuthController::class, 'login']);
            Route::post('/register', [AuthController::class, 'registerAdmin']);
        });
        Route::prefix('member')->group(function () {
            Route::post('/login', [AuthController::class, 'login']);
            Route::post('/register', [AuthController::class, 'registerMember']);
        });
        Route::post('/logout', [AuthController::class, 'logout'])->middleware(['auth:api','scope:admin,member']);
    });
    Route::prefix('news')->group(function () {
        Route::get('/', [NewsController::class, 'index']);
        Route::get('/{id}', [NewsController::class, 'getDataById']);
        Route::post('/', [NewsController::class, 'insertDataNews'])->middleware(['auth:api','scope:admin']);
        Route::put('/{id}', [NewsController::class, 'updateDataNews'])->middleware(['auth:api','scope:admin']);
        Route::delete('/{id}', [NewsController::class, 'deleteDataNews'])->middleware(['auth:api','scope:admin']);
    });

    Route::post('comment', [CommentsController::class, 'createComment'])->middleware(['auth:api','scope:admin,member']);

});
