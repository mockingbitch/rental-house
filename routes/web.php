<?php

use App\Constants\UserConstants;
use App\Models\Article;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\StripeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RequestController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\NotificationController;

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

Route::get('/', [HomeController::class, 'index'])->name('top');
Route::get('search', [HomeController::class, 'search'])->name('search');
Route::get('login', [AuthController::class, 'index'])->name('login');
Route::get('login-method', [AuthController::class, 'loginMethod'])->name('login.method');
Route::post('login', [AuthController::class, 'login']);
Route::get('logout', [AuthController::class, 'logout'])->name('logout');
Route::get('register', [AuthController::class, 'registerForm'])->name('register');
Route::get('register-method', [AuthController::class, 'registerMethod'])->name('register.method');
Route::get('register-success', [AuthController::class, 'registerSuccess'])->name('register.success');
Route::post('register', [AuthController::class, 'register']);
Route::get('auth/google', [AuthController::class, 'redirectToGoogle'])->name('login.google');
Route::get('auth/google/callback', [AuthController::class, 'handleGoogleCallback']);

Route::get('forgot-password', [AuthController::class, 'forgotPasswordForm'])->name('forgot.password');
Route::post('forgot-password', [AuthController::class, 'sendForgotMail']);
Route::get('forgot-password-pending', [AuthController::class, 'forgotPasswordPending'])->name('forgot.password-pending');
Route::get('/reset-password-confirm', [AuthController::class, 'resetPasswordForm'])->name('password.reset');
Route::post('/reset-password-confirm', [AuthController::class, 'resetPassword'])->name('reset-password-confirm');
Route::get('/reset-password-success', [AuthController::class, 'resetPasswordSuccess'])->name('reset.password.success');

Route::get('/notification/detail', [NotificationController::class, 'notificationDetail'])->name('notification.detail');

Route::prefix('lesson')->group(function () {
    Route::get('/{id}', [LessonController::class, 'lessonDetail'])->name('lesson.detail');
});

Route::get('/request', [RequestController::class, 'index'])->name('request.index')->middleware('handle.oldurl');
Route::get('/account/delete/success', [TeacherController::class, 'deleteAccountSuccess'])->name('teacher.account.delete.success');

//Onboarding
Route::group(['prefix' => 'onboarding', 'middleware' => ['auth']], function () {
    Route::get('/', [UserController::class, 'onboardingView'])->name('onboarding.index');
    Route::post('/step1', [UserController::class, 'createInforTeacherStep1'])->name('onboarding.create.step1');
    Route::post('/step1-confirm', [UserController::class, 'confirmInforTeacherStep1'])->name('onboarding.confirm.step1');
    Route::post('/step2', [StripeController::class, 'createInforTeacherStep2'])->name('onboarding.create.step2');
    Route::get('/step2-complete', [StripeController::class, 'registerStripeAccountComplete'])->name('onboarding.stripe.complete');
    Route::post('/step2-stripe-dashboard', [StripeController::class, 'gotoTeacherStripeDashboard'])->name('onboarding.stripe.checkdashboard');
    Route::post('/step3', [UserController::class, 'createInforTeacherStep3'])->name('onboarding.create.step3');
    // Route::post('/step3-confirm', [UserController::class, 'confirmInforTeacherStep3'])->name('onboarding.confirm.step3');
});

//Register information for user
Route::prefix('information')->group(function () {
    Route::get('/', [UserController::class, 'information'])->name('user.information');
    Route::post('account-info', [UserController::class, 'createAccountInfo'])->name('account.info');
    Route::post('learner-info', [UserController::class, 'createLearnerInfo'])->name('learner.info');
    Route::post('completed', [UserController::class, 'completed'])->name('completed.info');
    Route::get('success', [UserController::class, 'createInfoSuccess'])->name('success.info');
});
Route::get('/notification', [NotificationController::class, 'notificationUser'])->name('user.notification');

