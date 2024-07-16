<?php

namespace Modules\Admin\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Admin\Models\StudentBatchMapping;
use Modules\Admin\Models\Student;
use Modules\Admin\Models\Batch;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;

class StudentBatchMappingController extends Controller
{
    public function index()
    {
        try {
            $mappings = StudentBatchMapping::with(['student', 'batch'])
                ->whereHas('student', function ($query) {
                    $query->where('is_active', true);
                })
                ->get()
                ->map(function ($mapping) {
                    return [
                        'Student_id' => $mapping->student->id,
                        'student_name' => $mapping->student->name,
                        'academic_term' => $mapping->student->academic_term,
                        'batch_name' => $mapping->batch->name,
                        'is_active' => $mapping->student->is_active,
                        
                    ];
                });

            return response()->json($mappings);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch mappings', 'message' => $e->getMessage()], 500);
        }
    }

    public function getAllStudentWithBatch()
    {
        try {
            // Eager load the necessary relationships
            $studentBatchMappings = StudentBatchMapping::with(['student', 'batch'])->get();

            // Group the students with their batches
            $students = $studentBatchMappings->groupBy('student_id')->map(function ($studentGroup) {
                $student = $studentGroup->first()->student;
                return [
                    'student_id' => $student->id,
                    'student_name' => $student->name,
                    'academic_term' => $student->academic_term,
                    'email' => $student->email,
                    'phone' => $student->phone,
                    'is_active' => $student->is_active,
                    'batches' => $studentGroup->map(function ($studentBatch) {
                        $batch = $studentBatch->batch;
                        return [
                            'batch_id' => $batch->id,
                            'batch_name' => $batch->name,
                            'branch' => $batch->branch,
                            'is_active' => $batch->is_active,
                        ];
                    })
                ];
            })->values();

            return response()->json($students);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch students', 'message' => $e->getMessage()], 500);
        }
    }

    public function getBatchesForStudent($studentId)
    {
        try {
            $batches = StudentBatchMapping::where('student_id', $studentId)
                ->with('batch')
                ->get()
                ->map(function ($mapping) {
                    return [
                        'batch_id' => $mapping->batch->id,
                        'batch_name' => $mapping->batch->name,
                        'is_active' => $mapping->batch->is_active,
                        'branch' => $mapping->batch->branch,
                    ];
                });

            return response()->json($batches);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Student not found'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch batches', 'message' => $e->getMessage()], 500);
        }
    }

    public function getStudentsInBatch($batchId)
    {
        try {
            $students = StudentBatchMapping::where('batch_id', $batchId)
                ->with('student')
                ->get()
                ->map(function ($mapping) {
                    return [
                        'student_id' => $mapping->student->id,
                        'student_name' => $mapping->student->name,
                        'academic_term' => $mapping->student->academic_term,
                        'email' => $mapping->student->email,
                        'phone' => $mapping->student->phone,
                        'is_active' => $mapping->student->is_active,
                    ];
                });

            return response()->json($students);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Batch not found'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch students', 'message' => $e->getMessage()], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'student_id' => 'required|exists:students,id',
                'batch_id' => 'required|exists:batches,id',
            ]);

            $mapping = StudentBatchMapping::create($validatedData);
            return response()->json(['mapping created Successfully'], 201);
        } catch (ValidationException $e) {
            return response()->json(['error' => 'Validation failed', 'messages' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to create mapping', 'message' => $e->getMessage()], 500);
        }
    }


    public function updateBatchForStudent(Request $request, $student_id)
    {
        try {
            $validatedData = $request->validate([
                'batch_id' => 'required|exists:batches,id',
            ]);

            $mapping = StudentBatchMapping::where('student_id', $student_id)->firstOrFail();
            $mapping->update(['batch_id' => $validatedData['batch_id']]);

            return response()->json($mapping);
        } catch (ValidationException $e) {
            return response()->json(['error' => 'Validation failed', 'messages' => $e->errors()], 422);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Mapping not found'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update mapping', 'message' => $e->getMessage()], 500);
        }
    }

    public function updateStudentForBatch(Request $request, $batch_id)
    {
        try {
            $validatedData = $request->validate([
                'student_id' => 'required|exists:students,id',
            ]);

            $mapping = StudentBatchMapping::where('batch_id', $batch_id)->firstOrFail();
            $mapping->update(['student_id' => $validatedData['student_id']]);

            return response()->json($mapping);
        } catch (ValidationException $e) {
            return response()->json(['error' => 'Validation failed', 'messages' => $e->errors()], 422);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Mapping not found'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update mapping', 'message' => $e->getMessage()], 500);
        }
    }

    public function destroy($student_id, $batch_id)
    {
        try {
            $mapping = StudentBatchMapping::where('student_id', $student_id)
                ->where('batch_id', $batch_id)
                ->firstOrFail();
            $mapping->delete();

            return response()->json(null, 204);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Mapping not found'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete mapping', 'message' => $e->getMessage()], 500);
        }
    }
}
