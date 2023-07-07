<?php

use Illuminate\Support\Facades\Route;

Route::prefix('intern')->group(function () {
    Route::get('/start', function () {
        return view('intern.start');
    })->name('start')->middleware('auth');
    Route::get('/missionsupload', [\App\Http\Controllers\MissionsuploadController::class, 'index'])->name('missionupload.index')->middleware(['auth', \App\Http\Middleware\IsMissionsbauer::class]);
    Route::get('/missionsupload/upload', function () {
        return view('intern.missionupload.upload');
    })->name('missionsupload.upload')->middleware(['auth', \App\Http\Middleware\IsMissionsbauer::class]);
    Route::post('/missionsupload/store', [\App\Http\Controllers\MissionsuploadController::class, 'store'])->name('missionsupload.store')->middleware(['auth', \App\Http\Middleware\IsMissionsbauer::class]);
});
