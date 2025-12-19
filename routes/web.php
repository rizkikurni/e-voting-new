<?php

use App\Http\Controllers\CandidateController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\SubscriptionPlanController;
use App\Http\Controllers\VoteController;
use App\Http\Controllers\VoterTokenController;

Route::get('/', [HomeController::class, 'index'])->name('home');
// Route::get('/vote', [HomeController::class, 'vote'])->name('vote');
// Route::get('/vote-result', [HomeController::class, 'voteResult'])->name('vote.result');
Route::get('/vote/{event}', [HomeController::class, 'vote'])
    ->name('voting.show');

Route::post('/vote/{event}', [HomeController::class, 'voteStore'])
    ->name('voting.store');




// Auth pages
Route::get('/login', [UserController::class, 'showLoginForm'])->name('login');
Route::post('/login', [UserController::class, 'login']);

Route::get('/register', [UserController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [UserController::class, 'register']);

Route::post('/logout', [UserController::class, 'logout'])->name('logout');


// khusus admin
Route::middleware(['auth', 'role:admin'])->group(function () {

    Route::get('/dashboard-admin', [DashboardController::class, 'admin'])->name('admin.dashboard');


    Route::resource('users', UserController::class);

    Route::resource('subscription-plans', SubscriptionPlanController::class);
});
// khusus customer / user
Route::middleware(['auth', 'role:customer'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/checkout/{plan}', [CheckoutController::class, 'checkout'])
        ->name('checkout');

    Route::get('/payment/success', [PaymentController::class, 'success'])
        ->name('payment.success');

    Route::get('/payment/pending/{orderId}', [PaymentController::class, 'pending'])
        ->name('payment.pending');

    // TAMBAHKAN ROUTE INI
    Route::get('/payment/pay/{orderId}', [PaymentController::class, 'pay'])
        ->name('payment.pay');

    Route::get('/payment/check/{orderId}', [PaymentController::class, 'checkStatus'])
        ->name('payment.check');

    Route::get('/payments', [PaymentController::class, 'index'])
        ->name('payments.index');

    Route::get('/my-subscriptions', [SubscriptionPlanController::class, 'subscriptions'])
        ->name('subscriptions.index');

    Route::get('/plans', [SubscriptionPlanController::class, 'plans'])
        ->name('plans.index');
});

Route::middleware(['auth', 'role:customer,admin'])->group(function () {
    Route::get('/profile', [UserController::class, 'profile'])->name('profile.index');
    Route::put('/profile', [UserController::class, 'updateProfile'])->name('profile.update');

    Route::resource('events', EventController::class);
    Route::post('events/{event}/publish', [EventController::class, 'publish'])->name('events.publish');
    Route::post('events/{event}/lock', [EventController::class, 'lock'])->name('events.lock');

    Route::middleware(['auth', 'role:customer,admin'])->group(function () {
        Route::get('/profile', [UserController::class, 'profile'])->name('profile.index');
        Route::put('/profile', [UserController::class, 'updateProfile'])->name('profile.update');
    });


    Route::get('/candidates', [CandidateController::class, 'all'])->name('candidates.index');
    Route::resource('events.candidates', CandidateController::class);

    // Ringkasan token per event
    Route::get('/voter-tokens', [VoterTokenController::class, 'index'])
        ->name('voter-tokens.index');

    // Detail token berdasarkan event
    Route::get('/voter-tokens/{event}', [VoterTokenController::class, 'show'])
        ->name('voter-tokens.show');

    // Generate token baru (awal)
    Route::get('/voter-tokens/{event}/create', [VoterTokenController::class, 'create'])
        ->name('voter-tokens.create');
    Route::post('/voter-tokens/{event}', [VoterTokenController::class, 'store'])
        ->name('voter-tokens.store');

    // Tambah jumlah token
    Route::get('/voter-tokens/{event}/add', [VoterTokenController::class, 'addView'])
        ->name('voter-tokens.add-view');
    Route::post('/voter-tokens/{event}/add', [VoterTokenController::class, 'add'])
        ->name('voter-tokens.add');

    Route::get('votes', [VoteController::class, 'index'])->name('votes.index');
    Route::get('votes/{event}', [VoteController::class, 'show'])->name('votes.show');
});



// Route Dummy
// komentar kalau sudah buat fiturnya
/*
|--------------------------------------------------------------------------
| AUTH & DASHBOARD
|--------------------------------------------------------------------------
*/

// Route::get('/profile', fn () => view('profile.index'))->name('profile.index');

/*
|--------------------------------------------------------------------------
| CUSTOMER AREA
|--------------------------------------------------------------------------
*/

// EVENTS
// Route::get('/events', fn () => 'Events Index')->name('events.index');
// Route::get('/events/create', fn () => 'Create Event')->name('events.create');

// CANDIDATES
// Route::get('/candidates', fn() => 'Candidates Index')->name('candidates.index');

// VOTER TOKENS
// Route::get('/voter-tokens', fn() => 'Voter Tokens')->name('voter-tokens.index');

// VOTES / RESULT
// Route::get('/votes', fn() => 'Voting Result')->name('votes.index');

/*
|--------------------------------------------------------------------------
| SUBSCRIPTION & PAYMENT
|--------------------------------------------------------------------------
*/

// PLANS (LIST FOR CUSTOMER)
// Route::get('/subscription-plans', fn () => 'Subscription Plans')
//     ->name('subscription-plans.index');

// USER SUBSCRIPTIONS
// Route::get('/subscriptions', fn() => 'My Subscriptions')
//     ->name('subscriptions.index');

// PAYMENTS
// Route::get('/payments', fn() => 'Payments History')
//     ->name('payments.index');

/*
|--------------------------------------------------------------------------
| ADMIN AREA
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->middleware('auth')->group(function () {

    Route::get('/dashboard', fn() => 'Admin Dashboard')
        ->name('admin.dashboard');

    // EVENTS
    Route::get('/events', fn() => 'All Events')
        ->name('admin.events.index');

    // CANDIDATES
    Route::get('/candidates', fn() => 'All Candidates')
        ->name('admin.candidates.index');

    // TOKENS
    Route::get('/tokens', fn() => 'All Tokens')
        ->name('admin.tokens.index');

    // VOTES
    Route::get('/votes', fn() => 'Vote Recap')
        ->name('admin.votes.index');

    // PAYMENTS
    Route::get('/payments', fn() => 'All Payments')
        ->name('admin.payments.index');

    // USER SUBSCRIPTIONS
    Route::get('/subscriptions', fn() => 'User Subscriptions')
        ->name('admin.subscriptions.index');

    // MANAGE PLANS
    Route::get('/plans', fn() => 'Manage Plans')
        ->name('plans.management');

    // USERS
    Route::get('/users', fn() => 'User Management')
        ->name('users.index');
});

/*
|--------------------------------------------------------------------------
| LOGOUT
|--------------------------------------------------------------------------
*/

// Route::post('/logout', function () {
//     auth()->logout();
//     return redirect('/login');
// })->name('logout');
