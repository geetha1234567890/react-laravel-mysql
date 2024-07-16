<?php

use Illuminate\Support\Facades\Route;
use Modules\Admin\Http\Controllers\AdminController;
use Modules\Admin\Http\Controllers\API\BatchController;
use Modules\Admin\Http\Controllers\API\CallRequestController;
use Modules\Admin\Http\Controllers\API\StudentController;
use Modules\Admin\Http\Controllers\API\TaMappingController;

use Modules\Admin\Http\Controllers\API\manageTasController;
use Modules\Admin\Http\Controllers\API\manageCoachesController;
use Modules\Admin\Http\Controllers\API\TaAvailabilityController;
use Modules\Admin\Http\Controllers\API\CoachMappingController;
use Modules\Admin\Http\Controllers\API\CoachSchedulingController;
use Modules\Admin\Http\Controllers\API\TASchedulingController;
use Modules\Admin\Http\Controllers\API\TACoachSlotsController;
use Modules\Admin\Http\Controllers\API\LeaveController;
use Modules\Admin\Http\Controllers\API\StudentBatchMappingController;
use Modules\Admin\Http\Controllers\API\CoachingToolController;
use Modules\Admin\Http\Controllers\API\WOLCoachingToolController;
use Modules\Admin\Http\Controllers\API\CoachingTemplateController;
use Modules\Admin\Http\Controllers\API\TimeZoneController;

use Modules\Admin\Http\Middleware\AuthMiddleware;

// Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
//     Route::apiResource('admin', AdminController::class)->names('admin');

// });
// routes/api.php




