<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ReceiptController;
use App\Http\Controllers\FollowupController;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\EvangelismController;

Route::middleware(['web'])->group(function() {
    Route::get('/notifications', [NotificationController::class, 'create'])->name('notifications.create');
    Route::post('/notifications/send', [NotificationController::class, 'send'])->name('notifications.send');

    // Follow‑up management routes
    Route::resource('followups', FollowupController::class);
    Route::post('followups/{followup}/complete', [FollowupController::class, 'complete'])->name('followups.complete');

    // Leads CRUD (evangelism contacts)
    Route::resource('leads', LeadController::class)->except(['show']);

    // Evangelism messaging – send messages to leads
    Route::get('/evangelism', [EvangelismController::class, 'create'])->name('evangelism.create');
    Route::post('/evangelism/send', [EvangelismController::class, 'send'])->name('evangelism.send');
});

Route::get('/receipts/tithes/{id}', [ReceiptController::class, 'tithe'])->name('receipts.tithe');
Route::get('/receipts/offerings/{id}', [ReceiptController::class, 'offering'])->name('receipts.offering');
