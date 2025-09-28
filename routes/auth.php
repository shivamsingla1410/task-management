<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {

    Route::get('login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');

    Route::post('login', [AuthenticatedSessionController::class, 'store']);
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Admin routes
    Route::middleware('role:admin')->group(function () {
        Route::resource('users', UserController::class);
        Route::resource('projects', ProjectController::class);
    });
    
    // Manager routes
    Route::middleware('role:manager,admin')->group(function () {
        Route::resource('projects', ProjectController::class);
        Route::resource('tasks', TaskController::class);
    });

    // User routes
    Route::middleware('role:user,manager,admin')->group(function () {
        /* Route::middleware('role:user')->group(function() {
            Route::get('/tasks/updates', function (Request $request) {
                $lastUpdatedAt = $request->query('last_updated_at');
            
                $query = Task::query();
            
                if ($lastUpdatedAt) {
                    $query->where('updated_at', '>', $lastUpdatedAt);
                }
            
                return response()->json([
                    'tasks' => $query->get(),
                    'last_updated_at' => now()->toDateTimeString(),
                ]);
            });
        }); */
        
        Route::resource('tasks', TaskController::class)->only(['index', 'edit', 'update']);
    });
    
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');
});
