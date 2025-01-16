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

        $account_id = $validatedData['account_id'];
        $profile_name = $validatedData['profile_name'];
        $profile_age = $validatedData['profile_age'];
        $profile_lang = $validatedData['profile_lang'];
        $profile_image = $request->input('profile_image');
        $profile_movies_preferred = $request->input('profile_movies_preferred');

        $result = DB::select('CALL Add_Profile(?, ?, ?, ?, ?, ?)', [$account_id, $profile_name, $profile_image,
            $profile_age, $profile_lang, $profile_movies_preferred]);

        if ($result[6] == 'Profile_Added_Successfully') {
            return response()->json(['message' => 'Profile added successfully.'], 201);
        } else {
            return response()->json(['message' => $result[6]], 404);
        }
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

        $result = DB::select('CALL Update_Profile_Preferences(?)', [$request->input('profile_id')]);

        if ($result[0] == 'Preferences updated successfully.') {
            return response()->json(['message' => 'Preferences updated successfully.'], 200);

        } else if ($result[0] == 'Failed to update preferences.') {
            return response()->json(['error' => 'Failed to update preferences.'], 500);
        }
        else {
            return response()->json(['message' => $result[0]], 404);
        }
    }

    /**
     * Delete a profile by its ID.
     */
    public function deleteProfile(Request $request)
    {
        $profile_id = $request->input('profile_id');

        $result = DB::select('CALL Delete_Profile(?)', [$profile_id]);

        if($result[1] == 'Profile removed successfully.') {
            return response()->json(['message' => $result[1]], 200);
        }
        else {
            return response()->json(['message' => $result[1]], 404);
        }
    }
}
