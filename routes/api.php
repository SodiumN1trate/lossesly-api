<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\GenderController;
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

Route::post('/register',[AuthController::class,'register']);
Route::post('/login',[AuthController::class,'login']);

Route::get('/specialists', [UserController::class, 'specialists']);

Route::middleware(['auth:api'])->group(function () {
    Route::apiResources([
        'user_jobs' => UserJobController::class,
        'users' => UserController::class,
        'specialities' => SpecialityController::class,
        'genders' => GenderController::class,
        'statuses' => StatusController::class,
        'mails' => MailController::class,
    ]);

    Route::post('/change_password',[AuthController::class,'changePassword']);
    Route::get('/user', [AuthController::class, 'user']);
    Route::apiResources([
        'users' => UserController::class,
        'user_jobs'=>UserJobController::class,
        'specialist_application' => SpecialistApplicationController::class,
    ]);
    Route::get('/logout', [AuthController::class, 'logout']);
    Route::post('/specialities/upload_json', [SpecialityController::class, 'uploadJSON']);

    Route::get('/reviews/{user}', [UserJobController::class, 'reviews']);
});


