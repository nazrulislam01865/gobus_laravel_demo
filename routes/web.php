<?php

use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminBusCompanyController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AdminPromotionController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])
    ->name('home');

Route::get('/promotions/live', [HomeController::class, 'livePromotions'])
    ->name('promotions.live');

Route::get('/admin/signup', [AdminAuthController::class, 'showSignup'])
    ->name('admin.signup');

Route::post('/admin/signup', [AdminAuthController::class, 'signup'])
    ->name('admin.signup.submit');

Route::get('/admin/login', [AdminAuthController::class, 'showLogin'])
    ->name('admin.login');

Route::post('/admin/login', [AdminAuthController::class, 'login'])
    ->name('admin.login.submit');

Route::post('/admin/logout', [AdminAuthController::class, 'logout'])
    ->name('admin.logout');

Route::middleware('auth:admin')->group(function () {
    Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])
        ->name('admin.dashboard');

    Route::post('/admin/promotions', [AdminPromotionController::class, 'store'])
        ->name('admin.promotions.store');

    Route::delete('/admin/promotions/{promotion}', [AdminPromotionController::class, 'destroy'])
        ->name('admin.promotions.destroy');

    Route::post('/admin/bus-companies', [AdminBusCompanyController::class, 'store'])
        ->name('admin.bus-companies.store');

    Route::delete('/admin/bus-companies/{busCompany}', [AdminBusCompanyController::class, 'destroy'])
        ->name('admin.bus-companies.destroy');
});

Route::redirect('/login', '/admin/login')
    ->name('login');

Route::redirect('/signup', '/admin/signup');
