<?php

use Illuminate\Support\Facades\Route;
use App\Constants\PermissionConstant;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/setlang/{locale}', function ($locale) {
    Session::put('locale', $locale);
    return back();
})->name('setlang');
Route::controller(HomeController::class)->group(function() {
    Route::get('/', 'index')->name('top');
    // Route::get('/admin', 'adminDashboard')->name('admin.dashboard')->middleware('permission:view_admin');
    Route::get('/admin', 'adminDashboard')->name('admin.dashboard');
});
Route::get('login-method', [AuthController::class, 'loginMethod'])->name('login.method');
Route::get('login', [AuthController::class, 'loginView'])->name('login');
Route::post('login', [AuthController::class, 'login']);
Route::get('logout', [AuthController::class, 'logout'])->name('logout');
Route::get('register-method', [AuthController::class, 'registerMethod'])->name('register.method');
Route::get('register', [AuthController::class, 'registerView'])->name('register');
Route::post('register', [AuthController::class, 'register']);
Route::get('register-success', [AuthController::class, 'registerSuccess'])->name('register.success');

Route::get('auth/google', [AuthController::class, 'redirectToGoogle'])->name('login.google');
Route::get('auth/google/callback', [AuthController::class, 'handleGoogleCallback']);

Route::get('forgot-password', [AuthController::class, 'forgotPasswordForm'])->name('forgot.password');
Route::post('forgot-password', [AuthController::class, 'sendForgotMail']);
Route::get('forgot-password-pending', [AuthController::class, 'forgotPasswordPending'])->name('forgot.password-pending');
Route::get('reset-password-confirm', [AuthController::class, 'resetPasswordForm'])->name('password.reset');
Route::post('reset-password-confirm', [AuthController::class, 'resetPassword'])->name('reset-password-confirm');
Route::get('reset-password-success', [AuthController::class, 'resetPasswordSuccess'])->name('reset.password.success');

Route::get('/notification/detail', [NotificationController::class, 'notificationDetail'])->name('notification.detail');
Route::post('/url-intended', [AuthController::class, 'urlIntended'])->name('url.intended.create');

//ADMIN
Route::controller(CategoryController::class)->group(function () {
    Route::get('category', 'get');
    Route::post('category', 'create')->middleware('permission:' . PermissionConstant::PERMISSIONS['create_category']);
    Route::post('edit/category', 'update')->middleware('permission:'. PermissionConstant::PERMISSIONS['update_category']);
    Route::get('delete/category', 'delete')->middleware('permission:'. PermissionConstant::PERMISSIONS['delete_category']);
});