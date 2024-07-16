<?php

namespace Modules\Admin\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Modules\Admin\Models\AdminUsers;
use Modules\Admin\Models\Role;
use Illuminate\Support\Facades\DB;

class manageTasController extends Controller
{
    public function index()
    {
        try {
            $taRole = Role::where('role_name', 'TA')->first();
            $tas = AdminUsers::whereHas('roles', function ($query) use ($taRole) {
                $query->where('role_id', $taRole->id);
            })->get()->map(function ($ta) {
                $data = $ta->only([
                    'id', 'name', 'username', 'email', 'phone', 'location', 'address', 'pincode', 'time_zone', 'gender',
                    'date_of_birth', 'highest_qualification', 'profile', 'about_me', 'is_active', 
                    'created_by', 'updated_by', 'created_at', 'updated_at'
                ]);
                $data['profile_picture'] = $ta->profile_picture ? base64_encode($ta->profile_picture) : null;
                return $data;
            });

            return response()->json($tas, 200);
        } catch (\Exception $e) {
            Log::error('Error fetching TAs:', ['message' => $e->getMessage()]);
            return response()->json(['error' => 'Failed to retrieve TAs'], 500);
        }
    }

    public function store(Request $request)
{
    try {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:admin_users,username',
            'email' => 'required|string|email|max:255|unique:admin_users,email',
            'phone' => 'required|string|max:20|unique:admin_users,phone',
            'password' => 'required|string|max:255',
            'location' => 'string|nullable',
            'address' => 'string|nullable',
            'pincode' => 'string|nullable',
            'timezone' => 'string|nullable',
            'gender' => 'required|in:Male,Female,Other',
            'date_of_birth' => 'required|date',
            'highest_qualification' => 'required|string|max:255',
            'profile_picture' => 'nullable|string', // Expect base64 encoded string
            'profile' => 'nullable|string',
            'about_me' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $timezone = $request->timezone ?? $this->getDefaultTimezone();
        $hashedPassword = Hash::make($request->password);

        // Convert base64 to binary if profile_picture is present
        $profilePicture = null;
        if ($request->has('profile_picture')) {
            $profilePicture = base64_decode($request->profile_picture);
        }

        $ta = AdminUsers::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => $hashedPassword,
            'location' => $request->location,
            'address' => $request->address,
            'pincode' => $request->pincode,
            'time_zone' => $timezone,
            'gender' => $request->gender,
            'date_of_birth' => $request->date_of_birth,
            'highest_qualification' => $request->highest_qualification,
            'profile_picture' => $profilePicture,
            'profile' => $request->profile,
            'about_me' => $request->about_me
        ]);

        $taRole = Role::where('role_name', 'TA')->first();

        if ($taRole) {
            DB::table('user_roles')->insert([
                'user_id' => $ta->id,
                'role_id' => $taRole->id
            ]);
        }

        if ($ta->profile_picture) {
            $ta->profile_picture = base64_encode($ta->profile_picture);
        } 

        return response()->json([
            'message' => 'TA successfully created',
            'ta' => $ta
        ], 201);
    } catch (ValidationException $e) {
        Log::error('Validation Error:', ['errors' => $e->errors()]);
        return response()->json(['errors' => $e->errors()], 422);
    } catch (\Exception $e) {
        Log::error('Error creating TA:', ['message' => $e->getMessage()]);
        return response()->json(['error' => 'Failed to create TA', 'message' => $e->getMessage()], 500);
    }
}

    public function show($id)
    {
        try {
            $taRole = Role::where('role_name', 'TA')->first();
            $ta = AdminUsers::where('id', $id)
                ->whereHas('roles', function ($query) use ($taRole) {
                    $query->where('role_id', $taRole->id);
                })
                ->first();

            if (is_null($ta)) {
                return response()->json(['message' => 'TA Not Found or not a TA'], 404);
            }

            $data = $ta->only([
                'id', 'name', 'username', 'email', 'phone', 'location', 'address', 'pincode', 'time_zone', 'gender',
                'date_of_birth', 'highest_qualification', 'profile', 'about_me', 'is_active', 
                'created_by', 'updated_by', 'created_at', 'updated_at'
            ]);
            $data['profile_picture'] = $ta->profile_picture ? base64_encode($ta->profile_picture) : null;

            return response()->json($data, 200);
        } catch (\Exception $e) {
            Log::error('Error fetching TA:', ['message' => $e->getMessage()]);
            return response()->json(['error' => 'Failed to retrieve TA'], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $taRole = Role::where('role_name', 'TA')->first();
            $ta = AdminUsers::where('id', $id)
                ->whereHas('roles', function ($query) use ($taRole) {
                    $query->where('role_id', $taRole->id);
                })
                ->first();
    
            if (is_null($ta)) {
                return response()->json(['message' => 'TA Not Found or Given id not for TA'], 404);
            }
    
            $rules = [
                'name' => 'string|max:255',
                'username' => 'string|max:255|unique:admin_users,username,' . $id,
                'phone' => 'string|max:20|unique:admin_users,phone,' . $id,
                'password' => 'string|max:255',
                'location' => 'string|nullable',
                'address' => 'string|nullable',
                'pincode' => 'string|nullable',
                'timezone' => 'string|nullable',
                'gender' => 'in:Male,Female,Other',
                'date_of_birth' => 'date',
                'highest_qualification' => 'string|max:255',
                'profile_picture' => 'nullable|string', // Expect base64 encoded string
                'profile' => 'nullable|string',
                'about_me' => 'nullable|string',
                'is_active' => 'boolean'
            ];
    
            $validator = Validator::make($request->all(), $rules);
    
            if ($validator->fails()) {
                return response()->json($validator->errors(), 400);
            }
    
            $allowedFields = array_keys($rules);
            $extraFields = array_diff(array_keys($request->all()), $allowedFields);
    
            if (!empty($extraFields)) {
                return response()->json(['message' => 'You cannot update these fields: ' . implode(', ', $extraFields)], 400);
            }
    
            $input = $request->except(['email']);
    
            if (!isset($input['timezone'])) {
                $input['timezone'] = $this->getDefaultTimezone();
            }
    
            if (isset($input['password'])) {
                $input['password'] = Hash::make($input['password']);
            }
    
            // Convert base64 to binary if profile_picture is present
            if ($request->has('profile_picture')) {
                $input['profile_picture'] = base64_decode($request->profile_picture);
            }
    
            $ta->update($input);

            if ($ta->profile_picture) {
                $ta->profile_picture = base64_encode($ta->profile_picture);
            }  
    
            return response()->json($ta, 200);
        } catch (ValidationException $e) {
            Log::error('Validation Error:', ['errors' => $e->errors()]);
            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            Log::error('Error updating TA:', ['message' => $e->getMessage()]);
            return response()->json(['error' => 'An unexpected error occurred.'], 500);
        }
    }
    

    public function destroy($id)
    {
        try {
            $taRole = Role::where('role_name', 'TA')->first();
            $ta = AdminUsers::where('id', $id)
                ->whereHas('roles', function ($query) use ($taRole) {
                    $query->where('role_id', $taRole->id);
                })
                ->first();

            if (is_null($ta)) {
                return response()->json(['message' => 'TA Not Found or not a TA'], 404);
            }

            $ta->delete();
            return response()->json(null, 204);
        } catch (\Exception $e) {
            Log::error('Error deleting TA:', ['message' => $e->getMessage()]);
            return response()->json(['error' => 'Failed to delete TA'], 500);
        }
    }

    private function getDefaultTimezone()
    {
        return 'IST';
    }
}