// Parent routes
Route::middleware(['auth', 'author:' . UserConstants::ROLE_PARENT])->group(function () {
    // Routes for registration from parent to teacher
    Route::get('/become-teacher', [UserController::class, 'showFormBecomeTeacher'])->name('show.form.become-teacher');
    Route::get('/teacher-registration', [UserController::class, 'teacherRegistration'])->name('teacher.registration');
    Route::get('/switch-user2teacher', [UserController::class, 'switchBetweenUserAndTeacher'])->name('switch.user.teacher');


    Route::get('/course/{id}', [LessonController::class, 'courseApply'])->name('course.apply');
    Route::post('/course/payment/{id}', [LessonController::class, 'registerNewKid'])->name('course.apply.payment');
    // Route::post('/course/payment/stripe/{id}', [LessonController::class, 'stripePayment'])->name('stripe.payment');

    Route::prefix('/payment')->group(function () {
        Route::post('/initiate', [StripeController::class, 'initiatePayment'])->name('payment.initiate');
        Route::post('/complete', [StripeController::class, 'completePayment'])->name('payment.complete');
        Route::post('/failure', [StripeController::class, 'failPayment'])->name('payment.fail');
    });

    //Request form for parent
    Route::prefix('request')->group(function () {
        Route::get('/create', [RequestController::class, 'viewCreate'])->name('request.create.view');
        Route::post('/create', [RequestController::class, 'create'])->name('request.create');
        Route::get('/{id}', [RequestController::class, 'detail'])->name('request.detail');
        Route::post('/{id}', [RequestController::class, 'edit'])->name('request.edit');
        Route::delete('/delete/{id}', [RequestController::class, 'delete'])->name('request.delete');
    });

    Route::get('/reserved', [CourseController::class, 'getListReserved'])->name('user.reserved');
    Route::post('/reserved/skip', [CourseController::class, 'skipSchedule'])->name('schedule.skip');
    Route::post('/reserved/cancel', [CourseController::class, 'cancelCourse'])->name('course.cancel');
    Route::get('/history', [UserController::class, 'getListHistory'])->name('user.history');
    Route::get('/review-form', [UserController::class, 'getFormReview'])->name('user.review');

    Route::get('/review/{id}', [UserController::class, 'getCourseReview'])->name('course.review');
    Route::get('/review-form/{id}', [UserController::class, 'getFormReview'])->name('user.review.form');
    Route::post('/review-form/{id}', [UserController::class, 'createReview'])->name('user.post.review');
    Route::get('/review-success/{id}', [UserController::class, 'createReviewSuccess'])->name('create.review.success');

    Route::prefix('account')->group(function () {
        Route::get('/', [UserController::class, 'account'])->name('user.account');
        Route::post('/kid-delete', [UserController::class, 'deleteKid'])->name('kid.delete');
        Route::post('/kid-update', [UserController::class, 'updateKid'])->name('kid.update');
        Route::post('/parent-update', [UserController::class, 'updateParent'])->name('parent.update');
        Route::post('/account-delete', [UserController::class, 'deleteAccount'])->name('account.delete');
    });

});

Route::get('/delete-success', [UserController::class, 'deleteSuccess'])->name('delete.account.success');

// Teacher routes
Route::middleware(['auth', 'author:' . UserConstants::ROLE_TEACHER])->group(function () {
    Route::prefix('teacher')->group(function () {
        Route::get('/', [TeacherController::class, 'index'])->name('teacher.dashboard');
        Route::get('/request', [RequestController::class, 'teacherListRequest'])->name('teacher.request.list');
        Route::get('/lesson', [LessonController::class, 'lessonList'])->name('lesson.list');
        Route::get('/{id}/course', [LessonController::class, 'createCourseView'])->name('course.create');
        Route::post('/{id}/course', [LessonController::class, 'createCourse'])->name('post.course.create');
        Route::get('/course/{id}', [LessonController::class, 'editCourseView'])->name('course.edit');
        Route::post('/course/{id}', [LessonController::class, 'editCourse'])->name('post.course.edit');
        Route::post('/course/{id}/delete', [LessonController::class, 'deleteCourse'])->name('post.course.delete');

        Route::get('/schedule', [TeacherController::class, 'getScheduleList'])->name('schedule.list');
        Route::get('/record', [TeacherController::class, 'getListRecord'])->name('record.list');
        Route::get('/review', [TeacherController::class, 'getTotalReview'])->name('total.review');
        Route::get('/review/{id}', [TeacherController::class, 'getScheduleReview'])->name('schedule.review');
        Route::post('/draft', [LessonController::class, 'draftLesson'])->name('draft.lesson');

        Route::get('/account', [TeacherController::class, 'account'])->name('teacher.account');
        Route::get('/notification', [NotificationController::class, 'notificationTeacher'])->name('teacher.notification');
        Route::post('/account/update', [TeacherController::class, 'updateAccount'])->name('teacher.account.update');
        Route::get('/account/delete', [TeacherController::class, 'deleteAccount'])->name('teacher.account.delete');
    });
    Route::get('/switch-teacher2user', [UserController::class, 'switchBetweenUserAndTeacher'])->name('switch.teacher.user');


    // TEACHER
    Route::prefix('create-lesson')->group(function () {
        Route::get('/', [LessonController::class, 'viewCreateLesson'])->name('create.lesson');
        Route::get('/update/{id}', [LessonController::class, 'viewEditLesson'])->name('edit.draft.lesson');
        Route::post('/update/{id}', [LessonController::class, 'editLesson'])->name('update.draft.lesson');
        Route::post('/step1', [LessonController::class, 'createLessonStep1'])->name('create.lesson.step1');
        Route::post('/step2', [LessonController::class, 'createLessonStep2'])->name('create.lesson.step2');
        Route::post('/step3', [LessonController::class, 'createLessonStep3'])->name('create.lesson.step3');
        Route::post('/save-draft', [LessonController::class, 'saveDraft'])->name('save.draft');
        Route::post('/save-draft-error', [LessonController::class, 'saveDraftError'])->name('save.draft.error');
        Route::get('/success', [LessonController::class, 'lessonCreateSuccess'])->name('create.lesson.success');
    });

    Route::prefix('lesson')->group(function () {
        Route::delete('/delete/{id}', [LessonController::class, 'deleteLesson'])->name('delete.lesson');
        Route::post('/suspend/{id}', [LessonController::class, 'suspendLesson'])->name('suspend.lesson');
    });
});
