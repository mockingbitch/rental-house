<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\HouseController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\TagController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::prefix('v1')->group(function () {
    Route::get('notification', [NotificationController::class, 'getNotification'])->name('api.get.notification');

    Route::controller(AddressController::class)->group(function () {
        Route::prefix('address')->group(function () {
            Route::get('list', 'list')->name('address.list');
            Route::get('house/{id}/delete', 'delete')->name('lessor.house.delete');
        });
    });

    Route::controller(TagController::class)->group(function () {
        Route::prefix('tag')->group(function () {
            Route::get('list', 'apiList')->name('tag.list');
            // Route::get('house/{id}/delete', 'delete')->name('lessor.house.delete');
        });
    });

    Route::controller(HouseController::class)->group(function () {
        Route::prefix('house')->group(function () {
            Route::get('house/detail', 'detail')->name('lessor.house.detail');
            Route::post('house/update', 'update')->name('lessor.house.update');
            Route::post('status', 'updateStatus')->name('house.update.status');
        });
    });

    Route::controller(RoomController::class)->group(function () {
        Route::prefix('room')->group(function () {
            Route::get('room/detail', 'detail')->name('lessor.room.detail');
            Route::post('room/update', 'update')->name('lessor.room.update');
            Route::post('status', 'updateStatus')->name('room.update.status');
        });
    });
});
