<?php

namespace App\Http\Controllers;

class ProfileController12 extends Controller
{
    public function addProfile(Request $request)
    {
        return response()->json(['message' => 'Profile added']);
    }

    public function updatePreferences(Request $request)
    {
        return response()->json(['message' => 'Preferences updated']);
    }

    public function deleteProfile($id)
    {
        return response()->json(['message' => 'Profile deleted']);
    }
}
