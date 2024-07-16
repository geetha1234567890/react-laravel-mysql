<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\Api\UserController;
// use App\Http\Controllers\Api\CoachController;
// use App\Http\Controllers\Api\TaController;
// use App\Http\Controllers\Api\BatchController;
use App\Http\Controllers\Api\CourseController;
// use App\Http\Controllers\Api\CoachesMappingController;
use App\Http\Controllers\Api\StudentController;
// use App\Http\Controllers\Api\CoachingTemplateController;
// use App\Http\Controllers\Api\TemplateStructureController;
// use App\Http\Controllers\Api\CallRequestController;
// use App\Http\Controllers\Api\RoleController;

//coaches
Route::apiResource('coaches', CoachController::class);
Route::put('coaches/{id}/activate', [CoachController::class, 'activate']);
Route::put('coaches/{id}/deactivate', [CoachController::class, 'deactivate']);

//batches
Route::apiResource('batches', BatchController::class);

//courses
Route::apiResource('courses', CourseController::class);

//TA
Route::apiResource('tas', TaController::class);

//students
Route::apiResource('students', StudentController::class);

//coaches_mapping
Route::apiResource('coachmapping', CoachesMappingController::class);
Route::put('coachmapping/{id}/activate', [CoachesMappingController::class, 'activate']);
Route::put('coachmapping/{id}/deactivate', [CoachesMappingController::class, 'deactivate']);
Route::apiResource('coaching-templates', CoachingTemplateController::class);

Route::apiResource('call_requests', CallRequestController::class);
