<?php

use App\Http\Controllers\Admin\CompanyProfileController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\PaketController;
use App\Http\Controllers\Admin\PesananController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Chatbot\ChatbotController;
use App\Http\Controllers\Customer\PageController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Customer Routes (Customer Side)
|--------------------------------------------------------------------------
*/

Route::get('/', [PageController::class, 'index'])->name('home');
Route::get('/packages', [PageController::class, 'packages'])->name('packages');
Route::get('/packages/search', [PageController::class, 'search'])->name('packages.search');
Route::get('/package/{id}', [PageController::class, 'packageDetail'])->name('package.detail');
Route::get('/photos', [PageController::class, 'photos'])->name('photos');

Route::prefix('api/public-chatbot')->name('public-chatbot.')->group(function () {
    Route::get('/menu', [ChatbotController::class, 'getPublicMenu'])->name('menu');
    Route::post('/message', [ChatbotController::class, 'handlePublicMessage'])->name('message');
});

// Auth
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Password Reset
Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');
Route::post('/forgot-password', [AuthController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/reset-password/{token}', [AuthController::class, 'showResetPasswordForm'])->name('password.reset');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::resource('paket', PaketController::class);
    Route::resource('gallery', GalleryController::class);
    Route::resource('pesanan', PesananController::class);
    Route::get('pesanan/create/custom', [PesananController::class, 'createCustom'])->name('pesanan.create-custom');
    Route::post('pesanan/store/custom', [PesananController::class, 'storeCustom'])->name('pesanan.store-custom');

    Route::get('company-profile', [CompanyProfileController::class, 'show'])->name('company-profile.show');
    Route::get('company-profile/edit', [CompanyProfileController::class, 'edit'])->name('company-profile.edit');
    Route::put('company-profile', [CompanyProfileController::class, 'update'])->name('company-profile.update');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // AJAX endpoint for gallery dependent dropdown
    Route::get('/api/gallery/relations', [GalleryController::class, 'getRelationsByPaket'])->name('gallery.relations');
});
