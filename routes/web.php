<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('start');
})->name('home');
Route::get('/mitmachen', function () {
    return view('mitmachen');
})->name('mitmachen');
Route::get('/impressum', function () {
    return view('impressum');
})->name('impressum');
Route::get('/newsletter', function () {
    return view('newsletter');
})->name('newsletter');
Route::get('/datenschutz', function () {
    return view('datenschutz');
})->name('datenschutz');
Route::get('/reforger', function () {
    return view('reforger');
})->name('reforger');
