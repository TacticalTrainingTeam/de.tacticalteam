<?php

use App\Http\Controllers\CampaignController;
use App\Http\Middleware\IsOffizier;
use Illuminate\Support\Facades\Route;

Route::prefix('/campaign')->group(function () {
    Route::get('/{slug}', [CampaignController::class, 'show'])->name('campaign.show');
    Route::get('/{slug}/edit', [CampaignController::class, 'edit'])->name('campaign.edit')->middleware([IsOffizier::class]);
    Route::post('/{slug}/store', [CampaignController::class, 'store'])->name('campaign.store')->middleware([IsOffizier::class]);
});

Route::prefix('/campaign/management')->middleware([IsOffizier::class])->group(function () {
    Route::get('/all', [CampaignController::class, 'showall'])->name('campaign.showall');
    Route::get('/add', [CampaignController::class, 'add'])->name('campaign.add');
    Route::post('/store', [CampaignController::class, 'store'])->name('campaignmgt.store');
});
