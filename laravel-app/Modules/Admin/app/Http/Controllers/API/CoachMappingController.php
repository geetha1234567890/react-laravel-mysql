<?php

namespace Modules\Admin\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

use Modules\Admin\Models\AdminUsers;
use Modules\Admin\Models\TACoachStudentMapping;
use Modules\Admin\Models\TACoachBatchMapping;
use Modules\Admin\Models\Student;
use Modules\Admin\Models\Batch;
use Modules\Admin\Models\StudentBatchMapping;
use Modules\Admin\Models\Role;

class CoachMappingController extends Controller
{
    public function getAssignStudents($Coach_Id)
    {
        try {
            $CoachRole = Role::where('role_name', 'Coach')->first();
            $Coach = AdminUsers::whereHas('roles', function ($query) use ($CoachRole) {
                $query->where('role_id', $CoachRole->id);
            })->where('id', $Coach_Id)->first();

            if (!$Coach) {
                return response()->json(['message' => 'Coach not found.'], 404);
            }

            $mappings = TACoachStudentMapping::with(['AdminUsers', 'Student.studentBatchMappings.Batch'])
                        ->where('is_deleted', false)
                        ->where('admin_user_id', $Coach_Id)
                        ->get();

            $data = $mappings->map(function($mapping) {
                $student = $mapping->student;
                $batches = $student->studentBatchMappings->map(function ($studentBatchMapping) {
                    return [
                        'batch_id' => $studentBatchMapping->batch->id,
                        'batch_name' => $studentBatchMapping->batch->name,
                        'branch' => $studentBatchMapping->batch->branch,
                        'is_active' => $studentBatchMapping->batch->is_active,
                    ];
                });

                return [
                    'id' => $mapping->id,
                    'Coach' => [
                        'id' => $mapping->AdminUsers->id,
                        'name' => $mapping->AdminUsers->name,
                    ],
                    'student' => [
                        'id' => $student->id,
                        'name' => $student->name,
                        'academic_term' => $student->academic_term,
                        'batches' => $batches,
                    ],
                    'is_active' => $mapping->is_active,
                ];
            });

            return response()->json($data, 200);

        } catch (\Exception $e) {
            Log::error('Error fetching Coachs:', ['message' => $e->getMessage()]);
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function getAssignBatches($Coach_Id)
    {
        try {
            $CoachRole = Role::where('role_name', 'Coach')->first();
            $Coach = AdminUsers::whereHas('roles', function ($query) use ($CoachRole) {
                $query->where('role_id', $CoachRole->id);
            })->where('id', $Coach_Id)->first();

            if (!$Coach) {
                return response()->json(['message' => 'Coach not found.'], 404);
            }

            $mappings = TACoachBatchMapping::with(['AdminUsers', 'batch'])
                ->where('is_deleted', false)
                ->where('admin_user_id', $Coach_Id)
                ->get();

            $data = $mappings->map(function ($mapping) {
                return [
                    'id' => $mapping->id,
                    'coach' => [
                        'id' => $mapping->AdminUsers->id,
                        'name' => $mapping->AdminUsers->name,
                    ],
                    'batch' => [
                        'id' => $mapping->batch->id,
                        'name' => $mapping->batch->name,
                        'branch' => $mapping->batch->branch,
                    ],
                    'is_active' => $mapping->is_active,
                ];
            });

            return response()->json($data, 200);

        } catch (\Exception $e) {
            Log::error('Error fetching batches:', ['message' => $e->getMessage()]);
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function assignStudents(Request $request)
    {
        try{
            $request->validate([
                'Coach_id' => 'required|exists:admin_users,id',
                'student' => 'required|array',
                'student.*.id' => 'required|string',
                // 'students.*.academic_term' => 'required|string',
                // 'students.*.batch' => 'required|string'
            ]);

            $CoachRole = Role::where('role_name', 'Coach')->first();
            $Coach = AdminUsers::whereHas('roles', function ($query) use ($CoachRole) {
                $query->where('role_id', $CoachRole->id);
            })->where('id', $request->Coach_id)->first();

            if (!$Coach) {
                return response()->json(['message' => 'Coach not found.'], 404);
            }

            foreach ($request->student as $studentData) {
                $student = TACoachStudentMapping ::firstOrCreate(
                    ['student_id' => $studentData['id'], 'admin_user_id' => $request['Coach_id']],
                );
            }
    
            return response()->json([
                'message' => 'Students assigned successfully',
                // 'Coach' => $Coach->load('student')
            ], 200);
        }
         catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation Error:', ['errors' => $e->errors()]);
            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            Log::error('Unexpected Error:', ['message' => $e->getMessage()]);
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function assignBatches(Request $request)
    {
        try {
            $request->validate([
                'Coach_id' => 'required|exists:admin_users,id',
                'batches' => 'required|array',
                'batches.*.id' => 'required|string',
            ]);

            $CoachRole = Role::where('role_name', 'Coach')->first();
            $Coach = AdminUsers::whereHas('roles', function ($query) use ($CoachRole) {
                $query->where('role_id', $CoachRole->id);
            })->where('id', $request->Coach_id)->first();

            if (!$Coach) {
                return response()->json(['message' => 'Coach not found.'], 404);
            }
    
            foreach ($request->batches as $batchData) {
                TACoachBatchMapping::firstOrCreate([
                    'batch_id' => $batchData['id'],
                    'admin_user_id' => $request->Coach_id,
                ]);
                $studentListData = StudentBatchMapping::where('batch_id',  $batchData['id'])->get();
                foreach ($studentListData as $studentData) {
                    $student = TACoachStudentMapping ::firstOrCreate(
                        ['student_id' => $studentData['student_id'], 'admin_user_id' => $request->Coach_id],
                    );
                }

            }
    
            return response()->json([
                'message' => 'Batches assigned successfully',
            ], 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation Error:', ['errors' => $e->errors()]);
            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            Log::error('Unexpected Error:', ['message' => $e->getMessage()]);
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
    

    public function CoachswithActiveStudentnBatches()
    {
        try {
            $coachRole = Role::where('role_name', 'Coach')->first();
            $coachs = AdminUsers::whereHas('roles', function ($query) use ($coachRole) {
                $query->where('role_id', $coachRole->id);
            })->get()->map(function ($coach) {
                $data = $coach->only(['id', 'name', 'username', 'is_active']);
                
                // Count active batches assigned to this coach
                $batchCount = TACoachBatchMapping::where('admin_user_id', $coach->id)
                    ->where('is_active', true)
                    ->count();
                
                // Count active students assigned to this coach
                $studentCount = TACoachStudentMapping::where('admin_user_id', $coach->id)
                    ->where('is_active', true)
                    ->count();
                
                // Add counts to the coach object
                $data['Active_Batches'] = $batchCount;
                $data['Active_Students'] = $studentCount;
                
                return $data;
            });

            if ($coachs->isEmpty()) {
                return response()->json(['message' => 'coachs Not Found'], 404);
            }
        
            return response()->json($coachs, 200);
        
        } catch (\Exception $e) {
            Log::error('Error fetching coach:', ['message' => $e->getMessage()]);
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id): RedirectResponse
    {
        // Implement update logic if needed
        return redirect()->back();
    }

    public function ActiveDeactiveAssignStudent($id)
    {
        try {
            $mapping = TACoachStudentMapping ::find($id);
        if (!$mapping) {
            return response()->json(['message' => 'Mapping not found.'], 404);
        }
        $mapping->is_active = !$mapping->is_active;
        $mapping->save();

        if($mapping->is_active){
            return response()->json(['message' => 'Student Activated successfully.']);
        }else{
            return response()->json(['message' => 'Student De-Activated successfully.']);
        }
        } catch (\Exception $e) {
            Log::error('Error Activeted Student:', ['message' => $e->getMessage()]);
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
    

    public function ActiveDeactiveAssignBatch($id)
    {
        try {
            $mapping = TACoachBatchMapping::find($id);

        if (!$mapping) {
            return response()->json(['message' => 'Mapping not found.'], 404);
        }

        // Soft delete the record by setting is_deleted to true
        // TODO : all student of particular batch should be deactivated
        $mapping->is_active = !$mapping->is_active;
        $mapping->save();

        if($mapping->is_active){
            return response()->json(['message' => 'Batch Activated successfully.']);
        }else{
            return response()->json(['message' => 'Batch De-Activated successfully.']);
        }
        } catch (\Exception $e) {
            Log::error('Error Activeted Student:', ['message' => $e->getMessage()]);
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function destroyAssignStudents($id)
    {
        try {
            $mapping = TACoachStudentMapping::find($id);

            if (!$mapping) {
                return response()->json(['message' => 'Mapping not found.'], 404);
            }

            $mapping->is_deleted = true;
            $mapping->save();

            return response()->json(['message' => 'Mapping deleted successfully.']);
        } catch (\Exception $e) {
            Log::error('Error deleting student mapping:', ['message' => $e->getMessage()]);
            return response()->json(['error' => 'Failed to delete student mapping'], 500);
        }
    }

    public function destroyAssignBatch($id)
    {
        try {
            $mapping = TACoachBatchMapping::find($id);

            if (!$mapping) {
                return response()->json(['message' => 'Mapping not found.'], 404);
            }

            // TODO : all student of particular batch should be deleted

            $mapping->is_deleted = true;
            $mapping->save();

            return response()->json(['message' => 'Mapping deleted successfully.']);
        } catch (\Exception $e) {
            Log::error('Error deleting batch mapping:', ['message' => $e->getMessage()]);
            return response()->json(['error' => 'Failed to delete batch mapping'], 500);
        }
    }
}

