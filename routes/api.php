<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\GenderController;
use App\Http\Controllers\Api\JobCancelController;
use App\Http\Controllers\Api\MailController;
use App\Http\Controllers\Api\SpecialityController;
use App\Http\Controllers\Api\StatusController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\SpecialistApplicationController;
use App\Http\Controllers\Api\UserJobController;

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
Route::get('/avatar/{user_id}', [UserController::class, 'avatar'])->name('avatar');

Route::get('/attachment/{attachment}', [SpecialistApplicationController::class, 'attachment'])->name('attachment');
Route::get('/user_job_attachment/{attachment}', [UserJobController::class, 'attachment'])->name('user_job.attachment');

Route::post('/register', [AuthController::class,'register']);
Route::post('/login', [AuthController::class,'login']);

Route::get('/specialists', [UserController::class, 'specialists']);

Route::post('/forgot_password', [AuthController::class, 'forgotPassword']);
Route::post('/reset_password/{user}', [AuthController::class, 'resetPassword'])->name('reset_password');

Route::middleware(['auth:api'])->group(function () {

    Route::group(['middleware' => ['can:manage.users']], function () {
        Route::apiResource('users', UserController::class)->except('update');
    });
    Route::apiResource('users', UserController::class)->only('update', 'show');

    Route::group(['middleware' => ['can:manage.applications']], function () {
        Route::apiResource('specialist_application', SpecialistApplicationController::class)->except('store');
    });
    Route::apiResource('specialist_application', SpecialistApplicationController::class)->only('store');

    Route::get('/specialist_application/{attachment}/{status}', [SpecialistApplicationController::class, 'changeStatus']);

    Route::group(['middleware' => ['can:manage.user_jobs']], function () {
        Route::apiResource('user_jobs', UserJobController::class)->except('show', 'store', 'index');
        Route::apiResource('statuses', StatusController::class);
    });
    Route::apiResource('user_jobs', UserJobController::class)->only('show', 'store', 'index');
    Route::group(['middleware' => ['can:manage.job_cancel']], function () {
        Route::apiResource('job_cancels', JobCancelController::class)->except('store');
    });
    Route::apiResource('job_cancels', JobCancelController::class)->only('store');
    Route::group(['middleware' => ['can:manage.support']], function () {
        Route::apiResource('mails', MailController::class);
    });

    Route::group(['middleware' => ['can:manage.specialities']], function () {
        Route::apiResource('specialities', SpecialityController::class)->except('index');
        Route::post('/specialities/upload_json', [SpecialityController::class, 'uploadJSON']);
    });
    Route::apiResource('specialities', SpecialityController::class)->only('index');
    Route::group(['middleware' => ['can:start.user_job']], function () {
        Route::get('/user_jobs/start/{user_job}', [UserJobController::class, 'startJob']);
    });

    Route::group(['middleware' => ['can:end.user_job']], function () {
        Route::get('/user_jobs/end/{user_job}', [UserJobController::class, 'startJob']);
    });

    Route::group(['middleware' => ['can:accept.user_job']], function () {
        Route::get('/user_jobs/accept/{user_job}', [UserJobController::class, 'startJob']);
    });

    Route::group(['middleware' => ['can:decline.user_job']], function () {
        Route::get('/user_jobs/decline/{user_job}', [UserJobController::class, 'startJob']);
    });

    Route::group(['middleware' => ['can:create.bill']], function () {
        Route::put('/set_bill/{user_job}', [UserJobController::class, 'setBill']);
    });

    Route::get('/permissions', [UserController::class, 'getPermissions']);
    Route::get('/roles', [UserController::class, 'getRoles']);

    Route::post('/change_password',[AuthController::class,'changePassword']);
    Route::get('/user', [AuthController::class, 'user']);
    Route::get('/logout', [AuthController::class, 'logout']);

    Route::get('/reviews/{user}', [UserJobController::class, 'reviews']);
    Route::get('/offers', [UserJobController::class, 'offers'])->name('offers');

    Route::get('/user_jobs/payment/session_create/{user_job}', [UserJobController::class, 'sessionCreate']);
    Route::get('/user_jobs/payment/session_handle', [UserJobController::class, 'handleCheckout']);

});

