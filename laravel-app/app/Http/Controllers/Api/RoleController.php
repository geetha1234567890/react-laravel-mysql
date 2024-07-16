<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Role;
use Illuminate\Support\Facades\Log;

class RoleController extends Controller
{
    /**
     * Display a listing of the roles.
     */
    public function index()
    {
        try {
            $roles = Role::all();
            return response()->json($roles);
        } catch (\Exception $e) {
            Log::error('Error fetching roles:', ['message' => $e->getMessage()]);
            return response()->json(['error' => 'Failed to retrieve roles'], 500);
        }
    }

    /**
     * Store a newly created role in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'role_name' => 'required|string|max:255',
            ]);

            $role = Role::create($request->all());

            return response()->json($role, 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation Error:', ['errors' => $e->errors()]);
            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            Log::error('Error creating role:', ['message' => $e->getMessage()]);
            return response()->json(['error' => 'An unexpected error occurred.'], 500);
        }
    }

    /**
     * Display the specified role.
     */
    public function show($id)
    {
        try {
            $role = Role::findOrFail($id);
            return response()->json($role);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['message' => 'Role Not Found'], 404);
        } catch (\Exception $e) {
            Log::error('Error fetching role:', ['message' => $e->getMessage()]);
            return response()->json(['error' => 'Failed to retrieve role'], 500);
        }
    }

    /**
     * Update the specified role in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'role_name' => 'required|string|max:255',
            ]);

            $role = Role::findOrFail($id);
            $role->update($request->all());

            return response()->json($role);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation Error:', ['errors' => $e->errors()]);
            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['message' => 'Role Not Found'], 404);
        } catch (\Exception $e) {
            Log::error('Error updating role:', ['message' => $e->getMessage()]);
            return response()->json(['error' => 'An unexpected error occurred.'], 500);
        }
    }

    /**
     * Remove the specified role from storage.
     */
    public function destroy($id)
    {
        try {
            $role = Role::findOrFail($id);
            $role->delete();
            return response()->json(null, 204);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['message' => 'Role Not Found'], 404);
        } catch (\Exception $e) {
            Log::error('Error deleting role:', ['message' => $e->getMessage()]);
            return response()->json(['error' => 'Failed to delete role'], 500);
        }
    }
}
