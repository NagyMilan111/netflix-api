<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MediaController extends Controller
{
    /**
     * Play media.
     */
    public function playMedia($id, Request $request)
    {
        // Validate that media exists
        $media = DB::select('SELECT * FROM Media WHERE media_id = ?', [$id]);

        if (!$media) {
            return response()->json(['error' => 'Media not found'], 404);
        }

        // Log play action (for analytics or user tracking)
        DB::insert('
            INSERT INTO Profile_Watched_Media (profile_id, media_id, pause_spot, times_watched, last_watch_date)
            VALUES (?, ?, "00:00:00", 1, NOW())
            ON DUPLICATE KEY UPDATE 
                times_watched = times_watched + 1, 
                last_watch_date = NOW(), 
                pause_spot = "00:00:00"
        ', [
            $request->profile_id, // Assume profile_id is sent in the request
            $id,
        ]);

        return response()->json(['message' => 'Media is playing', 'media_id' => $id]);
    }

    /**
     * Pause media.
     */
    public function pauseMedia($id, Request $request)
    {
        // Validate input
        $validatedData = $request->validate([
            'profile_id' => 'required|integer|exists:Profile,profile_id',
            'pause_spot' => 'required|string',
        ]);

        // Update pause spot for the given media
        $updated = DB::update('
            UPDATE Profile_Watched_Media 
            SET pause_spot = ? 
            WHERE profile_id = ? AND media_id = ?
        ', [
            $validatedData['pause_spot'],
            $validatedData['profile_id'],
            $id,
        ]);

        if (!$updated) {
            return response()->json(['error' => 'Failed to update pause spot or media not found'], 404);
        }

        return response()->json(['message' => 'Media paused', 'pause_spot' => $validatedData['pause_spot']]);
    }

    /**
     * Resume media.
     */
    public function resumeMedia($id, Request $request)
    {
        // Validate that the media exists
        $media = DB::select('SELECT * FROM Media WHERE media_id = ?', [$id]);

        if (!$media) {
            return response()->json(['error' => 'Media not found'], 404);
        }

        // Fetch the last pause spot
        $watchData = DB::select('
            SELECT pause_spot FROM Profile_Watched_Media 
            WHERE profile_id = ? AND media_id = ?
        ', [
            $request->profile_id, // Assume profile_id is sent in the request
            $id,
        ]);

        if (!$watchData) {
            return response()->json(['error' => 'No watch data found for the profile and media'], 404);
        }

        $pauseSpot = $watchData[0]->pause_spot;

        return response()->json(['message' => 'Media resumed', 'resume_at' => $pauseSpot]);
    }
}
?>