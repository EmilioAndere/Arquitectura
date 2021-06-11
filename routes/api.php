<?php

use App\Http\Controllers\ApiController;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/genre', [ApiController::class, 'getGenre']);

Route::get('/get/genres', [ApiController::class, 'getAllGenres']);

Route::get('/get/genre/{id}', [ApiController::class, 'getOneGenre']);

Route::get('get/artist/{id}', [ApiController::class, 'getOneArtist']);
