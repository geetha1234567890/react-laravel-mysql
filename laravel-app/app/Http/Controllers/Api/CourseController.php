<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course; // Import the Course model
use Illuminate\Database\QueryException;

class CourseController extends Controller
{
    // Display a listing of the resource.
    public function index()
    {
        try {
            $courses = Course::all();
            return response()->json($courses);
        } catch (QueryException $e) {
            return response()->json(['message' => 'Failed to retrieve courses', 'error' => $e->getMessage()], 500);
        }
    }

    // Store a newly created resource in storage.
    public function store(Request $request)
    {
        try {
            $request->validate([
                'CourseName' => 'required|string|max:255',
                'IsActive' => 'required|boolean',
                'CreatedBy' => 'required|integer',
            ], [
                'CourseName.required' => 'The course name is required.',
                'CourseName.string' => 'The course name must be a string.',
                'CourseName.max' => 'The course name may not be greater than 255 characters.',
                'IsActive.required' => 'The active status is required.',
                'IsActive.boolean' => 'The active status must be true or false.',
                'CreatedBy.required' => 'The creator ID is required.',
                'CreatedBy.integer' => 'The creator ID must be an integer.',
            ]);

            // Check if a course with the same name already exists
            $existingCourse = Course::where('CourseName', $request->CourseName)->first();

            if ($existingCourse) {
                return response()->json(['message' => 'Course with this name already exists'], 409);
            }

            $course = new Course([
                'CourseName' => $request->CourseName,
                'IsActive' => $request->IsActive,
                'CreatedDate' => now(),
                'CreatedBy' => $request->CreatedBy,
                'UpdatedDate' => null,
                'UpdatedBy' => null,
            ]);

            $course->save();

            return response()->json(['message' => 'Course created successfully', 'course' => $course], 201);
        } catch (QueryException $e) {
            return response()->json(['message' => 'Failed to create course', 'error' => $e->getMessage()], 500);
        }
    }

    // Display the specified resource.
    public function show($id)
    {
        try {
            $course = Course::find($id);

            if ($course) {
                return response()->json($course);
            } else {
                return response()->json(['message' => 'Course not found'], 404);
            }
        } catch (QueryException $e) {
            return response()->json(['message' => 'Failed to retrieve course', 'error' => $e->getMessage()], 500);
        }
    }

    // Update the specified resource in storage.
    public function update(Request $request, $id)
    {
        try {
            $course = Course::find($id);

            if ($course) {
                $request->validate([
                    'CourseName' => 'required|string|max:255',
                    'IsActive' => 'required|boolean',
                    'UpdatedBy' => 'required|integer',
                ], [
                    'CourseName.required' => 'The course name is required.',
                    'CourseName.string' => 'The course name must be a string.',
                    'CourseName.max' => 'The course name may not be greater than 255 characters.',
                    'IsActive.required' => 'The active status is required.',
                    'IsActive.boolean' => 'The active status must be true or false.',
                    'UpdatedBy.required' => 'The updater ID is required.',
                    'UpdatedBy.integer' => 'The updater ID must be an integer.',
                ]);

                $course->CourseName = $request->CourseName;
                $course->IsActive = $request->IsActive;
                $course->UpdatedDate = now();
                $course->UpdatedBy = $request->UpdatedBy;

                $course->save();

                return response()->json(['message' => 'Course updated successfully', 'course' => $course]);
            } else {
                return response()->json(['message' => 'Course not found'], 404);
            }
        } catch (QueryException $e) {
            return response()->json(['message' => 'Failed to update course', 'error' => $e->getMessage()], 500);
        }
    }

    // Remove the specified resource from storage.
    public function destroy($id)
    {
        try {
            $course = Course::find($id);

            if ($course) {
                $course->delete();
                return response()->json(['message' => 'Course deleted successfully']);
            } else {
                return response()->json(['message' => 'Course not found'], 404);
            }
        } catch (QueryException $e) {
            return response()->json(['message' => 'Failed to delete course', 'error' => $e->getMessage()], 500);
        }
    }
}
