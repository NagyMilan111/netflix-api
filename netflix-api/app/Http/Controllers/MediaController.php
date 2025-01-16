<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MediaController extends Controller
{
    /**
     * Play media.
     */
    public function playMedia(Request $request)
    {
        $profile_id = $request->input('profile_id');
        $media_id = $request->input('media_id');

        $result = DB::select('CALL Log_Play_Action(?, ?)', [$profile_id, $media_id]);
        if ($result[0] == 'Media is playing.') {
            return response()->json(['message' => 'Media is playing.', 'media_id' => $media_id]);
        } else {
            return response()->json(['message' => $result[0], 'media_id' => $media_id]);
        }
    }

    /**
     * Pause media.
     */
    public function pauseMedia(Request $request)
    {
        $validatedData = $request->validate([
            'profile_id' => 'required|integer|exists:Profile,profile_id',
            'media_id' => 'required|integer|exists:Media,media_id',
            'pause_spot' => 'required|string',
        ]);

        $profile_id = $request->input('profile_id');
        $pause_spot = $request->input('pause_spot');
        $media_id = $request->input('media_id');

        $result = DB::select('CALL Update_Pause_Spot(?, ?, ?)', [$profile_id, $media_id, $pause_spot]);

        if ($result[0] != 'Media paused.') {
            return response()->json(['error' => $result[0]], 404);
        }

        return response()->json(['message' => 'Media paused.', 'pause_spot' => $validatedData['pause_spot']]);
    }

    /**
     * Resume media.
     */
    public function resumeMedia(Request $request)
    {
        $profile_id = $request->input('profile_id');
        $media_id = $request->input('media_id');

        $result = DB::select('CALL Fetch_Pause_Spot(?, ?)', [$profile_id, $media_id]);

        if ($result[0] != 'Media resumed.') {
            return response()->json(['error' => $result[0]], 404);
        } else {
            return response()->json(['message' => 'Media resumed.', 'resume_at' => $result[1]]);
        }
    }
}
