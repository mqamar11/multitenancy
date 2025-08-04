<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('login', [AuthController::class, 'login']);

Route::get('/{any}', function () {
    return view('posts.posts'); // loads Vue app
})->where('any', '.*');


