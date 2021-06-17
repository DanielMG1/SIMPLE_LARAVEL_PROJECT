<?php

use Illuminate\Support\Facades\Route;

use App\Mail\NotificationMailable;
use Illuminate\Support\Facades\Mail;
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

// You need to authenticate
Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

// Movies CRUD routes
Route::resource('movies', App\Http\Controllers\MovieController::class)->middleware('auth');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Mail Notification
Route::get('notification', function () {
    $mail = new NotificationMailable;
    Mail::to('danielmelangiraldo@gmail.com')->send($mail);

    return "Message sent";
});
