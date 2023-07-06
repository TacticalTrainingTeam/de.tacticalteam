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
Route::get('/reforger', function () {
    return view('reforger');
})->name('reforger');

// Dieser Redirct muss sein, da der login automatisch nach home geht
Route::get('/home', function () {
    return redirect('/intern/start');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [\App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
});

require_once 'auth.php';
