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


Route::prefix('/tree')->group(function () {
    Route::get('/', [treeController::class, 'show']);
    Route::get('{parentId}/new/{name}', [treeController::class, 'new']);
    Route::get('{id}/edit/{newName}', [treeController::class, 'edit']);
    Route::get('{id}/delete', [treeController::class, 'delete']);
    Route::prefix('/{id}/sort')->group(function () {
        Route::get('up', [treeController::class, 'sortUp']);
        Route::get('down', [treeController::class, 'sortDown']);
    });
    Route::get('{id}/move', [treeController::class, 'move']);
    Route::post('move', [treeController::class, 'processMove']);
});

Route::get('/logout', function () {
    session()->forget('userID');
    return redirect(url('/'));
});
