<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');


// Auth pages
Route::get('/login', [UserController::class, 'showLoginForm'])->name('login');
Route::post('/login', [UserController::class, 'login']);

Route::get('/register', [UserController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [UserController::class, 'register']);

Route::post('/logout', [UserController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    // User resource
    Route::resource('users', UserController::class);

});

// Route dummy

// ====== EVENTS ======
//
Route::get('/vote', function () {
    return view('landing.vote');
})->name('vote');

Route::get('/vote-result', function () {
    return view('landing.vote-result');
})->name('vote-result');

Route::get('/events', function () {
    return 'Daftar Event (dummy)';
})->name('events.index');

Route::get('/events/create', function () {
    return 'Create Event Page (dummy)';
})->name('events.create');


//
// ====== CANDIDATES ======
//
Route::get('/candidates', function () {
    return 'Daftar Kandidat (dummy)';
})->name('candidates.index');


//
// ====== VOTER TOKENS ======
//
Route::get('/voter-tokens', function () {
    return 'Daftar Token (dummy)';
})->name('voter-tokens.index');


//
// ====== VOTES / RESULTS ======
//
Route::get('/votes', function () {
    return 'Hasil Voting (dummy)';
})->name('votes.index');


//
// ====== SUBSCRIPTION / PLANS ======
//
Route::get('/plans', function () {
    return 'Daftar Paket (dummy)';
})->name('plans.index');

Route::get('/subscriptions', function () {
    return 'Langgananku (dummy)';
})->name('subscriptions.index');

Route::get('/payments', function () {
    return 'Payments List (dummy)';
})->name('payments.index');


//
// ====== ADMIN MENU ======
//
// Route::get('/admin/users', function () {
//     return 'Admin Users (dummy)';
// })->name('users.index');

Route::get('/admin/plans/management', function () {
    return 'Manage Subscription Plans (dummy)';
})->name('plans.management');


//
// ====== PROFILE / SETTINGS ======
//
Route::get('/profile', function () {
    return 'Profile Settings (dummy)';
})->name('profile.index');
