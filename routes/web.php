<?php

use App\Http\Controllers\Caretaker\ContactController as CaretakerContactController;
use App\Http\Controllers\Caretaker\CVController;
use App\Http\Controllers\Caretaker\JobController as CaretakerJobController;
use App\Http\Controllers\Auth\AuthenticationController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Middleware\IgnoreLoginMiddleware;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\Caretaker\ChatController;
use App\Http\Controllers\Caretaker\FavoriteController;
use App\Http\Controllers\Customer\CustomerController;
use App\Http\Controllers\Hospital\ContactController;
use App\Http\Controllers\Hospital\HospitalController;
use App\Http\Controllers\Hospital\JobController;
use App\Http\Middleware\CustomerMiddleware;

// Customer
Route::get('/', [CustomerController::class, 'index'])->name('home');

// Route::group(['middleware' => ['guest']], function () {
//     Route::get('/login', [AuthenticationController::class, 'showLoginForm'])->name('show_login')->middleware(CustomerMiddleware::class);
//     Route::post('/login', [AuthenticationController::class, 'handleLogin'])->name('login');

//     Route::get('/change-password', [AuthenticationController::class, 'showChangePassword'])->name('change-password.get');
//     Route::post('/change-password', [AuthenticationController::class, 'changePassword'])->name('change-password.post');

//     Route::get('/forgot-password', [AuthenticationController::class, 'showForgotPassword'])->name('forgot-password.get');
//     Route::post('/forgot-password', [AuthenticationController::class, 'forgotPassword'])->name('forgot-password.post');

//     Route::get('/reset-password', [AuthenticationController::class, 'showResetPassword'])->name('reset-password.get');
//     Route::post('/reset-password', [AuthenticationController::class, 'resetPassword'])->name('reset-password.post');
// });

// Route::group(['prefix' => 'caretaker', 'as' => 'caretaker.', 'middleware' => ['caretaker']], function () {
//     Route::get('/chat', [ChatController::class, 'index'])->name('chat');
//     Route::get('/contact', [CaretakerContactController::class, 'index'])->name('contact');
//     Route::get('/profile', [CVController::class, 'index'])->name('profile');

//     Route::get('/step-job-detail', [CaretakerJobController::class, 'stepJobDetail'])
//         ->name('step_job_detail');
//     Route::get('/list-step-job-detail', [CaretakerJobController::class, 'listStepJobDetail'])
//         ->name('list_step_job_detail');
//     Route::get('/logout', [AuthenticationController::class, 'logoutCaretaker'])->name('logout');

//     Route::get('/favorite', [FavoriteController::class, 'index'])->name('job.favorite');
//     Route::put('/toggle-favorite', [FavoriteController::class, 'toggleFavorite'])->name('job.toggle-favorite');

//     Route::post('/apply-job', [CaretakerJobController::class, 'applyJob'])->name('job.apply');
//     Route::get('/job-apply', [CaretakerJobController::class, 'showJobApply'])->name('get.job.apply');
//     Route::get('/job-apply/detail/{job_id}/{job_apply_id}', [CaretakerJobController::class, 'showJobApplyDetail'])->name('get.job.apply.detail');
//     Route::get('/job-applied', [CaretakerJobController::class, 'showJobApplied'])->name('get.job.applied');
// });

// //Hospital
// Route::group(['prefix' => 'hospital', 'as' => 'hospital.', 'middleware' => ['hospital']], function () {
//     Route::get('/', [JobController::class, 'index'])->name('index');
//     Route::get('/profile', [HospitalController::class, 'showProFile'])->name('profile');
//     Route::get('/logout', [AuthenticationController::class, 'logoutHospital'])->name('logout');

//     Route::group(['prefix' => 'jobs', 'as' => 'jobs.'], function () {
//         Route::get('/list', [JobController::class, 'manage'])->name('list');
//         Route::get('/detail/{id}', [JobController::class, 'manage'])->name('show');
//         Route::get('/create', [JobController::class, 'create'])->name('create');
//         Route::get('/edit/{id}', [JobController::class, 'edit'])->name('edit');
//         Route::get('/review', [JobController::class, 'review'])->name('review');

//         Route::get('/{job_id}/caretaker-detail/{caretaker_id}/{type}', [JobController::class, 'caretakerDetail'])->name('caretaker-detail');
//         Route::post('/caretaker-process', [JobController::class, 'caretakerProcess'])->name('caretaker-process');
//     });
//     Route::get('/contact', [ContactController::class, 'createContact'])->name('contact');

//     Route::get('/job', function () {
//         return inertia('InDevelopment');
//     })->name('job');

//     Route::get('/notification', function () {
//         return inertia('InDevelopment');
//     })->name('notification');

//     Route::get('/chat', function () {
//         return inertia('InDevelopment');
//     })->name('chat');

//     Route::get('/post', function () {
//         return inertia('InDevelopment');
//     })->name('post');
// });

// Route::get('/about', function () {
//     return inertia('InDevelopment');
// })->name('about');

// Route::get('/apply', function () {
//     return inertia('InDevelopment');
// })->name('apply');

// Route::get('/top-page', function () {
//     return inertia('InDevelopment');
// })->name('top-page');


// Route::prefix('google')->as('google.')->group(function () {
//     Route::get('login', [GoogleController::class, 'loginWithGoogle'])->name('login');
//     Route::any('callback', [GoogleController::class, 'callbackFromGoogle'])->name('callback');
// });
// Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
//     return Inertia::render('Dashboard');
// })->name('dashboard');
