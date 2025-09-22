<?php

use Illuminate\Support\Facades\Route;

// --- PUBLIC CONTROLLERS ---
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DevotionalController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\PastorController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\EventController;

// --- ADMIN CONTROLLERS ---
use App\Http\Controllers\Admin\JemaatController as AdminJemaatController;
use App\Http\Controllers\Admin\SettingController as AdminSettingController;
use App\Http\Controllers\Admin\DevotionalController as AdminDevotionalController;
use App\Http\Controllers\Admin\SlideController as AdminSlideController;
use App\Http\Controllers\Admin\ServiceController as AdminServiceController;
use App\Http\Controllers\Admin\DepartmentController as AdminDepartmentController;
use App\Http\Controllers\Admin\PastorController as AdminPastorController;
use App\Http\Controllers\Admin\EventController as AdminEventController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Di sini kita mengatur semua rute. Kita kelompokkan berdasarkan fungsinya:
| 1. Rute Publik (bisa diakses siapa saja)
| 2. Rute Autentikasi (login, register, logout, profil)
| 3. Rute Admin (hanya untuk admin, diawali dengan /admin)
|
*/


//=====================================
// 1. RUTE PUBLIK
//=====================================
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/tentang-kami', [HomeController::class, 'about'])->name('about');
Route::get('/tentang-kami/hamba-tuhan', [HomeController::class, 'pastors'])->name('pastors.index');

Route::get('/devosi', [DevotionalController::class, 'index'])->name('devotionals.index');
Route::get('/devosi/{devotional}', [DevotionalController::class, 'show'])->name('devotionals.show');

Route::get('/departemen', [DepartmentController::class, 'index'])->name('departments.index');
Route::get('/departemen/{department}', [DepartmentController::class, 'show'])->name('departments.show');

Route::get('/ibadah/{service}', [ServiceController::class, 'show'])->name('services.show');
Route::get('/tentang-kami/hamba-tuhan', [HomeController::class, 'pastors'])->name('pastors.index');

Route::get('/jadwal-acara', [EventController::class, 'index'])->name('events.index');
Route::get('/api/events', [EventController::class, 'json'])->name('events.json');

//=====================================
// 2. RUTE AUTENTIKASI
//=====================================

// Rute ini HANYA untuk tamu (yang belum login)
Route::middleware('guest')->group(function () {
    Route::get('register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('register', [AuthController::class, 'register'])->name('register.post');
    Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('login', [AuthController::class, 'login'])->name('login.post');
});

// Rute ini HANYA untuk pengguna yang SUDAH login
Route::middleware('auth')->group(function () {
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
});


//=====================================
// 3. RUTE KHUSUS ADMIN
//=====================================

Route::middleware(['auth', 'isAdmin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminJemaatController::class, 'index'])->name('dashboard'); // Rute default admin

    Route::resource('jemaat', AdminJemaatController::class);
    Route::get('/jemaat-cards', [AdminJemaatController::class, 'cardView'])->name('jemaat.cards');

    Route::resource('devotionals', AdminDevotionalController::class);

    Route::get('settings', [AdminSettingController::class, 'index'])->name('settings.index');
    Route::post('settings', [AdminSettingController::class, 'update'])->name('settings.update');

    Route::resource('slides', AdminSlideController::class);
    Route::patch('slides/{slide}/toggle', [AdminSlideController::class, 'toggleStatus'])->name('slides.toggle');

    Route::resource('services', AdminServiceController::class);
    Route::resource('departments', AdminDepartmentController::class);
    Route::resource('pastors', AdminPastorController::class);
    Route::resource('events', AdminEventController::class);
});
