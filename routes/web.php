<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\frontend\HomeController;
use App\Http\Controllers\frontend\ServiceController;
use App\Http\Controllers\frontend\UserController;
use App\Http\Controllers\frontend\NewsController;
use App\Http\Controllers\frontend\AboutController;
use App\Http\Controllers\frontend\CheckoutController;
use App\Http\Controllers\backend\AuthController;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\frontend\DriverRegistrationController;
use App\Http\Controllers\frontend\LicenseRenewalController;
use App\Http\Controllers\frontend\BookingController;
use App\Http\Controllers\frontend\RegisterController;
use App\Http\Controllers\frontend\LicenseController;
use App\Http\Controllers\backend\BakongController;

// Route::get('/', function () {
//     return view('frontend.layout.master'); // ✅ load the child view, not the master
// });

Route::get('/run-migrate', function () {
    Artisan::call('migrate', ['--force' => true]);
    return '✅ Migration done';
});

Route::controller(HomeController::class)->group(function(){
    Route::get('/','index')->name('home');
});

Route::controller(ServiceController::class)->group(function(){
    Route::get('/service','index')->name('service');
    // Route::get('/service/register-New-License','register')->name('register-new-license');
    Route::get('/service/renew','renew')->name('renew');
    Route::get('/service/booktest','booktest')->name('booktest');
    Route::get('/service/checkstatus', [ServiceController::class, 'checkStatusView'])
    ->name('checkstatus');
    Route::get('/service/checkstatus/download-duc','downloadDucument')->name('downloadDucument');
});


Route::controller(UserController::class)->group(function(){
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    // Route::get('/login/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::get('/profile','profile')->name('profile');
});
Route::get('/verify-email/{token}', [RegisterController::class, 'verifyEmail'])
    ->name('verify.email');


Route::controller(NewsController::class)->group(function(){
    Route::get('/news', 'index')->name('news');
});

Route::controller(AboutController::class)->group(function(){
    Route::get('/about', 'index')->name('about');
});


Route::middleware('auth')->group(function () {
    Route::get('/checkout', [BookingController::class, 'checkout'])->name('booking.checkout'); // ?permit_number=...
    Route::post('/checkout/pay', [BookingController::class, 'payKhqr'])->name('booking.payKhqr');
});
Route::get('/lang/{locale}', [\App\Http\Controllers\LanguageController::class, 'switch'])->name('lang.switch');

// backend
// auth'
Route::middleware(['auth'])->group(function () {
    Route::get('/license', [LicenseController::class, 'index'])->name('license.show');
});
Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [RegisterController::class, 'store'])->name('register.submit');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/profile', [UserController::class, 'profile'])
    ->name('profile')
    ->middleware('auth');
Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();

    return redirect()->route('home');
})->name('logout');
// services

Route::get('/renewal/success/{permit_number}', [LicenseRenewalController::class, 'success'])
    ->name('renewal.success');
Route::post('/service/checkstatus', [ServiceController::class, 'checkStatus'])
    ->name('application.status.search');

Route::get('/bakong/qr', [BakongController::class, 'generateQR']);
Route::get('/bakong/check', [BakongController::class, 'checkTransaction']);

Route::get('/service/register-new-license', [DriverRegistrationController::class, 'showRegisterForm'])
    ->name('register-new-license');

Route::post('/service/register-new-license', [DriverRegistrationController::class, 'store'])
    ->name('register.license');
Route::post('/license-renewal', [LicenseRenewalController::class, 'store'])->name('license.renewal');
Route::post('/book-test', [BookingController::class, 'store'])->name('book.test');

Route::post('/booking/check-payment-ajax', [BookingController::class, 'checkPaymentAjax'])->name('booking.checkPaymentAjax');
Route::post('/booking/check-payment', [BookingController::class, 'checkPayment'])->name('booking.checkPayment');
Route::post('/checkout/pay', [BookingController::class, 'payKhqr'])->name('booking.payKhqr');
Route::get('/booking/success/{permit_number}', [BookingController::class, 'successView'])->name('booking.success');
Route::get('/booking/history', [App\Http\Controllers\frontend\BookingController::class, 'history'])
    ->name('booking.history');
    
Route::get('/renewal/checkout/{renewal_id}', [LicenseRenewalController::class, 'renewalCheckout'])->name('renewal.checkout');
Route::post('/renewal/pay', [LicenseRenewalController::class, 'payKhqrForRenewal'])->name('renewal.payKhqr');
Route::post('/checkout/pay', [BookingController::class, 'payKhqr'])->name('booking.payKhqr');
Route::post('/renewal/pay', [BookingController::class, 'payKhqr'])->name('renewal.payKhqr');
Route::get('/booking/history/{id}', [BookingController::class, 'historyDetail'])
    ->name('booking.history.detail');