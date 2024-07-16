<?php

namespace Modules\Coach\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CoachController extends Controller
{
    // Create a new coach
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required'],
            'username' => ['required', 'unique:coaches,username'],
            'password' => ['required', 'min:8'],
            'location' => ['required'],
            'time_zone' => ['required'],
            'gender' => ['required', 'in:Male,Female,Other'],
            'date_of_birth' => ['required', 'date'],
            'highest_qualification' => ['required'],
            'profile' => ['required'],
            'about_me' => ['required'],
            'is_active' => ['boolean'],
            'created_by' => ['nullable', 'integer'],
            'updated_by' => ['nullable', 'integer'],
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()], 400);
        }

        $coach = Coach::create($request->all());

        return response()->json(['message' => 'Coach created successfully', 'coach' => $coach], 201);
    }

    // Update an existing coach
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['sometimes', 'required'],
            'username' => ['sometimes', 'required', 'unique:coaches,username,'.$id],
            'password' => ['sometimes', 'required', 'min:8'],
            'location' => ['sometimes', 'required'],
            'time_zone' => ['sometimes', 'required'],
            'gender' => ['sometimes', 'required', 'in:Male,Female,Other'],
            'date_of_birth' => ['sometimes', 'required', 'date'],
            'highest_qualification' => ['sometimes', 'required'],
            'profile' => ['sometimes', 'required'],
            'about_me' => ['sometimes', 'required'],
            'is_active' => ['boolean'],
            'updated_by' => ['nullable', 'integer'],
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()], 400);
        }

        $coach = Coach::findOrFail($id);
        $coach->update($request->all());

        return response()->json(['message' => 'Coach updated successfully', 'coach' => $coach], 200);
    }

    // Get all coaches
    public function index()
    {
        $coaches = Coach::all();
        return response()->json($coaches, 200);
    }

    public function activate($id)
    {
        $coach = Coach::findOrFail($id);
        $coach->is_active = true;
        $coach->save();

        return response()->json(['message' => 'Coach activated successfully'], 200);
    }

    // Deactivate coach
    public function deactivate($id)
    {
        $coach = Coach::findOrFail($id);
        $coach->is_active = false;
        $coach->save();

        return response()->json(['message' => 'Coach deactivated successfully'], 200);
    }

    // Get coach status
    public function status($id)
    {
        $coach = Coach::findOrFail($id);

        return response()->json(['is_active' => $coach->is_active], 200);
    }

}
