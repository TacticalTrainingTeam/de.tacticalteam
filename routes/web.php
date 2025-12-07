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
    $offiziere = \App\Models\Offiziere::where('active', 1)->get();
    return view('start', compact('offiziere'));
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
Route::get('/datenschutz-social-media', function () {
    return view('datenschutz-social-media');
})->name('datenschutz.social-media');
Route::get('/chronik', function () {
    return view('10jahre');
})->name('chronik');
Route::get('/medien', [\App\Http\Controllers\TwitchController::class, 'index'])->name('medien');

Route::post('/logout', [\App\Http\Controllers\Controller::class, 'destroy'])->name('logout')->middleware(['auth']);

require_once 'auth.php';
require_once 'campaigns.php';

// Fallback route - redirect all undefined routes to home
Route::fallback(function () {
    return redirect()->route('home');
});
