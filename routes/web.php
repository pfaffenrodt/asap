<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Config;
use Inertia\Inertia;

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
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'asapVersion' => Config::get('app.version'),
    ]);
});

Route::get('/goodbye-browser', function () {
    return view('unsupported-browser');
})->name('unsupported-browser');

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->name('dashboard');
