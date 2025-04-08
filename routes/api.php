<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
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

Route::middleware('auth:sanctum')->group(function(){
    //user
    Route::post('/register',[AuthController::class,'register'])->withoutMiddleware('auth:sanctum');
    Route::post('/login',[AuthController::class,'login'])->withoutMiddleware('auth:sanctum');;
    Route::post('/logout',[AuthController::class,'logout']);
    Route::get('/profile',[AuthController::class,'myprofile']);

    //post
    Route::prefix('post')->group(function(){
        Route::get('/',[PostController::class,'index']);
        Route::post('/',[PostController::class,'store']);
        Route::put('/{id}',[PostController::class,'update']);
        Route::delete('/{id}',[PostController::class,'destroy']);
    });
});
