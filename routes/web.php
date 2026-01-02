<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
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
use App\Http\Controllers\MemberDashboardController;
use App\Http\Controllers\GivingController;
use App\Http\Controllers\QuoteController;
use App\Http\Controllers\EventRegistrationController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\ChurchLeaderController;
use App\Http\Controllers\ShepherdController;
use App\Http\Controllers\AdminSettingsController;
use App\Http\Controllers\PaymentController;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| The routes defined below provide entry points for both public and
| authenticated sections of the ChurchGH application.  We leverage
| middleware to secure routes and separate functionality based on user
| roles.  Members, leaders/pastors and admins each have distinct
| dashboards and capabilities.  Public pages such as the login form are
| available without authentication.
*/

// Authentication routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Home page – redirect to appropriate dashboard based on authentication
Route::get('/', function () {
    if (auth()->check()) {
        $user = auth()->user();
        if ($user->role === 'member') {
            return redirect()->route('member.dashboard');
        }
        return redirect()->route('dashboard');
    }
    return redirect()->route('login');
});

/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
|
| These routes require an authenticated user.  Within the authenticated
| group we further segment access based on role using the custom
| `role` middleware (registered in AppServiceProvider).  Members have
| access to their own dashboard, giving, event registration and
| notification preferences.  Leaders and admins have access to full
| management functionality for members, events, evangelism, giving and
| follow‑ups.
*/
Route::middleware('auth')->group(function () {
    // Member routes
    Route::middleware('role:member')->group(function () {
        // member dashboard
        Route::get('/member/dashboard', [MemberDashboardController::class, 'index'])->name('member.dashboard');
        // online giving (member facing)
        Route::get('/giving', [GivingController::class, 'create'])->name('giving.create');
        Route::post('/giving', [GivingController::class, 'store'])->name('giving.store');
        // event registration
        Route::post('/events/{event}/register', [EventRegistrationController::class, 'store'])->name('events.register');
        // settings / preferences
        Route::get('/settings', [SettingsController::class, 'edit'])->name('settings.edit');
        Route::put('/settings', [SettingsController::class, 'update'])->name('settings.update');
    });

    // Admin/leader/pastor routes
    Route::middleware('role:admin|pastor|leader')->group(function () {
        // dashboard for admins/leaders
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        // member management
        Route::resource('members', MemberController::class);
        // service & attendance
        Route::resource('services', ServiceController::class);
        Route::get('attendances', [AttendanceController::class, 'index'])->name('attendances.index');
        Route::post('attendances/mark', [AttendanceController::class, 'store'])->name('attendances.store');
        // leads & followups
        Route::resource('leads', LeadController::class);
        Route::resource('followups', FollowupController::class);
        Route::post('followups/{followup}/complete', [FollowupController::class, 'complete'])->name('followups.complete');
        // events
        Route::resource('events', EventController::class)->except(['show']);
        // event registrations listing (optional) could be added here
        // giving records for admins
        Route::get('/givings', [GivingController::class, 'index'])->name('giving.index');
        // existing tithes/offerings (legacy offline giving)
        Route::get('/tithes', [TitheController::class, 'index'])->name('tithes.index');
        Route::post('/tithes', [TitheController::class, 'store'])->name('tithes.store');
        Route::get('/offerings', [OfferingController::class, 'index'])->name('offerings.index');
        Route::post('/offerings', [OfferingController::class, 'store'])->name('offerings.store');
        // notifications & evangelism
        Route::get('/notifications', [NotificationController::class, 'create'])->name('notifications.create');
        Route::post('/notifications', [NotificationController::class, 'send'])->name('notifications.send');
        Route::get('/evangelism', [EvangelismController::class, 'create'])->name('evangelism.create');
        Route::post('/evangelism', [EvangelismController::class, 'send'])->name('evangelism.send');
        // quotes management
        Route::resource('quotes', QuoteController::class);
        // church leaders/officers
        Route::resource('church-leaders', ChurchLeaderController::class);
        // shepherd assignment (admin only)
        Route::get('/shepherds/assign', [ShepherdController::class, 'showAssignForm'])->name('shepherds.assign');
        Route::post('/shepherds/assign', [ShepherdController::class, 'assign'])->name('shepherds.assign.store');
        // admin settings
        Route::get('/admin/settings', [AdminSettingsController::class, 'index'])->name('admin.settings.index');
        Route::post('/admin/settings', [AdminSettingsController::class, 'update'])->name('admin.settings.update');
    });

    // Shepherd routes (for shepherds to view their flock)
    Route::middleware('auth')->group(function () {
        Route::get('/shepherd/flock', [ShepherdController::class, 'index'])->name('shepherd.flock');
    });

    // Payment routes
    Route::middleware('auth')->group(function () {
        Route::post('/payment/initialize', [PaymentController::class, 'initialize'])->name('payment.initialize');
        Route::get('/payment/callback', [PaymentController::class, 'callback'])->name('payment.callback');
    });
});
