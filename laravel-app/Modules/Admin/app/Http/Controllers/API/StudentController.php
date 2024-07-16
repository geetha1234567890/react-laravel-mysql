<?php

namespace Modules\Admin\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Admin\Models\Student;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $students = Student::all();
            return response()->json($students);
        } catch (QueryException $e) {
            return response()->json(['message' => 'Failed to retrieve students', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {

            $request->validate([
                'name' => 'required|string|max:255',
                'student_lms_id' => 'nullable|string|max:255',
                'email' => 'nullable|string|email|max:255',
                'academic_term' => 'nullable|string|max:255',
                'class_id' => 'nullable|string|max:255',
                'board_id' => 'nullable|string|max:255',
                'stream_id' => 'nullable|string|max:255',
                'phone' => 'nullable|string|max:255',
                'primary_phone' => 'nullable|string|max:255',
                'primary_email' => 'nullable|string|email|max:255',
                'is_active' => 'required|boolean',
                'created_by' => 'nullable|integer',
                'updated_by' => 'nullable|integer',
            ]);

            // Check if a student with the same email or student LMS ID already exists
            if (Student::where('email', $request->email)->exists() || 
                Student::where('student_lms_id', $request->student_lms_id)->exists()) {
                return response()->json(['error' => 'Student with this email or student LMS ID already exists'], 400);
            }

            $student = Student::create($request->all());

            return response()->json($student, 201);
        } catch (QueryException $e) {
            return response()->json(['message' => 'Failed to create student', 'error' => $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        try {
            $student = Student::findOrFail($id);
            return response()->json($student);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Student not found', 'error' => $e->getMessage()], 404);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to retrieve student', 'error' => $e->getMessage()], 500);
        }
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('admin::edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Student $student)
    {
        try {
            // Check if the student exists
            if (!$student) {
                throw new ModelNotFoundException('Student not found');
            }
    
            $request->validate([
                'name' => 'required|string|max:255',
                'student_lms_id' => 'nullable|string|max:255',
                'email' => 'nullable|string|email|max:255',
                'academic_term' => 'nullable|string|max:255',
                'class_id' => 'nullable|string|max:255',
                'board_id' => 'nullable|string|max:255',
                'stream_id' => 'nullable|string|max:255',
                'phone' => 'nullable|string|max:255',
                'primary_phone' => 'nullable|string|max:255',
                'primary_email' => 'nullable|string|email|max:255',
                'is_active' => 'required|boolean',
                'created_by' => 'nullable|integer',
                'updated_by' => 'nullable|integer',
            ]);
    
            // Check if a student with the same email or student LMS ID already exists (excluding the current student)
            if (Student::where('email', $request->email)->where('id', '!=', $student->id)->exists() ||
                Student::where('student_lms_id', $request->student_lms_id)->where('id', '!=', $student->id)->exists()) {
                return response()->json(['error' => 'Student with this email or student LMS ID already exists'], 400);
            }
    
            $student->update($request->all());
    
            return response()->json($student);
        } catch (ValidationException $e) {
            return response()->json(['message' => 'Validation failed', 'errors' => $e->errors()], 422);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Student not found'], 404); // Custom error message for student not found
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to update student', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    // public function destroy(Student $student)
    // {
    //     try {
    //         $student->delete();
    //         return response()->json("Record deleted successfully", 200);
    //     } catch (QueryException $e) {
    //         return response()->json(['message' => 'Failed to delete student', 'error' => $e->getMessage()], 500);
    //     }
    // }

    public function destroy(Student $student)
    {
        try {
            // Check if the student exists
            if (!$student) {
                throw new ModelNotFoundException('Student not found');
            }

            $student->delete();

            return response()->json("Record deleted successfully", 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Student not found'], 404); // Custom error message for student not found
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to delete student', 'error' => $e->getMessage()], 500);
        }
    }


}
