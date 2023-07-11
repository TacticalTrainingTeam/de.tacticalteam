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
    Route::get('/offizier/missionsteilnahme', [\App\Http\Controllers\Controller::class, 'missionsteilnahme'])->name('offizier.missionsteilnahme')->middleware(['auth', \App\Http\Middleware\IsOffizier::class]);
    Route::get('/squadxml', [\App\Http\Controllers\SquadXmlController::class, 'index'])->name('squadxml.index')->middleware(['auth']);
    Route::post('/squadxml/store', [\App\Http\Controllers\SquadXmlController::class, 'store'])->name('squadxml.store')->middleware(['auth']);
    Route::get('/squadxml/test', [\App\Http\Controllers\SquadXmlController::class, 'test'])->name('squadxml.test')->middleware(['auth']);
});
