<?php
namespace Modules\Coach\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Modules\Admin\Models\AdminUsers;
use Illuminate\Support\Facades\Hash;


class CoachesProfileController extends Controller
{
    /**
     * Display the profile of the specified coach.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Find the coach by ID
        $coach = AdminUsers::find($id);

        if (!$coach) {
            return response()->json(['error' => 'Coach not found'], 404);
        }

        // Return the coach profile data
        return response()->json([
            'name' => $coach->name,
            'username' => $coach->username,
            'location' => $coach->location,
            'time_zone' => $coach->time_zone,
            'gender' => $coach->gender,
            'date_of_birth' => $coach->date_of_birth,
            'highest_qualification' => $coach->highest_qualification,
            'profile_picture' => $coach->profile_picture,
            'profile' => $coach->profile,
            'about_me' => $coach->about_me,
            'is_active' => $coach->is_active,
        ]);
    }

    /**
     * Update the specified coach profile in storage.
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

        // Find the coach by ID
        $coach = AdminUsers::find($id);

        if (!$coach) {
            return response()->json(['error' => 'Coach not found'], 404);
        }

        // Update the coach profile data
        $coach->fill($request->except(['password']));

        // If password is being updated, hash it before saving
        if ($request->has('password')) {
            $coach->password = Hash::make($request->password);
        }

        $coach->save();

        // Return the updated coach profile data
        return response()->json($coach);
    }
}

