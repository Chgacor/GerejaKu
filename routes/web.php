<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JemaatController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DevotionalController as AdminDevotionalController;
use App\Http\Controllers\DevotionalController;
use App\Http\Controllers\Admin\SettingController;


Route::get('/', function() {
    return view('home');
})->name('home');

Route::middleware('guest')->group(function () {
    Route::get('register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('register', [AuthController::class, 'register'])->name('register.post');
    Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('login', [AuthController::class, 'login'])->name('login.post');
});

Route::middleware('auth')->group(function () {
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
});

Route::middleware(['auth', 'isAdmin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('jemaat', JemaatController::class);
    Route::get('/jemaat-cards', [JemaatController::class, 'cardView'])->name('jemaat.cards');
    Route::resource('devotionals', AdminDevotionalController::class);
    Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
    Route::post('settings', [SettingController::class, 'update'])->name('settings.update');
});

Route::middleware('auth')->group(function () {
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

Route::middleware('guest')->group(function () {
    Route::get('register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('register', [AuthController::class, 'register'])->name('register.post');

    Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('login', [AuthController::class, 'login'])->name('login.post');
});

Route::get('/devosi', [DevotionalController::class, 'index'])->name('devotionals.index');
Route::get('/devosi/{devotional}', [DevotionalController::class, 'show'])->name('devotionals.show');

Route::get('/tentang-kami', [HomeController::class, 'about'])->name('about');
