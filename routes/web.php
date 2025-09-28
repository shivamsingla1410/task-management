<?php

use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/tasks/updates', [TaskController::class, 'getTasksUpdate'])->middleware('auth');

require __DIR__.'/auth.php';
