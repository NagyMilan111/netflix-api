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
            $message = $result->message;
            $input_media_id = $result->input_media_id;

            if ($message == 'Media is playing.') {
                return $this->respond(['message' => $message, 'media_id' => $input_media_id], $request, 200);
            } else {
                return $this->respond(['message' => $message, 'media_id' => $input_media_id], $request, 404);
            }
        } catch (\Exception $e) {
            return $this->respond(['message' => $e], $request, 500);
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
                return $this->respond(['error' => $msg], $request, 404);
            }
            else {
                return $this->respond(['message' => 'Media paused.', 'pause_spot' => $pause_spot], $request, 200);
            }
        } catch (\Exception $e) {
            return $this->respond(['message' => $e], $request, 500);
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
                return $this->respond(['error' => $msg], $request, 404);
            } else {
                return $this->respond(['message' => 'Media resumed.', 'resume_at' => $resume_at], $request, 200);
            }
        }
        catch (\Exception $e) {
            return $this->respond(['message' => $e], $request, 500);
        }
    }
}
