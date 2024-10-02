<?php

use App\Mail\WelcomeMail;
use App\Models\User;
use Illuminate\Support\Facades\App;
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

Route::get('/', function () {
    return view('welcome');
});

if (App::environment('local')) {
    Route::get('/playground', function () {
        return (new WelcomeMail(User::factory()->make()))->render();
    });
}