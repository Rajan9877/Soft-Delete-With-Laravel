<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

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

Route::get('/', [UserController::class, 'index']);
Route::post('/delete-user', [UserController::class, 'deleteUser']);
Route::post('/restore-user', [UserController::class, 'restoreUser']);
Route::get('/fetch-users', [UserController::class, 'fetchUsers']);
Route::get('/recycled-users', [UserController::class, 'recycledUsers']);
Route::get('/tem-del-users', [UserController::class, 'temDeletedUsers']);
Route::post('/permanent-delete-user', [UserController::class, 'permanentDeleteUser']);
