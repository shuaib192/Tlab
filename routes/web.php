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

    // Course Catalog & Enrollment
    Route::get('/courses',           [\App\Http\Controllers\Parent\CourseController::class, 'index'])->name('courses.index');
    Route::get('/courses/{club}',    [\App\Http\Controllers\Parent\CourseController::class, 'show'])->name('courses.show');
    Route::get('/courses/{course}/enroll', [\App\Http\Controllers\Parent\CourseController::class, 'enrollForm'])->name('courses.enroll');
    Route::post('/courses/{course}/enroll', [\App\Http\Controllers\Parent\CourseController::class, 'enroll'])->name('courses.enroll.submit');

    // Approval routes
    Route::post('/enrollments/{enrollment}/approve', [\App\Http\Controllers\Parent\ApprovalController::class, 'approveEnrollment'])->name('enrollments.approve');
    Route::post('/uploads/{upload}/approve', [\App\Http\Controllers\Parent\ApprovalController::class, 'approveUpload'])->name('uploads.approve');
    Route::post('/uploads/{upload}/reject', [\App\Http\Controllers\Parent\ApprovalController::class, 'rejectUpload'])->name('uploads.reject');
});

// --- Child Dashboard (accessed via parent switch OR child PIN login) ---
Route::prefix('child')->name('child.')->group(function () {
    Route::get('/login',     [\App\Http\Controllers\Child\AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login',    [\App\Http\Controllers\Child\AuthController::class, 'login'])->name('login.submit');
    Route::post('/logout',   [\App\Http\Controllers\Child\AuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [ChildDashboardController::class, 'index'])->name('dashboard')
        ->middleware('child');

    Route::get('/course/{enrollment}',  [\App\Http\Controllers\Child\LearningController::class, 'course'])->name('course');
    Route::get('/lesson/{lesson}',      [\App\Http\Controllers\Child\LearningController::class, 'lesson'])->name('lesson');
    Route::get('/assessment/{assessment}', [\App\Http\Controllers\Child\LearningController::class, 'assessment'])->name('assessment');
    Route::post('/assessment/{assessment}', [\App\Http\Controllers\Child\LearningController::class, 'submitAssessment'])->name('assessment.submit');
    Route::get('/{enrollment}/project/{assignment}', [\App\Http\Controllers\Child\LearningController::class, 'project'])->name('project');
    Route::post('/{enrollment}/project/{assignment}', [\App\Http\Controllers\Child\LearningController::class, 'submitProject'])->name('project.submit');
});

// --- Teacher Portal ---
Route::middleware(['auth', 'teacher'])->prefix('teacher')->name('teacher.')->group(function () {
    Route::get('/dashboard',              [\App\Http\Controllers\Teacher\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/courses/{course}',       [\App\Http\Controllers\Teacher\DashboardController::class, 'course'])->name('course');
    Route::get('/cohorts/{cohort}',       [\App\Http\Controllers\Teacher\DashboardController::class, 'cohort'])->name('cohort');
    Route::get('/sessions/{session}',     [\App\Http\Controllers\Teacher\DashboardController::class, 'session'])->name('session');
    Route::post('/sessions/{session}/attendance', [\App\Http\Controllers\Teacher\DashboardController::class, 'markAttendance'])->name('session.attendance');
    Route::get('/courses/{course}/assignments', [\App\Http\Controllers\Teacher\DashboardController::class, 'assignments'])->name('assignments');
    Route::get('/courses/{course}/assignments/create', [\App\Http\Controllers\Teacher\DashboardController::class, 'createAssignment'])->name('assignments.create');
    Route::post('/courses/{course}/assignments', [\App\Http\Controllers\Teacher\DashboardController::class, 'storeAssignment'])->name('assignments.store');
    Route::get('/assignments/{assignment}/grade', [\App\Http\Controllers\Teacher\DashboardController::class, 'grade'])->name('grade');
    Route::post('/submissions/{submission}/grade', [\App\Http\Controllers\Teacher\DashboardController::class, 'submitGrade'])->name('grade.submit');
    Route::post('/children/{child}/award-xp', [\App\Http\Controllers\Teacher\DashboardController::class, 'awardXp'])->name('award-xp');
    Route::get('/communications', [\App\Http\Controllers\Teacher\DashboardController::class, 'communications'])->name('communications');
    Route::post('/communications/send', [\App\Http\Controllers\Teacher\DashboardController::class, 'sendCommunication'])->name('communications.send');
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

    // Payments
    Route::get('payments',             [\App\Http\Controllers\Admin\PaymentController::class, 'index'])->name('payments.index');
    Route::get('payments/{payment}',   [\App\Http\Controllers\Admin\PaymentController::class, 'show'])->name('payments.show');

    // Safety & Compliance
    Route::prefix('safety')->name('safety.')->group(function () {
        Route::get('/safe-links', [\App\Http\Controllers\Admin\SafetyController::class, 'safeLinks'])->name('safe-links');
        Route::post('/safe-links', [\App\Http\Controllers\Admin\SafetyController::class, 'storeSafeLink'])->name('safe-links.store');
        Route::delete('/safe-links/{safeLink}', [\App\Http\Controllers\Admin\SafetyController::class, 'destroySafeLink'])->name('safe-links.destroy');
        Route::get('/uploads', [\App\Http\Controllers\Admin\SafetyController::class, 'uploads'])->name('uploads');
        Route::post('/uploads/{upload}/approve', [\App\Http\Controllers\Admin\SafetyController::class, 'approveUpload'])->name('uploads.approve');
        Route::post('/uploads/{upload}/reject', [\App\Http\Controllers\Admin\SafetyController::class, 'rejectUpload'])->name('uploads.reject');
        Route::get('/communications', [\App\Http\Controllers\Admin\SafetyController::class, 'communications'])->name('communications');
    });

    // Compliance
    Route::get('/compliance', [\App\Http\Controllers\Admin\ComplianceController::class, 'index'])->name('compliance.index');

    // Feature Flags
    Route::get('/feature-flags', [\App\Http\Controllers\Admin\FeatureFlagController::class, 'index'])->name('feature-flags.index');
    Route::post('/feature-flags', [\App\Http\Controllers\Admin\FeatureFlagController::class, 'store'])->name('feature-flags.store');
    Route::post('/feature-flags/{flag}/toggle', [\App\Http\Controllers\Admin\FeatureFlagController::class, 'toggle'])->name('feature-flags.toggle');
    Route::put('/feature-flags/{flag}', [\App\Http\Controllers\Admin\FeatureFlagController::class, 'update'])->name('feature-flags.update');

    // Invoices
    Route::get('/invoices', [\App\Http\Controllers\Admin\InvoiceController::class, 'index'])->name('invoices.index');
    Route::get('/invoices/create', [\App\Http\Controllers\Admin\InvoiceController::class, 'create'])->name('invoices.create');
    Route::post('/invoices', [\App\Http\Controllers\Admin\InvoiceController::class, 'store'])->name('invoices.store');
    Route::get('/invoices/{invoice}/download', [\App\Http\Controllers\Admin\InvoiceController::class, 'downloadPdf'])->name('invoices.download');

    // Schools
    Route::get('/schools', [\App\Http\Controllers\Admin\SchoolController::class, 'index'])->name('schools.index');
    Route::get('/schools/create', [\App\Http\Controllers\Admin\SchoolController::class, 'create'])->name('schools.create');
    Route::post('/schools', [\App\Http\Controllers\Admin\SchoolController::class, 'store'])->name('schools.store');
    Route::get('/schools/{school}', [\App\Http\Controllers\Admin\SchoolController::class, 'show'])->name('schools.show');
    Route::post('/schools/{school}/licenses', [\App\Http\Controllers\Admin\SchoolController::class, 'createLicense'])->name('schools.licenses.store');
});

// --- Pricing ---
Route::get('/pricing', [\App\Http\Controllers\PaymentController::class, 'pricing'])->name('pricing');

// --- Payments ---
Route::middleware('auth')->group(function () {
    Route::post('/payment/checkout',             [\App\Http\Controllers\PaymentController::class, 'checkout'])->name('payment.checkout');
    Route::get('/payment/callback',             [\App\Http\Controllers\PaymentController::class, 'callback'])->name('payment.callback');
});
Route::post('/payment/webhook',                 [\App\Http\Controllers\PaymentController::class, 'webhook'])->name('payment.webhook')->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);

// --- Parent Payment & Subscription ---
Route::middleware(['auth', 'parent'])->prefix('parent')->name('parent.')->group(function () {
    Route::get('/subscription',  [\App\Http\Controllers\PaymentController::class, 'subscription'])->name('subscription');
    Route::get('/payments',      [\App\Http\Controllers\PaymentController::class, 'history'])->name('payments.history');

    // Certificates
    Route::get('/children/{child}/certificates', [\App\Http\Controllers\CertificateController::class, 'index'])->name('certificates.index');
    Route::post('/children/{child}/certificates/generate', [\App\Http\Controllers\CertificateController::class, 'generate'])->name('certificates.generate');
});

// --- Certificate Download & Verification ---
Route::get('/certificates/{certificate}/download', [\App\Http\Controllers\CertificateController::class, 'download'])->name('certificate.download')->middleware('auth');
Route::get('/certificates/verify/{certificateId}',  [\App\Http\Controllers\CertificateController::class, 'verify'])->name('certificate.verify');

// --- Communications (shared between parents & teachers) ---
Route::middleware('auth')->prefix('communications')->name('communications.')->group(function () {
    Route::get('/', [\App\Http\Controllers\CommunicationController::class, 'index'])->name('index');
    Route::post('/{log}/read', [\App\Http\Controllers\CommunicationController::class, 'markRead'])->name('read');
});

// --- Notifications ---
Route::middleware('auth')->prefix('notifications')->name('notifications.')->group(function () {
    Route::get('/',                           [\App\Http\Controllers\NotificationController::class, 'index'])->name('index');
    Route::post('/{notification}/read',       [\App\Http\Controllers\NotificationController::class, 'markRead'])->name('read');
    Route::post('/read-all',                  [\App\Http\Controllers\NotificationController::class, 'markAllRead'])->name('read-all');
    Route::get('/unread-count',               [\App\Http\Controllers\NotificationController::class, 'unreadCount'])->name('unread-count');
});

// --- Child Achievements ---
Route::middleware('auth')->prefix('child')->name('child.')->group(function () {
    Route::get('/{child}/achievements', [\App\Http\Controllers\AchievementController::class, 'index'])->name('achievements');
});
