<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GamingCardController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ShareController;
use Illuminate\Support\Facades\Route;

// Language switch
Route::get('/lang/{locale}', [LanguageController::class, 'switch'])->name('lang.switch');

// Landing page
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Public shared card
Route::get('/card/{slug}', [ShareController::class, 'show'])->name('card.share');

// Guest routes
Route::middleware('guest')->group(function (): void {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

// Authenticated routes
Route::middleware('auth')->group(function (): void {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');

    // Gaming Cards
    Route::get('/cards/create', [GamingCardController::class, 'create'])->name('cards.create');
    Route::post('/cards', [GamingCardController::class, 'store'])->name('cards.store');
    Route::post('/cards/preview', [GamingCardController::class, 'preview'])->name('cards.preview');
    Route::get('/cards/{card}', [GamingCardController::class, 'show'])->name('cards.show');
    Route::get('/cards/{card}/edit', [GamingCardController::class, 'edit'])->name('cards.edit');
    Route::put('/cards/{card}', [GamingCardController::class, 'update'])->name('cards.update');
    Route::delete('/cards/{card}', [GamingCardController::class, 'destroy'])->name('cards.destroy');
    Route::patch('/cards/{card}/visibility', [GamingCardController::class, 'toggleVisibility'])->name('cards.visibility');
});
