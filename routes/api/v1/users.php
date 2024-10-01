<?php

// This line of code replaces the lines below.
// Route::apiResource('users', \App\Http\Controllers\UserController::class);

use Illuminate\Support\Facades\Route;

Route::middleware([
    // 'auth',
    // \App\Http\Middleware\RedirectIfAuthenticated::class
    ])
    ->prefix('heyaa')
    ->name('users.')
    // As does the same thing as name.
    // ->as('index.')
    ->namespace('\App\Http\Controllers')
    ->group(function() {
        Route::get('/users', [\App\Http\Controllers\UserController::class, 'index'])
            ->name('index')
            ->withoutMiddleware('auth');
        // This does the same as above.
        //Route::get('/users', 'UserController@index')->name('index');
    
        // Substitute Bindings
        Route::get('/users/{user}', [\App\Http\Controllers\UserController::class, 'show'])
            ->name('show')
            // ->where('user', '[0-9]+')
            ->whereNumber('user');

        Route::post('/users', [\App\Http\Controllers\UserController::class, 'store'])->name('store');

        Route::patch('/users/{user}', [\App\Http\Controllers\UserController::class, 'update'])->name('update');

        Route::delete('/users/{user}', [\App\Http\Controllers\UserController::class, 'destroy'])->name('destroy');
    });

// Route::group([
//     'middleware' => [
//         'auth',
//     ],
//     'prefix' => 'heyaa',
//     'as' => 'users.',
//     'namespace' => "\App\Http\Controllers",
// ], function(){
//     Route::get('/users', [\App\Http\Controllers\UserController::class, 'index'])->name('index');
//     // This does the same as above.
//     //Route::get('/users', 'UserController@index')->name('index');
    
//     // Substitute Bindings
//     Route::get('/users/{user}', [\App\Http\Controllers\UserController::class, 'show'])->name('show');

//     Route::post('/users', [\App\Http\Controllers\UserController::class, 'store'])->name('store');

//     Route::patch('/users/{user}', [\App\Http\Controllers\UserController::class, 'update'])->name('update');

//     Route::delete('/users/{user}', [\App\Http\Controllers\UserController::class, 'destroy'])->name('destroy');
// });