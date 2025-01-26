<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{

    /**
     * Update preferences for a profile.
     */

    /*TODO: This will give an error if we try to update the field with false, if the field is already false (same goes for true).
    Procedure has to be fixed to account for this. */

    public function updatePreferences(Request $request)
    {

        $profile_id = $request->input('profile_id');
        $movies_preferred = $request->input('movies_preferred');

        DB::select('CALL Update_Profile_Preferences(?, ?, @message)', [$profile_id, $movies_preferred]);
        $result = DB::select('SELECT @message as message')[0];
        $message = $result->message;

        if ($message == 'Preferences updated successfully.') {
            return response()->json(['message' => 'Preferences updated successfully.'], 200);

        } else if ($message == 'Failed to update preferences.') {
            return response()->json(['error' => 'Failed to update preferences.'], 500);
        }
        else {
            return response()->json(['message' => $message], 404);
        }
    }

    /**
     * Get a user's watchlist.
     */

    //TODO: This returns null right now, fix the stored procedure for it
    public function getToWatchList(Request $request)
    {

        $profile_id = $request->input('profile_id');
        // Fetch watchlist for the given account
        DB::select('CALL Get_Watch_List(?, @message)', [$profile_id]);

        $result = DB::select('SELECT @message as message')[0];
        $message = $result->message;

        if($message != 'No watchlist found for this profile.') {
            return response()->json(['watchList' => $message], 200);
        }
        else {
            return response()->json(['error' => 'Watch List not found.'], 404);
        }

    }

    /**
     * Manage a user's watchlist (add or remove media).
     */
    public function manageWatchList(Request $request)
    {
        // Validate input
        $validatedData = $request->validate([
            'action' => 'required|in:add,remove',
        ]);

        $media_id = $request->input('media_id');
        $series_id = $request->input('series_id');
        $profile_id = $request->input('profile_id');

        if ($validatedData['action'] == 'add') {
            // Add media to the watchlist
            DB::select('CALL Insert_Into_Profile_Watch_List(?, ?, ?, @message)', [$profile_id, $media_id, $series_id]);
            $result = DB::select('SELECT @message as message')[0];
            $message = $result->message;

            if($message == 'Row inserted into Profile_Watch_List successfully.') {
                return response()->json(['message' => 'Media added to watchlist.']);
            }
            else
            {
                return response()->json(['message' => 'Something went wrong.'], 500);
            }
        } else {
            // Remove media from the watchlist
            DB::select('CALL Delete_From_Profile_Watch_List(?, ?, ?, @message)', [$profile_id, $media_id, $series_id]);

            $result = DB::select('SELECT @message as message')[0];
            $message = $result->message;

            if($message == 'Row deleted from Profile_Watch_List successfully.') {
                return response()->json([
                    'message' => 'Media removed from watchlist.'
                ]);
            }
            else
            {
                return response()->json(['message' => $message], 404);
            }
        }
    }

}
