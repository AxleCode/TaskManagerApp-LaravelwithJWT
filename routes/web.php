<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TaskController;
use App\Http\Middleware\RoleMiddleware;

Route::get('/', [AuthController::class, 'showAuthForm'])->name('auth.form');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::post('/register', [AuthController::class, 'register'])->name('register.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function(){
    Route::get('/dashboard',[DashboardController::class,'index'])->name('dashboard');

   // User routes (role 0)
   Route::get('/my-tasks',[TaskController::class,'myTasks'])->name('tasks.my'); // lihat task sendiri
   Route::get('/tasks/create',[TaskController::class,'create'])->name('tasks.create'); // create task
   Route::post('/tasks',[TaskController::class,'store'])->name('tasks.store'); // store task
   Route::get('/tasks/{task}/edit',[TaskController::class,'edit'])->name('tasks.edit'); // edit task
   Route::put('/tasks/{task}',[TaskController::class,'update'])->name('tasks.update'); // update task
   Route::delete('/tasks/{task}',[TaskController::class,'destroy'])->name('tasks.destroy'); // delete task

   // Admin routes (role 1)
   Route::middleware([RoleMiddleware::class.':1'])->group(function(){
       Route::get('/tasks',[TaskController::class,'index'])->name('tasks.index'); // semua task
   });
});

