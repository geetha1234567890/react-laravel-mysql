<?php
namespace Modules\TA\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Modules\Admin\Models\AdminUsers;
use Illuminate\Support\Facades\Hash;


class TAProfileController extends Controller
{
    /**
     * Display the profile of the specified ta.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Find the ta by ID
        $ta = AdminUsers::find($id);

        if (!$ta) {
            return response()->json(['error' => 'TA not found'], 404);
        }

        // Return the ta profile data
        return response()->json([
            'name' => $ta->name,
            'username' => $ta->username,
            'location' => $ta->location,
            'time_zone' => $ta->time_zone,
            'gender' => $ta->gender,
            'date_of_birth' => $ta->date_of_birth,
            'highest_qualification' => $ta->highest_qualification,
            'profile_picture' => $ta->profile_picture,
            'profile' => $ta->profile,
            'about_me' => $ta->about_me,
            'is_active' => $ta->is_active,
        ]);
    }

    /**
     * Update the specified ta profile in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Validate the incoming request data
        $request->validate([
            'name' => 'sometimes|string|max:255',
            'username' => 'sometimes|string|max:255|unique:admin_users,username,' . $id,
            'password' => 'sometimes|string|min:6',
            'location' => 'sometimes|string|max:255',
            'time_zone' => 'sometimes|string|max:255',
            'gender' => 'sometimes|string|max:255',
            'date_of_birth' => 'sometimes|date',
            'highest_qualification' => 'sometimes|string|max:255',
            'profile_picture' => 'sometimes|string|max:255',
            'profile' => 'sometimes|string|max:255',
            'about_me' => 'sometimes|string|max:255',
            'is_active' => 'sometimes|boolean',
        ]);

        // Find the ta by ID
        $ta = AdminUsers::find($id);

        if (!$ta) {
            return response()->json(['error' => 'ta not found'], 404);
        }

        // Update the ta profile data
        $ta->fill($request->except(['password']));

        // If password is being updated, hash it before saving
        if ($request->has('password')) {
            $ta->password = Hash::make($request->password);
        }

        $ta->save();

        // Return the updated ta profile data
        return response()->json($ta);
    }
}