Route::prefix('v1')->group(function () {
    Route::get('timezones', [TimeZoneController::class, 'GetAllTimeZones']);
    Route::prefix('admin')->name('admin.')->group(function () {
        // Route::apiResource('admin', AdminController::class)->names('admin');
        
        Route::apiResource('batches', BatchController::class);
        Route::apiResource('call_requests', CallRequestController::class);
        Route::apiResource('students', StudentController::class);
        Route::apiResource('manage_tas', manageTasController::class);
        Route::apiResource('manage_coaches', manageCoachesController::class);

        //slots
        Route::prefix('coach-slots')->group(function () {
            Route::post('/', [TACoachSlotsController::class, 'store']);
            Route::delete('/{id}', [TACoachSlotsController::class, 'destroy']);
            // Route::get('/', [TACoachSlotsController::class, 'index']);
            Route::post('/records', [TACoachSlotsController::class, 'getTACoachRecords']);
            Route::post('/getTACoachSlotForADate', [TACoachSlotsController::class, 'getTACoachSlotForDate']);
        });

        //Ta Scheduling//
        Route::prefix('taschedules')->group(function () {
            Route::get('/', [TASchedulingController::class,'index']);
            Route::get('/{Ta_Id}', [TASchedulingController::class, 'getOneTaRecords']);
            Route::post('/', [TASchedulingController::class, 'store']);
            Route::put('/{id}', [TASchedulingController::class, 'update']);
            Route::delete('/{recordId}', [TASchedulingController::class, 'destroy']);
            Route::post('/get-schedules-records', [TASchedulingController::class, 'getScheduledRecords']);
            Route::put('/{recordId}/cancel', [TASchedulingController::class, 'cancel']);
        });

        //Coach Scheduling//
        Route::prefix('coachschedules')->group(function () {
            Route::get('/', [CoachSchedulingController::class,'index']);
            Route::get('/{Coach_Id}', [CoachSchedulingController::class, 'getOneCoachRecords']);
            Route::post('/', [CoachSchedulingController::class, 'store']);
            Route::put('/{id}', [CoachSchedulingController::class, 'update']);
            Route::delete('/{recordId}', [CoachSchedulingController::class, 'destroy']);
            Route::post('/get-schedules-records', [CoachSchedulingController::class, 'getScheduledRecords']);
            Route::put('/{recordId}/cancel', [CoachSchedulingController::class, 'cancel']);
        });

        //Coaching tools
        Route::post('/store-coaching-tools', [WOLCoachingToolController::class, 'store']);

        //middleware for check API key
        Route::middleware([AuthMiddleware::class])->group(function () {
            // Coaching template
            Route::post('/store-template', [CoachingTemplateController::class, 'storeTemplate']);
            Route::post('/coaching-templates/store-modules', [CoachingTemplateController::class, 'storeModule'])->name('coaching-templates.modules.store');
            Route::post('/coaching-templates/update-modules', [CoachingTemplateController::class, 'updateModule'])->name('coaching-templates.modules.update');
            Route::get('/coaching-templates', [CoachingTemplateController::class, 'getAllTemplates']);
            Route::get('/coaching-templates/modules', [CoachingTemplateController::class, 'getTemplateModules']);
            Route::post('/coaching-templates/store-activity', [CoachingTemplateController::class, 'storeActivity']);
            Route::get('/coaching-templates/activity-type', [CoachingTemplateController::class, 'getActivityType']);
            Route::post('/coaching-templates/activity-prerequisite', [CoachingTemplateController::class, 'activityPrerequisite']);
            Route::post('/coaching-templates/update-activity', [CoachingTemplateController::class, 'updateActivity']);
            
            Route::get('/coaching-templates/activity-status', [CoachingTemplateController::class, 'activityStatus']);  
            Route::post('/coaching-templates/link-activity', [CoachingTemplateController::class, 'linkActivity']);
            Route::post('/coaching-templates/template-assign', [CoachingTemplateController::class, 'templateAssign']);
            Route::get('/generate-api-key', [CoachingTemplateController::class, 'generateApiKey'])->withoutMiddleware([AuthMiddleware::class]);
        });

        //Leave
        Route::post('leave', [LeaveController::class, 'store']);
        Route::post('get-specific-user-slot-within-date-range', [TACoachSlotsController::class, 'getTACoachRecords']);

        //Ta availability
        Route::prefix('TA-availability')->group(function () {
            Route::get('get-today-available-ta', [TaAvailabilityController::class, 'index']);
        });
        
    
        ///////////////////////////TA Mapping///////////////////////////////
        Route::prefix('TAMapping')->group(function () {
            Route::get('{TA_Id}/AssignStudents', [TaMappingController::class, 'getAssignStudents']);
            Route::get('{TA_Id}/AssignBatches', [TaMappingController::class, 'getAssignBatches']);
            Route::post('AssignStudents', [TaMappingController::class, 'assignStudents']);
            Route::post('AssignBatches', [TaMappingController::class, 'assignBatches']);

            Route::get('/TAswithActiveStudentnBatches', [TaMappingController::class, 'TAswithActiveStudentnBatches']);

            Route::put('{id}/ActiveDeactiveAssignStudent', [TaMappingController::class, 'ActiveDeactiveAssignStudent']);

            Route::put('{id}/ActiveDeactiveAssignBatch', [TaMappingController::class, 'ActiveDeactiveAssignBatch']);

            Route::delete('{id}/deleteStudent', [TaMappingController::class, 'destroyAssignStudents']);
            Route::delete('{id}/deleteBatch', [TaMappingController::class, 'destroyAssignBatch']);
            
        });

         ////////////////////Coach Mapping///////////////////////////
         Route::prefix('CoachMapping')->name('CoachMapping')->group(function () {
            Route::get('{Coach_Id}/AssignStudents', [CoachMappingController::class, 'getAssignStudents']);
            Route::get('{Coach_Id}/AssignBatches', [CoachMappingController::class, 'getAssignBatches']);
            Route::post('AssignStudents', [CoachMappingController::class, 'assignStudents']);
            Route::post('AssignBatches', [CoachMappingController::class, 'assignBatches']);

            Route::get('/CoachswithActiveStudentnBatches', [CoachMappingController::class, 'CoachswithActiveStudentnBatches']);

            Route::put('{id}/ActiveDeactiveAssignStudent', [CoachMappingController::class, 'ActiveDeactiveAssignStudent']);

            Route::put('{id}/ActiveDeactiveAssignBatch', [CoachMappingController::class, 'ActiveDeactiveAssignBatch']);

            Route::delete('{id}/deleteStudent', [CoachMappingController::class, 'destroyAssignStudents']);
            Route::delete('{id}/deleteBatch', [CoachMappingController::class, 'destroyAssignBatch']);
        });
        
        Route::prefix('student-batch-mapping')->group(function () {
            Route::get('/', [StudentBatchMappingController::class, 'index']);
            Route::post('/', [StudentBatchMappingController::class, 'store']);
            Route::get('/getAllStudentWithBatches', [StudentBatchMappingController::class, 'getAllStudentWithBatch']);
            Route::get('/batches/{studentId}', [StudentBatchMappingController::class, 'getBatchesForStudent']);
            Route::get('/students/{batchId}', [StudentBatchMappingController::class, 'getStudentsInBatch']);
            Route::put('/update-batch/{student_id}', [StudentBatchMappingController::class, 'updateBatchForStudent']);
            Route::put('/update-student/{batch_id}', [StudentBatchMappingController::class, 'updateStudentForBatch']);
            Route::delete('/{student_id}/{batch_id}', [StudentBatchMappingController::class, 'destroy']);
        });

        Route::prefix('coaching-tool')->group(function () {
            Route::get('/', [CoachingToolController::class, 'index']);
            Route::post('/', [CoachingToolController::class, 'store']);
            Route::put('/{id}', [CoachingToolController::class, 'update']);
            Route::delete('/{id}', [CoachingToolController::class, 'destroy']);
        });
        Route::prefix('wol')->group(function () {
            // Route::post('/wol-data', [WOLCoachingToolController::class, 'store_WOLData']);
            // Route::get('/wol-data', [WOLCoachingToolController::class, 'get_WOLData']);

            Route::post('/wol-category', [WOLCoachingToolController::class, 'store_WOLCategory']);
            Route::get('/wol-category', [WOLCoachingToolController::class, 'get_WOLCategory']);
            Route::get('/wol-category/{id}', [WOLCoachingToolController::class, 'update_StatusWOLCategory']);
            Route::put('/wol-category/{id}', [WOLCoachingToolController::class, 'update_WOLCategory']);
            
            Route::post('/wol-life-instruction', [WOLCoachingToolController::class, 'store_WOLLifeInstruction']);
            Route::get('/wol-life-instruction', [WOLCoachingToolController::class, 'get_WOLLifeInstruction']);
            Route::put('/wol-life-instruction', [WOLCoachingToolController::class, 'update_WOLLifeInstruction']);
            Route::post('/wol-question', [WOLCoachingToolController::class, 'store_WOLQuestion']);
            Route::get('/wol-question', [WOLCoachingToolController::class, 'get_WOLQuestion']);
            Route::get('/wol-question/{id}', [WOLCoachingToolController::class, 'update_StatusWOLQuestion']);
            Route::put('/wol-question/{id}', [WOLCoachingToolController::class, 'update_WOLQuestion']);
            
            Route::post('/wol-option-config', [WOLCoachingToolController::class, 'store_WOLOptionConfig']);
            Route::get('/wol-option-config', [WOLCoachingToolController::class, 'get_WOLOptionConfig']);
            Route::post('/wol-option-config-update', [WOLCoachingToolController::class, 'update_WOLOptionConfig']);

            Route::post('/wol-test-config', [WOLCoachingToolController::class, 'store_WOLTestConfig']);
            Route::get('/wol-test-config', [WOLCoachingToolController::class, 'get_WOLTestConfig']);
            Route::post('/wol-test-config-update', [WOLCoachingToolController::class, 'update_WOLTestConfig']);
        });
    });
});








