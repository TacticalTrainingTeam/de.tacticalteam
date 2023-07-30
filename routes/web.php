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
Route::get('/10jahre', function () {
    return view('10jahre');
})->name('10jahre');

// Dieser Redirct muss sein, da der login automatisch nach home geht
Route::get('/home', function () {
    return redirect('/intern/start');
});

Route::post('/logout', [\App\Http\Controllers\Controller::class, 'destory'])->name('logout')->middleware(['auth']);

require_once 'auth.php';
require_once 'campaigns.php';
