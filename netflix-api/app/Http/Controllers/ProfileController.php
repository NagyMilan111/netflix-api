<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{

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
     * Get a user's watchlist.
     */
    public function getToWatchList(Request $request)
    {

        $profile_id = $request->input('profile_id');
        // Fetch watchlist for the given account
        $toWatch = DB::select('CALL Get_Watch_List(?)', [$profile_id]);
        if($toWatch != null) {
            return response()->json(['watchHistory' => $toWatch], 200);
        }
        else {
            return response()->json(['error' => 'Watch List not found.'], 404);
        }

    }

    /**
     * Manage a user's watchlist (add or remove media).
     */
    public function manageWatchList($mediaId, $seriesId, Request $request)
    {
        // Validate input
        $validatedData = $request->validate([
            'profile_id' => 'required|integer|exists:Profile,profile_id',
            'action' => 'required|in:add,remove',
        ]);

        if ($validatedData['action'] === 'add') {
            // Add media to the watchlist
            $result = DB::select('CALL Insert_Into_Watch_List(?, ?, ?)', [$validatedData['profile_id'], $mediaId, $seriesId]);
            if($result[0] == 'Row inserted into Profile_Watch_List successfully.') {
                return response()->json(['message' => 'Media added to watchlist.']);
            }
            else
            {
                return response()->json(['message' => 'Something went wrong'], 500);
            }
        } else {
            // Remove media from the watchlist
            $result = DB::select('CALL Delete_From_Profile_Watch_List(?, ?, ?)', [$validatedData['profile_id'], $mediaId, $seriesId]);

            if($result[0] == 'Row deleted from Profile_Watch_List successfully.') {
                return response()->json([
                    'message' => 'Media removed from watchlist.'
                ]);
            }
            else
            {
                return response()->json(['message' => 'Something went wrong.'], 500);
            }
        }
    }

}
