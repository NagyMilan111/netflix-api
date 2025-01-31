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
        try {
            $profile_id = $request->input('profile_id');
            $movies_preferred = $request->input('movies_preferred');

            DB::select('CALL Update_Profile_Preferences(?, ?, @message)', [$profile_id, $movies_preferred]);
            $result = DB::select('SELECT @message as message')[0];
            $message = $result->message;

            if ($message == 'Preferences updated successfully.') {
                return $this->respond(['message' => 'Preferences updated successfully.'], $request, 200);

            } else if ($message == 'Failed to update preferences.') {
                return $this->respond(['error' => 'Failed to update preferences.'], $request, 500);
            } else if ($message == 'Profile not found.') {
                return $this->respond(['message' => $message], $request, 404);
            } else {
                return $this->respond(['message' => $message], $request, 400);
            }
        } catch (\Exception $e) {
            return $this->respond(['error' => $e], $request, 500);
        }
    }

    /**
     * Get a user's watchlist.
     */

    public function getToWatchList($id, Request $request)
    {
        try {
            $profile = DB::select('SELECT * FROM Get_Profile_Id WHERE profile_id = ?', [$id]);
            if ($profile == null) {
                return $this->respond(['error' => 'Profile not found.'], $request, 404);
            } else {
                $watchList = DB::select('SELECT * FROM List_Watch_List WHERE profile_id = ?', [$id]);
                if ($watchList == null) {
                    return $this->respond(['error' => 'Profile has no watch list.'], $request, 404);
                }
                else{
                    return $this->respond(['values' => $watchList], $request, 200);
                }
            }

        } catch (\Exception $e) {
            return $this->respond(['error' => $e], $request, 500);
        }

    }

    /**
     * Manage a user's watchlist (add or remove media).
     */
    public function manageWatchList(Request $request, $id)
    {
        try {
            // Validate input
            $validatedData = $request->validate([
                'action' => 'required|in:add,remove',
            ]);

            $media_id = $request->input('media_id');
            $series_id = $request->input('series_id');

            if ($validatedData['action'] == 'add') {
                // Add media to the watchlist
                DB::select('CALL Insert_Into_Profile_Watch_List(?, ?, ?, @message)', [$id, $media_id, $series_id]);
                $result = DB::select('SELECT @message as message')[0];
                $message = $result->message;

                if ($message == 'Row inserted into Profile_Watch_List successfully.') {
                    return $this->respond(['message' => 'Media added to watchlist.'], $request, 201);
                } else {
                    return $this->respond(['message' => 'Something went wrong.'], $request, 500);
                }
            } else {
                // Remove media from the watchlist
                DB::select('CALL Delete_From_Profile_Watch_List(?, ?, ?, @message)', [$id, $media_id, $series_id]);

                $result = DB::select('SELECT @message as message')[0];
                $message = $result->message;

                if ($message == 'Row deleted from Profile_Watch_List successfully.') {
                    return $this->respond([
                        'message' => 'Media removed from watchlist.'
                    ], $request, 200);
                } else {
                    return $this->respond(['message' => $message], $request, 404);
                }
            }
        } catch (\Exception $e) {
            return $this->respond(['error' => $e], $request, 500);
        }
    }

}
