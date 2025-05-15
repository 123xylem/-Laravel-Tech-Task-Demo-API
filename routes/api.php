<?php

use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\LogHttpRequests;
use App\Http\Middleware\ValidateSignature;

Route::prefix('tasks')->controller(TaskController::class)->group(function () {
  Route::get('/', 'index')
    ->name('tasks.index')
    ->middleware(LogHttpRequests::class);
  Route::post('/', 'store')
    ->name('tasks.store')
    ->middleware(LogHttpRequests::class);
  Route::get('/{task}', 'show')
    ->name('tasks.show')
    ->middleware(LogHttpRequests::class);
  Route::put('/{task}', 'update')
    ->name('tasks.update')
    ->middleware([LogHttpRequests::class, 'signed']);
  Route::delete('/{task}', 'destroy')
    ->name('tasks.destroy')
    ->middleware([LogHttpRequests::class, 'signed']);
});
