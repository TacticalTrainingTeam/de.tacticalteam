<?php

use Illuminate\Support\Facades\Route;

Route::prefix('intern')->middleware(['auth', \App\Http\Middleware\IsActive::class])->group(function () {
    Route::get('/start', [\App\Http\Controllers\InternController::class, 'index'])->name('start');
    Route::get('/missionsupload', [\App\Http\Controllers\MissionsuploadController::class, 'index'])->name('missionupload.index')->middleware([\App\Http\Middleware\IsMissionsbauer::class]);
    Route::get('/missionsupload/upload', function () {
        return view('intern.missionupload.upload');
    })->name('missionsupload.upload')->middleware([\App\Http\Middleware\IsMissionsbauer::class]);
    Route::post('/missionsupload/store', [\App\Http\Controllers\MissionsuploadController::class, 'store'])->name('missionsupload.store')->middleware([\App\Http\Middleware\IsMissionsbauer::class]);
    Route::get('/offizier/missionsteilnahme', [\App\Http\Controllers\Controller::class, 'missionsteilnahme'])->name('offizier.missionsteilnahme')->middleware([\App\Http\Middleware\IsOffizier::class]);
    Route::get('/offizier/user', [\App\Http\Controllers\Controller::class, 'uebersicht'])->name('offizier.user')->middleware([\App\Http\Middleware\IsOffizier::class]);
    Route::get('/squadxml', [\App\Http\Controllers\SquadXmlController::class, 'index'])->name('squadxml.index');
    Route::post('/squadxml/store', [\App\Http\Controllers\SquadXmlController::class, 'store'])->name('squadxml.store');
    Route::get('/squadxml/test', [\App\Http\Controllers\SquadXmlController::class, 'test'])->name('squadxml.test');
    Route::get('/squadxml/steam', [\App\Http\Controllers\SquadXmlController::class, 'steam'])->name('squadxml.steam');
});
