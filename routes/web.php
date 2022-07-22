<?php

use App\Http\Controllers\ClassesController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

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

Route::get('/',  [ClassesController::class, 'index'])->name('home');
Route::get('/classes', [ClassesController::class, 'classes'])->name('classes');

Route::prefix('dev')->group(function () { // test

    // Production



    // Stage

    // if (config('app.env') === 'production') return;

    Route::get('clear-cache', function() {
        Artisan::call('cache:clear');

        return "Cache is cleared";
    });

    Route::get('optimize', function () {
        Artisan::call('optimize');

        return "Optimized";
    });

    Route::get('/version', function () {
        return view('welcome');
    });
});

