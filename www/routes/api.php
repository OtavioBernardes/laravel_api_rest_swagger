<?php

use App\Http\Controllers\ProductController;
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

Route::get('product', [ProductController::class, 'get']);
Route::post('product', [ProductController::class, 'add']);
Route::delete('product/{id}', [ProductController::class, 'delete']);
Route::put('product/{id}', [ProductController::class, 'update']);
