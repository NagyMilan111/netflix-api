<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{

    /**
     * Update preferences for a profile.
     */

    public function updatePreferences(Request $request, $id)
    {
        try {

            $validator = Validator::make($request->all(), [
                'movies_preferred' => 'required|integer|'
            ]);

            if ($validator->fails()) {
                return $this->respond(['error' => $validator->errors()], $request, 400);
            }

            $movies_preferred = $request->input('movies_preferred');

            DB::select('CALL Update_Profile_Preferences(?, ?, @message)', [$id, $movies_preferred]);
            $result = DB::select('SELECT @message as message')[0];
            $message = $result->message;

            if ($message == 'Preferences updated successfully.') {
                return $this->respond(['message' => 'Preferences updated successfully.'], $request, 200);
            } else if ($message == 'Failed to update preferences.') {
                return $this->respond(['error' => 'Failed to update preferences.'], $request, 500);
            } else if ($message == 'Profile not found.') {
                return $this->respond(['error' => $message], $request, 404);
            } else {
                return $this->respond(['error' => $message], $request, 400);
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
            $validator = Validator::make($request->all(), [
                'media_id' => 'required|integer|min:1',
                'series_id' => 'required|integer|min:1',
            ]);

            if($validator->fails()) {
                return $this->respond(['error' => $validator->errors()], $request, 400);
            }

            $media_id = $request->input('media_id');
            $series_id = $request->input('series_id');

            $action = $request->input('action');
            $validActions = ['add', 'remove'];

            if (in_array($action, $validActions)) {
                // Add media to the watchlist
                DB::select('CALL Update_Profile_Watch_List(?, ?, ?, ?, @message)', [$id, $media_id, $series_id, $action]);
                $result = DB::select('SELECT @message as message')[0];
                $message = $result->message;

                if ($message == 'Media added to watch list successfully.') {
                    return $this->respond(['message' => $message], $request, 201);
                } else if ($message == 'Media removed from watch list successfully.'){
                    return $this->respond(['message' => $message], $request, 200);
                } else if ($message == 'Media not found.' || $message == 'Profile not found.' || $message == 'Series not found.') {
                    return $this->respond(['error' => $message], $request, 404);
                }
                else {
                    return $this->respond(['error' => 'An error occurred while updating the watch list'], $request, 500);
                }
            } else {
                return $this->respond(['error' => 'Invalid action.'], $request, 400);
            }
        } catch (\Exception $e) {
            return $this->respond(['error' => $e], $request, 500);
        }
    }

    public function updateViewClassifications(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'classification_id' => 'required|integer|min:1',
            ]);

            if($validator->fails()) {
                return $this->respond(['error' => $validator->errors()], $request, 400);
            }

            $classificationId = $request->input('classification_id');
            $action = $request->input('action');
            $validActions = ['add', 'remove'];

            if(in_array($action, $validActions)) {
                DB::select('CALL Update_Profile_Viewing_Classification(?, ?, ?, @message)', [$id, $classificationId, $action]);
                $result = DB::select('SELECT @message a s message')[0];
                $message = $result->message;

                if($message == 'Profile not found.' || $message == 'Viewing classification not found.') {
                    return $this->respond(['error' => $message], $request, 404);
                }
                else if ($message == 'Failed to remove viewing classification.' || $message == 'Failed to add viewing classification.') {
                    return $this->respond(['error' => $message], $request, 500);
                }
                else if($message == 'Viewing classification added successfully.'){
                    return $this->respond(['message' => $message], $request, 201);
                }
                else {
                    return $this->respond(['message' => $message], $request, 200);
                }
            }
            else {
                return $this->respond(['error' => 'Invalid action.'], $request, 400);
            }
        } catch(\Exception $e) {
            return $this->respond(['error' => $e], $request, 500);
        }

    }

}
