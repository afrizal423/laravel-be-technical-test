<?php

use App\Http\Controllers\Api\V1\NewsController;
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
    Route::get('news', [NewsController::class, 'index']);
    Route::get('news/{id}', [NewsController::class, 'getDataById']);
    Route::post('news', [NewsController::class, 'insertDataNews']);
    Route::put('news/{id}', [NewsController::class, 'updateDataNews']);
    Route::delete('news/{id}', [NewsController::class, 'deleteDataNews']);
});
