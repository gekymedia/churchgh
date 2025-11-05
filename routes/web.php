<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\TitheController;
use App\Http\Controllers\OfferingController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\EvangelismController;
use App\Http\Controllers\FollowupController;
use App\Http\Controllers\LeadController;


Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

Route::resource('members', MemberController::class);
Route::resource('services', ServiceController::class);
Route::resource('leads', LeadController::class);
Route::resource('followups', FollowupController::class);
Route::post('followups/{followup}/complete', [FollowupController::class, 'complete'])->name('followups.complete');
Route::resource('events', EventController::class)->except(['show']);

// Attendance & Giving
Route::get('attendances', [AttendanceController::class, 'index'])->name('attendances.index');
Route::post('attendances/mark', [AttendanceController::class, 'store'])->name('attendances.store');

// Notificaiton
Route::get('notification', [NotificationController::class, 'create'])->name('notifications.create');
Route::post('notification/send', [NotificationController::class, 'send'])->name('notifications.send');

// Evangelism
Route::get('evangelism', [EvangelismController::class, 'create'])->name('evangelism.create');
Route::post('evangelism/send', [EvangelismController::class, 'send'])->name('evangelism.send');

Route::prefix('givings')->group(function () {
    Route::get('tithes', [TitheController::class, 'index'])->name('tithes.index');
    Route::post('tithes', [TitheController::class, 'store'])->name('tithes.store');
    Route::get('offerings', [OfferingController::class, 'index'])->name('offerings.index');
    Route::post('offerings', [OfferingController::class, 'store'])->name('offerings.store');
});
