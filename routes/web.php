<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Parent\DashboardController;
use App\Http\Controllers\Parent\ChildProfileController;
use App\Http\Controllers\Child\DashboardController as ChildDashboardController;

use App\Http\Controllers\PageController;

// --- Public Landing Page ---
Route::get('/', [PageController::class, 'home'])->name('home');

// --- Public Pages ---
Route::get('/about',              [PageController::class, 'about'])->name('about');
Route::get('/clubs',              [PageController::class, 'clubs'])->name('clubs');
Route::get('/clubs/{slug}',       [PageController::class, 'clubDetail'])->name('club.detail');
Route::get('/membership',         [PageController::class, 'membership'])->name('membership');
Route::get('/contact',            [PageController::class, 'contact'])->name('contact');
Route::post('/contact',           [PageController::class, 'contactSubmit'])->name('contact.submit');


// --- Edfrica OAuth SSO ---
Route::get('/auth/edfrica',          [\App\Http\Controllers\Auth\EdfricaOAuthController::class, 'redirect'])->name('auth.edfrica');
Route::get('/auth/edfrica/callback', [\App\Http\Controllers\Auth\EdfricaOAuthController::class, 'callback'])->name('auth.edfrica.callback');

// --- Auth Routes (Guests Only) ---
Route::middleware('guest')->group(function () {
    Route::get('/login',          [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login',         [LoginController::class, 'login']);
    Route::get('/signup',       [RegisterController::class, 'showRegisterForm'])->name('register');
    Route::post('/signup',      [RegisterController::class, 'register']);
    Route::get('/forgot-password',[PasswordController::class, 'showForgotForm'])->name('password.request');
    Route::post('/forgot-password',[PasswordController::class, 'sendResetCode'])->name('password.email');
    Route::get('/reset-password', [PasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password',[PasswordController::class, 'reset'])->name('password.update');
});

// --- Logout ---
Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

// --- Parent Portal ---
Route::middleware(['auth', 'parent'])->prefix('parent')->name('parent.')->group(function () {
    Route::get('/dashboard',          [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/children',           [ChildProfileController::class, 'index'])->name('children.index');
    Route::get('/children/add',       [ChildProfileController::class, 'create'])->name('children.create');
    Route::post('/children',          [ChildProfileController::class, 'store'])->name('children.store');
    Route::get('/children/{child}',   [ChildProfileController::class, 'show'])->name('children.show');
    Route::get('/children/{child}/edit',[ChildProfileController::class, 'edit'])->name('children.edit');
    Route::put('/children/{child}',   [ChildProfileController::class, 'update'])->name('children.update');
    Route::delete('/children/{child}',[ChildProfileController::class, 'destroy'])->name('children.destroy');
    Route::get('/switch/{child}',     [ChildProfileController::class, 'switchChild'])->name('children.switch');
});

// --- Child Dashboard (accessed via parent session after switch) ---
Route::middleware(['auth', 'parent'])->prefix('child')->name('child.')->group(function () {
    Route::get('/dashboard', [ChildDashboardController::class, 'index'])->name('dashboard');
});

// --- Child PIN Login (standalone child access) ---
Route::prefix('child')->name('child.')->group(function () {
    Route::get('/login',  [\App\Http\Controllers\Child\AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [\App\Http\Controllers\Child\AuthController::class, 'login'])->name('login.submit');
    Route::post('/logout', [\App\Http\Controllers\Child\AuthController::class, 'logout'])->name('logout');
});

// --- Admin Panel ---
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/',                                      [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');

    // Clubs
    Route::resource('clubs',        \App\Http\Controllers\Admin\ClubController::class);

    // Courses
    Route::resource('courses',      \App\Http\Controllers\Admin\CourseController::class);

    // Users
    Route::get('users',             [\App\Http\Controllers\Admin\UserController::class, 'index'])->name('users.index');
    Route::get('users/{user}',      [\App\Http\Controllers\Admin\UserController::class, 'show'])->name('users.show');
    Route::get('users/{user}/edit', [\App\Http\Controllers\Admin\UserController::class, 'edit'])->name('users.edit');
    Route::put('users/{user}',      [\App\Http\Controllers\Admin\UserController::class, 'update'])->name('users.update');
    Route::delete('users/{user}',   [\App\Http\Controllers\Admin\UserController::class, 'destroy'])->name('users.destroy');

    // Children
    Route::get('children',                       [\App\Http\Controllers\Admin\ChildController::class, 'index'])->name('children.index');
    Route::get('children/{child}',               [\App\Http\Controllers\Admin\ChildController::class, 'show'])->name('children.show');
    Route::post('children/{child}/award-xp',     [\App\Http\Controllers\Admin\ChildController::class, 'awardXp'])->name('children.award-xp');
    Route::delete('children/{child}',            [\App\Http\Controllers\Admin\ChildController::class, 'destroy'])->name('children.destroy');

    // Enrollments
    Route::get('enrollments',          [\App\Http\Controllers\Admin\EnrollmentController::class, 'index'])->name('enrollments.index');
    Route::get('enrollments/create',   [\App\Http\Controllers\Admin\EnrollmentController::class, 'create'])->name('enrollments.create');
    Route::post('enrollments',         [\App\Http\Controllers\Admin\EnrollmentController::class, 'store'])->name('enrollments.store');
    Route::put('enrollments/{enrollment}',   [\App\Http\Controllers\Admin\EnrollmentController::class, 'update'])->name('enrollments.update');
    Route::delete('enrollments/{enrollment}',[\App\Http\Controllers\Admin\EnrollmentController::class, 'destroy'])->name('enrollments.destroy');

    // Settings
    Route::get('settings',            [\App\Http\Controllers\Admin\SettingController::class, 'index'])->name('settings.index');
    Route::post('settings',           [\App\Http\Controllers\Admin\SettingController::class, 'update'])->name('settings.update');
    Route::get('settings/create',     [\App\Http\Controllers\Admin\SettingController::class, 'create'])->name('settings.create');
    Route::post('settings/new',       [\App\Http\Controllers\Admin\SettingController::class, 'store'])->name('settings.store');
    Route::delete('settings/{setting}',[\App\Http\Controllers\Admin\SettingController::class, 'destroy'])->name('settings.destroy');

    // Homepage Carousel
    Route::get('carousel',                        [\App\Http\Controllers\Admin\CarouselSlideController::class, 'index'])->name('carousel.index');
    Route::get('carousel/create',                 [\App\Http\Controllers\Admin\CarouselSlideController::class, 'create'])->name('carousel.create');
    Route::post('carousel',                       [\App\Http\Controllers\Admin\CarouselSlideController::class, 'store'])->name('carousel.store');
    Route::get('carousel/{carousel}/edit',        [\App\Http\Controllers\Admin\CarouselSlideController::class, 'edit'])->name('carousel.edit');
    Route::put('carousel/{carousel}',             [\App\Http\Controllers\Admin\CarouselSlideController::class, 'update'])->name('carousel.update');
    Route::delete('carousel/{carousel}',          [\App\Http\Controllers\Admin\CarouselSlideController::class, 'destroy'])->name('carousel.destroy');
    Route::patch('carousel/{carousel}/toggle',    [\App\Http\Controllers\Admin\CarouselSlideController::class, 'toggleActive'])->name('carousel.toggle');
});
