<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProfileController12 extends Controller
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
        DB::insert('
            INSERT INTO Profile (account_id, profile_name, profile_image, profile_age, profile_lang, created_at, updated_at)
            VALUES (?, ?, ?, ?, ?, NOW(), NOW())
        ', [
            $validatedData['account_id'],
            $validatedData['profile_name'],
            'placeholder.jpeg', // Default profile image
            $validatedData['profile_age'],
            $validatedData['profile_lang'],
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
        $updated = DB::update('
            UPDATE Profile
            SET profile_movies_preferred = ?, updated_at = NOW()
            WHERE profile_id = ?
        ', [
            $validatedData['profile_movies_preferred'] ?? 0,
            $validatedData['profile_id'],
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
        DB::delete('DELETE FROM Profile WHERE profile_id = ?', [$id]);

        return response()->json(['message' => 'Profile deleted successfully'], 200);
    }
}
?>