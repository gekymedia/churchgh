<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ReceiptController;
use App\Http\Controllers\FollowupController;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\EvangelismController;

/*
|--------------------------------------------------------------------------
| Plus Routes
|--------------------------------------------------------------------------
|
| This file previously contained follow‑up and evangelism routes.  These
| routes have been consolidated into routes/web.php under the proper
| authentication and role guards.  The plus file now only defines
| receipt routes for legacy giving receipts.
*/

Route::get('/receipts/tithes/{id}', [ReceiptController::class, 'tithe'])->name('receipts.tithe');
Route::get('/receipts/offerings/{id}', [ReceiptController::class, 'offering'])->name('receipts.offering');
