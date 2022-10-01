<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\UserController;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::get('/genres', [GenreController::class, 'index']);
Route::get('/movies', [MovieController::class, 'index']);

Route::group(['middleware' => ['auth:sanctum', 'admin']], function () {
    Route::apiResource('users', UserController::class);
    Route::apiResource('movies', MovieController::class)->except('index');
    Route::apiResource('genres', GenreController::class)->except('index');
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return new UserResource($request->user());
});
