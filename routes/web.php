<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
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
Auth::routes();

Route::get('/', function () {
    return redirect()->route('tasks.index');
});



Route::group([], function () {
    Route::get('/home', [TaskController::class, 'index'])->name('tasks.index');
    Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store')->middleware('auth');
    Route::put('/tasks/{id}', [TaskController::class, 'update'])->name('tasks.update');
    Route::delete('/tasks/{id}', [TaskController::class, 'destroy'])->name('tasks.destroy');
});




Route::middleware(['role'])->group(function () {
    Route::get('/admin-panel', [UserController::class, 'index'])->name('users.index');
    Route::post('/update/{id}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');
});

