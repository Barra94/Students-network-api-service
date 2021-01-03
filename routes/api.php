<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\API\SkillController;
use App\Http\Controllers\OAuthFontysController;
use \App\Http\Controllers\API\StudentController;
use \App\Http\Controllers\API\StudentSkillController;
use \App\Http\Controllers\API\EndorsementsController;
use \App\Http\Controllers\API\Profile\ProfileController;
use App\Http\Controllers\API\Authentication\LoginController;
use \App\Http\Controllers\API\Profile\ProfileSkillController;
use App\Http\Controllers\API\Authentication\ResetPasswordController;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//Profile Endpoints
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/student/me', [ProfileController::class, 'show']);
    Route::put('/student/me', [ProfileController::class, 'update']);
    Route::delete('/student/me', [ProfileController::class, 'destroy']);
});

//Profile Skill Endpoints
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/student/me/skill/all', [ProfileSkillController::class, 'show'])->name('get-all-skills-of-profile');
    Route::post('/student/me/skill/{skillId}', [ProfileSkillController::class, 'store'])->name('add-new-skill-for-profile');
    Route::delete('/student/me/skill/{skillId}', [ProfileSkillController::class, 'destroy'])->name('delete-student-skill');
});

//Student Endpoints
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/student/all', [StudentController::class, 'index']);
    Route::get('/student/{id}', [StudentController::class, 'show']);
    Route::put('/student/{id}', [StudentController::class, 'update']);
    Route::delete('/student/{id}', [StudentController::class, 'destroy']);
});

//Student Skill Endpoints
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/student/{id}/skill/all', [StudentSkillController::class, 'show'])->name('get-all-skills-of-student');
    Route::post('/student/{id}/skill', [StudentSkillController::class, 'store'])->name('add-new-skill-for-student');
    Route::put('/student/{id}/skill', [StudentSkillController::class, 'update'])->name('update-student-skill');
    Route::delete('/student/{studentId}/skill/{skillId}', [StudentSkillController::class, 'destroy'])->name('delete-student-skill');
});

//Skill Endpoints
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/skill/all', [SkillController::class, 'index'])->name('get-all-skills');
    Route::get('/skill/{id}', [SkillController::class, 'show'])->name('get-skill-by-id');
    Route::post('/skill', [SkillController::class, 'store'])->name('create-new-skill');
    Route::put('/skill/{id}', [SkillController::class, 'update'])->name('update-skill');
    Route::delete('/skill/{id}', [SkillController::class, 'destroy'])->name('delete-skill');
});

//Auth Endpoints
Route::post('/student/login', [LoginController::class, 'index'])->name('login');
Route::middleware('auth:sanctum')->put('/student/password/update', [LoginController::class, 'update'])->name('update-password');
Route::get('/fontys/authorization', [OAuthFontysController::class, 'create'])->name('fontys-redirect');

//Endorsements Endpoints
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/endorse/student/{studentId}/skill/{skillId}', [EndorsementsController::class, 'store']);
});

//Request reset password code Endpoint
Route::put('/request/reset/password/email/{email}', [ResetPasswordController::class, 'requestResetPasswordCode']);
Route::put('/reset/password', [ResetPasswordController::class, 'resetPassword']);

