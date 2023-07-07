<?php

use Illuminate\Support\Facades\Route;

Route::prefix('intern')->group(function () {
    Route::get('/start', function () {
        return view('intern.start');
    })->name('start')->middleware('auth');
    Route::get('/missionsupload', [\App\Http\Controllers\MissionsuploadController::class, 'index'])->name('missionupload')->middleware(['auth', \App\Http\Middleware\IsMissionsbauer::class]);
});
