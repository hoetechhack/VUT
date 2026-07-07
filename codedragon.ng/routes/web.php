<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\GoogleAuthController;
use App\Http\Controllers\Admin\AdminSettingsController;
use App\Http\Controllers\Admin\AdminOtpController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SecurityController;
use App\Http\Controllers\Auth\OtpController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AdminSupportController;
use App\Http\Controllers\SupportTicketController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\Admin\PricingController;
use App\Http\Controllers\Admin\BroadcastController;
use App\Http\Controllers\AirtimeToCashController;
use App\Http\Controllers\Admin\AdminAirtimeToCashController;
use App\Http\Controllers\MonnifyWebhookController;
use App\Http\Controllers\VTPassWebhookController;
use Illuminate\Support\Facades\Route;

// Public Routes
Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('/about', 'legal.about')->name('about');
Route::view('/privacy-policy', 'legal.privacy')->name('privacy');
Route::view('/terms', 'legal.terms')->name('terms');
Route::view('/refund-policy', 'legal.refund')->name('refund');
Route::view('/contact', 'legal.contact')->name('contact');

// Social Auth
Route::get('/auth/google/redirect', [GoogleAuthController::class, 'redirect'])->name('google.redirect');
Route::get('/auth/google/callback', [GoogleAuthController::class, 'callback'])->name('google.callback');

// OTP Verification (Guest/Auth)
Route::get('/verify-otp', [OtpController::class, 'show'])->name('otp.show');
Route::post('/verify-otp', [OtpController::class, 'verify'])->name('otp.verify');
Route::post('/resend-otp', [OtpController::class, 'resend'])->name('otp.resend');

// 2FA Verification (Guest)
Route::get('/auth/2fa-verify', [SecurityController::class, 'showVerifyForm'])->name('security.2fa.verify');
Route::post('/auth/2fa-verify', [SecurityController::class, 'verifyLogin'])->name('security.2fa.verify.post');

// Authenticated Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // 2FA Setup
    Route::get('/profile/security', [SecurityController::class, 'index'])->name('security.2fa.index');
    Route::post('/profile/security/enable', [SecurityController::class, 'enable'])->name('security.2fa.enable');
    Route::post('/profile/security/disable', [SecurityController::class, 'disable'])->name('security.2fa.disable');

    // Account Actions
    Route::post('/account/profile', [AccountController::class, 'updateProfile'])->name('account.profile.update');
    Route::post('/account/verify-bvn', [AccountController::class, 'verifyBvn'])->name('account.verify-bvn');
    Route::post('/account/withdraw', [AccountController::class, 'withdraw'])->name('account.withdraw');
    Route::post('/account/request-pin-change', [AccountController::class, 'requestPinChange'])->name('account.request-pin-change');
    Route::post('/account/confirm-pin-change', [AccountController::class, 'confirmPinChange'])->name('account.confirm-pin-change');
    Route::post('/account/validate', [AccountController::class, 'validateAccount'])->name('account.validate');
    Route::get('/account/balance', [AccountController::class, 'getBalance'])->name('account.balance');
    Route::get('/account/transactions', [AccountController::class, 'getTransactions'])->name('account.transactions');

    // Support
    Route::get('/support', [SupportTicketController::class, 'index'])->name('support.index');
    Route::post('/support', [SupportTicketController::class, 'store'])->name('support.store');

    // Services
    Route::get('/purchase/variations/{serviceID}', [PurchaseController::class, 'getVariations'])->name('purchase.variations');
    Route::post('/purchase/validate-biller', [PurchaseController::class, 'validateBiller'])->name('purchase.validate-biller');
    Route::post('/purchase/buy', [PurchaseController::class, 'buy'])->name('purchase.buy');
    Route::post('/purchase/subscriptions/{sub}/cancel', [PurchaseController::class, 'cancelSubscription'])->name('purchase.subscriptions.cancel');
    Route::post('/airtime-to-cash', [AirtimeToCashController::class, 'store'])->name('airtime-to-cash.store');

    // Admin Routes
    Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/settings', [AdminSettingsController::class, 'index'])->name('settings');
        Route::post('/settings', [AdminSettingsController::class, 'store'])->name('settings.store');
        Route::post('/settings/fund-vtpass', [AdminSettingsController::class, 'fundVTPass'])->name('settings.fund-vtpass');
        
        Route::get('/airtime-to-cash', [AdminAirtimeToCashController::class, 'index'])->name('atc.index');
        Route::post('/airtime-to-cash/{atc}/update', [AdminAirtimeToCashController::class, 'updateStatus'])->name('atc.update');
        
        Route::get('/pricing', [PricingController::class, 'index'])->name('pricing.index');
        Route::post('/pricing/sync', [PricingController::class, 'syncNow'])->name('pricing.sync');
        Route::post('/pricing/rule', [PricingController::class, 'applyRule'])->name('pricing.rule');
        Route::post('/pricing/manual/{id}', [PricingController::class, 'updateManual'])->name('pricing.manual');

        Route::get('/broadcast', [BroadcastController::class, 'index'])->name('broadcast.index');
        Route::post('/broadcast', [BroadcastController::class, 'send'])->name('broadcast.send');

        Route::resource('users', AdminUserController::class);
        Route::post('/users/{user}/toggle-active', [AdminUserController::class, 'toggleActive'])->name('users.toggle-active');
        Route::post('/users/{user}/verify', [AdminUserController::class, 'verify'])->name('users.verify');
        Route::post('/users/{user}/unverify', [AdminUserController::class, 'unverify'])->name('users.unverify');
        Route::post('/users/{user}/update-password', [AdminUserController::class, 'updatePassword'])->name('users.update-password');
        Route::post('/users/{user}/add-balance', [AdminUserController::class, 'addBalance'])->name('users.add-balance');

        Route::get('/support', [AdminSupportController::class, 'index'])->name('support.index');
        Route::post('/support/{ticket}/reply', [AdminSupportController::class, 'reply'])->name('support.reply');
        Route::post('/support/{ticket}/close', [AdminSupportController::class, 'close'])->name('support.close');
    });
});

require __DIR__.'/auth.php';

// Webhooks (Public POST)
Route::post('/webhook/monnify', [MonnifyWebhookController::class, 'handle'])->name('webhook.monnify');
Route::post('/webhook/vtpass', [VTPassWebhookController::class, 'handle'])->name('webhook.vtpass');

// Utility
Route::get('/clear-cache', function () {
    \Illuminate\Support\Facades\Artisan::call('optimize:clear');
    return 'Cache cleared perfectly! Laravel is now reading your fresh files.';
});