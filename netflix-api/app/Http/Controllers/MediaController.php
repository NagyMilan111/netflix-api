<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MediaController extends Controller
{
    /**
     * Play media.
     */
    public function playMedia(Request $request, $id)
    {
        try {
            $profile_id = $request->input('profile_id');

            DB::select('CALL Log_Play_Action(?, ?, @message, @input_media_id)', [$profile_id, $id]);

            $result = DB::select('SELECT @message as message, @input_media_id as input_media_id')[0];
            $msg = $result->message;
            $input_media_id = $result->input_media_id;

            if ($msg == 'Media is playing.') {
                return response()->json(['message' => 'Media is playing.', 'media_id' => $input_media_id]);
            } else {
                return response()->json(['message' => $msg, 'media_id' => $input_media_id]);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => $e]);
        }
    }

    /**
     * Pause media.
     */
    public function pauseMedia(Request $request, $id)
    {
        try {
            $profile_id = $request->input('profile_id');
            $pause_spot = $request->input('pause_spot');

            DB::select('CALL Update_Pause_Spot(?, ?, ?, @message, @input_pause_spot)', [$profile_id, $id, $pause_spot]);

            $result = DB::select('SELECT @message as message, @input_pause_spot as input_pause_spot')[0];
            $msg = $result->message;
            $pause_spot = $result->input_pause_spot;


            if ($msg != 'Media paused.') {
                return response()->json(['error' => $msg], 404);
            }
            else {
                return response()->json(['message' => 'Media paused.', 'pause_spot' => $pause_spot], 200);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => $e]);
        }
    }

    /**
     * Resume media.
     */
    public function resumeMedia(Request $request, $id)
    {
        try {
            $profile_id = $request->input('profile_id');

            DB::select('CALL Fetch_Pause_Spot(?, ?, @message, @resume_at)', [$profile_id, $id]);

            $result = DB::select('SELECT @message as message, @resume_at as resume_at')[0];
            $msg = $result->message;
            $resume_at = $result->resume_at;

            if ($msg != 'Media resumed.') {
                return response()->json(['error' => $msg], 404);
            } else {
                return response()->json(['message' => 'Media resumed.', 'resume_at' => $resume_at], 200);
            }
        }
        catch (\Exception $e) {
            return response()->json(['message' => $e]);
        }
    }
}
