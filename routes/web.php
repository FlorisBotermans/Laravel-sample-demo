<?php

use App\Mail\WelcomeMail;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;
use Laravel\Fortify\Http\Controllers\NewPasswordController;

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

Route::get('/reset-password/{token}', function ($token) {
    return $token;
})  ->middleware(['guest:'.config('fortify.guard')])
    ->name('password.reset');

    Route::get('/shared/posts/{post}', function(Request $request, Post $post){
        return "Specially made just for your;) Post id: {$post->id}";
    })->name('shared.post')->middleware('signed');

if (App::environment('local')) {

    // Route::get('/shared/videos/{video}', function (Request $request, $video) {

    //     // if(!$request->hasValidSignature()){
    //     //     abort(401);
    //     // }

    //     return 'git gud';
    // })->name('share-video')->middleware('signed');

    
    // Route that expires after 30 seconds
    Route::get('/playground', function () {
        $url = URL::temporarySignedRoute('share-video', now()->addSeconds(30), ['video' => 123]);
        return $url;
    });
}