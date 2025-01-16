<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\Account;
use App\Models\Language;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    /**
     * Add a new profile for an account.
     */
    public function addProfile(Request $request)
    {
        // Validate the request
        $validatedData = $request->validate([
            'account_id' => 'required|integer|exists:accounts,account_id',
            'profile_name' => 'required|string|max:255',
            'profile_age' => 'required|integer|min:1',
            'profile_lang' => 'required|integer|exists:languages,lang_id',
        ]);
    
        try {
            // Insert the profile into the database using Eloquent
            $profile = Profile::create([
                'account_id' => $validatedData['account_id'],
                'profile_name' => $validatedData['profile_name'],
                'profile_age' => $validatedData['profile_age'],
                'profile_lang' => $validatedData['profile_lang'],
                'profile_movies_preferred' => 0, // Default value
            ]);
    
            return response()->json(['message' => 'Profile added successfully', 'profile' => $profile], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to add profile', 'details' => $e->getMessage()], 500);
        }
    }
    

    /**
     * Update preferences for a profile.
     */
    public function updatePreferences(Request $request)
    {
        // Validate the request
        $validatedData = $request->validate([
            'profile_id' => 'required|integer|exists:profiles,profile_id', // Correct table and column name
            'profile_movies_preferred' => 'nullable|boolean',
        ]);

        try {
            // Fetch the profile and update preferences using Eloquent
            $profile = Profile::find($validatedData['profile_id']);
            
            if (!$profile) {
                return response()->json(['error' => 'Profile not found'], 404);
            }

            // Update preferences in the database
            $profile->update([
                'profile_movies_preferred' => $validatedData['profile_movies_preferred'] ?? 0,
            ]);

            return response()->json(['message' => 'Preferences updated successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update preferences', 'details' => $e->getMessage()], 500);
        }
    }

    /**
     * Delete a profile by its ID.
     */
    public function deleteProfile($id)
    {
        try {
            // Fetch the profile using Eloquent
            $profile = Profile::find($id);

            if (!$profile) {
                return response()->json(['error' => 'Profile not found'], 404);
            }

            // Delete the profile from the database
            $profile->delete();

            return response()->json(['message' => 'Profile deleted successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete profile', 'details' => $e->getMessage()], 500);
        }
    }

    /**
     * Get a profile by its ID.
     */
    public function getProfile($id)
    {
        try {
            // Fetch the profile using Eloquent
            $profile = Profile::find($id);

            if (!$profile) {
                return response()->json(['error' => 'Profile not found'], 404);
            }

            return response()->json(['profile' => $profile], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch profile', 'details' => $e->getMessage()], 500);
        }
    }

    /**
     * List all profiles for an account.
     */
    public function listProfiles(Request $request)
    {
        // Validate the request
        $validatedData = $request->validate([
            'account_id' => 'required|integer|exists:accounts,account_id',
        ]);

        try {
            // Fetch all profiles for the account using Eloquent
            $profiles = Profile::where('account_id', $validatedData['account_id'])->get();

            if ($profiles->isEmpty()) {
                return response()->json(['error' => 'No profiles found for this account'], 404);
            }

            return response()->json(['profiles' => $profiles], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch profiles', 'details' => $e->getMessage()], 500);
        }
    }
}
