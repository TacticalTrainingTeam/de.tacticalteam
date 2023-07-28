<?php

use App\Http\Controllers\Controller;
use App\Http\Controllers\InternController;
use App\Http\Controllers\MissionsuploadController;
use App\Http\Controllers\OffizierController;
use App\Http\Controllers\SquadXmlController;
use App\Http\Middleware\IsActive;
use App\Http\Middleware\IsMissionsbauer;
use App\Http\Middleware\IsOffizier;
use Illuminate\Support\Facades\Route;

Route::prefix('intern')->middleware(['auth', IsActive::class])->group(function () {
    Route::get('/start', [InternController::class, 'index'])->name('start');

    Route::get('/missionsupload', [MissionsuploadController::class, 'index'])->name('missionupload.index')->middleware([IsMissionsbauer::class]);
    Route::get('/missionsupload/upload', function () {
        return view('intern.missionupload.upload');
    })->name('missionsupload.upload')->middleware([IsMissionsbauer::class]);
    Route::post('/missionsupload/store', [MissionsuploadController::class, 'store'])->name('missionsupload.store')->middleware([IsMissionsbauer::class]);

    Route::get('/offizier/missionsteilnahme', [Controller::class, 'missionsteilnahme'])->name('offizier.missionsteilnahme')->middleware([IsOffizier::class]);
    Route::get('/offizier/user', [Controller::class, 'uebersicht'])->name('offizier.user')->middleware([IsOffizier::class]);
    Route::get('/offizier/userstatus/{userid}', [OffizierController::class, 'userstatus'])->name('offizier.userstatus')->middleware([IsOffizier::class]);
    Route::post('/offizier/userstatus/store', [OffizierController::class, 'store'])->name('offizier.userstatus.store')->middleware([IsOffizier::class]);

    Route::get('/squadxml', [SquadXmlController::class, 'index'])->name('squadxml.index');
    Route::post('/squadxml/store', [SquadXmlController::class, 'store'])->name('squadxml.store');
    Route::get('/squadxml/test', [SquadXmlController::class, 'test'])->name('squadxml.test');
    Route::get('/squadxml/steam', [SquadXmlController::class, 'steam'])->name('squadxml.steam');
});
