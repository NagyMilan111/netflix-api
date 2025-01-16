<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{
    /**
     * Add a new profile for an account.
     */
    public function addProfile(Request $request)
    {
        // Validate the request
        $validatedData = $request->validate([
            'account_id' => 'required|integer|exists:Account,account_id',
            'profile_name' => 'required|string|max:255',
            'profile_age' => 'required|integer|min:1',
            'profile_lang' => 'required|integer|exists:Language,lang_id',
        ]);

        // Insert the profile into the database
        DB::table('Profile')->insert([
            'account_id' => $validatedData['account_id'],
            'profile_name' => $validatedData['profile_name'],
            'profile_image' => 'placeholder.jpeg', // Default profile image
            'profile_age' => $validatedData['profile_age'],
            'profile_lang' => $validatedData['profile_lang'],
            'profile_movies_preferred' => 0, // Default value
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json(['message' => 'Profile added successfully'], 201);
    }

    /**
     * Update preferences for a profile.
     */
    public function updatePreferences(Request $request)
    {
        // Validate the request
        $validatedData = $request->validate([
            'profile_id' => 'required|integer|exists:Profile,profile_id',
            'profile_movies_preferred' => 'nullable|boolean',
        ]);

        // Update preferences in the database
        $updated = DB::table('Profile')->where('profile_id', $validatedData['profile_id'])->update([
            'profile_movies_preferred' => $validatedData['profile_movies_preferred'] ?? 0,
            'updated_at' => now(),
        ]);

        if (!$updated) {
            return response()->json(['error' => 'Failed to update preferences'], 500);
        }

        return response()->json(['message' => 'Preferences updated successfully'], 200);
    }

    /**
     * Delete a profile by its ID.
     */
    public function deleteProfile($id)
    {
        // Check if the profile exists
        $profile = DB::table('Profile')->where('profile_id', $id)->first();

        if (!$profile) {
            return response()->json(['error' => 'Profile not found'], 404);
        }

        // Delete the profile from the database
        DB::table('Profile')->where('profile_id', $id)->delete();

        return response()->json(['message' => 'Profile deleted successfully'], 200);
    }
}

//old test controller with api made with same file, can give errors if removed
namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function getTotalViews($profileId)
    {
        // Call the stored procedure
        $result = DB::select('CALL GetTotalViewsForProfile(?)', [$profileId]);

        // Access the result
        $totalViews = $result[0]->total_views;

        // Return the result as a JSON response
        return response()->json([
            'profile_id' => $profileId,
            'total_views' => $totalViews,
        ]);
    }
}