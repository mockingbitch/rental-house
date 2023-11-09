<?php

use Illuminate\Support\Facades\Route;
use App\Constants\PermissionConstant;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LessorController;

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

//Authentication
Route::controller(AuthController::class)->group(function () {
    Route::get('login-method', 'loginMethod')->name('login.method');
    Route::get('login', 'loginView')->name('login');
    Route::post('login', 'login');
    Route::get('logout', 'logout')->name('logout');
    Route::get('register-method', 'registerMethod')->name('register.method');
    Route::get('register', 'registerView')->name('register');
    Route::post('register', 'register');
    Route::get('register-success', 'registerSuccess')->name('register.success');

    Route::get('auth/google', 'redirectToGoogle')->name('login.google');
    Route::get('auth/google/callback', 'handleGoogleCallback');

    Route::get('forgot-password', 'forgotPasswordForm')->name('forgot.password');
    Route::post('forgot-password', 'sendForgotMail');
    Route::get('forgot-password-pending', 'forgotPasswordPending')->name('forgot.password-pending');
    Route::get('reset-password-confirm', 'resetPasswordForm')->name('password.reset');
    Route::post('reset-password-confirm', 'resetPassword')->name('reset-password-confirm');
    Route::get('reset-password-success', 'resetPasswordSuccess')->name('reset.password.success');
});

Route::get('/notification/detail', [NotificationController::class, 'notificationDetail'])->name('notification.detail');
Route::post('/url-intended', [AuthController::class, 'urlIntended'])->name('url.intended.create');

Route::controller(UserController::class)->group(function () {
    Route::get('user-information', 'userInformation')->name('user.information');
    Route::post('user-information', 'updateUserInformation')->name('account.info');
    Route::get('setup-successfully', 'setupUserSuccessfully')->name('user.setup.success');
});

//ADMIN
Route::controller(CategoryController::class)->group(function () {
    Route::get('category', 'get')->name('category.get');
    Route::get('detail/{id}/category', 'detail')->name('category.detail');
    Route::post('category', 'create')->middleware('permission:'. PermissionConstant::PERMISSIONS['create_category'])->name('category.create');
    Route::post('edit/{id}/category', 'update')->middleware('permission:'. PermissionConstant::PERMISSIONS['update_category'])->name('category.update');
    Route::get('delete/category', 'delete')->middleware('permission:'. PermissionConstant::PERMISSIONS['delete_category'])->name('category.delete');
});
Route::controller(TagController::class)->group(function () {
    Route::get('tag', 'get')->name('tag.get');
    Route::get('detail/{id}/tag', 'detail')->name('tag.detail');
    Route::post('tag', 'create')->middleware('permission:'. PermissionConstant::PERMISSIONS['create_tag'])->name('tag.create');
    Route::post('edit/{id}/tag', 'update')->middleware('permission:'. PermissionConstant::PERMISSIONS['update_tag'])->name('tag.update');
    Route::get('delete/tag', 'delete')->middleware('permission:'. PermissionConstant::PERMISSIONS['delete_tag'])->name('tag.delete');
});

//LESSOR
Route::controller(LessorController::class)->group(function () {
    Route::prefix('lessor')->group(function () {
        Route::get('register', 'register')->name('lessor.register');
        Route::post('register/step1', 'registerStep1')->name('lessor.register.step1');
    });
});
