<?php

use App\Models\News;
use App\Models\User;
use App\Jobs\UserComments;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Queue;
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
    return view('welcome');
});

Route::get('/queue', function () {
    $userId = User::where("is_admin", false)->inRandomOrder()->first()->id;
    $newsId = News::inRandomOrder()->first()->id;
    UserComments::dispatch($userId, $newsId);
});
