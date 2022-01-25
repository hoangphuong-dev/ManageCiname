<?php

use App\Http\Controllers\Api\AuthenticationController;
use App\Http\Controllers\Api\ChatController;
use App\Http\Controllers\Api\HospitalController;
use App\Http\Controllers\Api\ContactController;
use App\Http\Controllers\Api\Back\AdminController;
use App\Http\Controllers\Api\Back\NotificationController as BackNotificationController;
use App\Http\Controllers\Api\Caretaker\JobController as CaretakerJobController;
use App\Http\Controllers\Api\JobController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Hospital\JobController as JobHospitalController;
use App\Http\Controllers\Api\MovieController;
use App\Http\Controllers\Api\MovieGenreController;

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

Route::post('/auth/refresh-token', [AuthenticationController::class, 'refreshToken'])->name('auth.refresh-token');

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('hospitals', HospitalController::class);
Route::put('hospitals/{id}/update-status', [HospitalController::class, 'updateStatus']);
Route::put('hospital/update-profile', [HospitalController::class, 'updateProfile']);

Route::apiResource('users', UserController::class);
Route::put('users/{id}/update-status', [UserController::class, 'updateStatus']);
Route::put('user/update-profile', [UserController::class, 'updateProfile']);

Route::apiResource('jobs', JobController::class)->middleware(['api-verify:hospital']);

Route::apiResource('contacts', ContactController::class);
Route::put('contacts/{id}/answer', [ContactController::class, 'answerContact']);

Route::apiResource('notifications', NotificationController::class);
Route::get('list', [NotificationController::class, 'listReceiver']);

Route::post('handle-contact', [ContactController::class, 'handleContact'])->name('handle.contact');


//handle chat
Route::post('/handle-message', [ChatController::class, 'handleMessage'])->name('api.handle.message');

//caretaker
Route::group(['prefix' => 'caretaker', 'middleware' => ['api-verify:caretaker']], function () {
    Route::prefix('/jobs')->group(function () {
        Route::post('/comment/{id}', [CaretakerJobController::class, 'comment']);
    });
});

//common
Route::group(['prefix' => 'common', 'middleware' => ['api-verify:common']], function () {
    Route::prefix('/notification')->group(function () {
        Route::get('/', [NotificationController::class, 'getListForUser']);
        Route::get('/mark-read/{id}', [NotificationController::class, 'markRead']);
    });
});


//Hospital
Route::group(['prefix' => 'hospital', 'middleware' => ['api-verify:hospital']], function () {
    Route::prefix('/jobs')->group(function () {
        Route::get('/get-list-job', [JobHospitalController::class, 'getListJob'])->name('get-list-job');

        Route::get('/get-list-comment/{job_id}', [JobHospitalController::class, 'getListComment'])
            ->name('get-list-comment');
        Route::put('/update-status-comment/{comment_id}', [JobHospitalController::class, 'updateStatusComment'])
            ->name('update-status-comment');

        Route::get('/check-detele-process/{job_id}/{job_process_id}', [JobHospitalController::class, 'checkDeleteProcess'])
            ->name('check-delete-process');
        Route::post('/get-caretaker-apply-job', [JobHospitalController::class, 'getCaretakerApplyJob'])
            ->name('get-caretaker-apply-job');
    });
});


//Admin
Route::group(['prefix' => 'admin', 'middleware' => ['api-verify:admin']], function () {
    Route::post('/upload-image', [AdminController::class, 'uploadImage']);
    Route::prefix('notification')->group(function () {
        Route::get('/list-receiver', [BackNotificationController::class, 'getListReceiver']);
    });
});


Route::apiResource('moviegenres', MovieGenreController::class);
Route::apiResource('movies', MovieController::class);
