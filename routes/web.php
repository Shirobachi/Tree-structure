<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\loginController;
use App\Http\Controllers\registerController;
use App\Http\Controllers\treeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [loginController::class, 'index']);
Route::post('/', [loginController::class, 'logIn']);

Route::get('/register', [registerController::class, 'index']);
Route::post('/register', [registerController::class, 'signup']);

Route::get('/tree', [treeController::class, 'show']);