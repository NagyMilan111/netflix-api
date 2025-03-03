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
        $media = DB::table('Media')->where('media_id', $id)->first();

        if (!$media) {
            return response()->json(['error' => 'Media not found'], 404);
        }

        // Logic to log play action
        DB::table('Profile_Watched_Media')->updateOrInsert(
            [
                'profile_id' => $request->profile_id,
                'media_id' => $id,
            ],
            [
                'pause_spot' => '00:00:00',
                'times_watched' => DB::raw('times_watched + 1'),
                'last_watch_date' => now(),
            ]
        );

        return response()->json(['message' => 'Media is playing', 'media_id' => $id]);
    }


    /**
     * Pause media.
     */
    public function pauseMedia($id, Request $request)
    {
        $validatedData = $request->validate([
            'profile_id' => 'required|integer|exists:Profile,profile_id',
            'pause_spot' => 'required|string',
        ]);

        // Update pause spot for the given media
        $updated = DB::table('Profile_Watched_Media')->where([
            'profile_id' => $validatedData['profile_id'],
            'media_id' => $id,
        ])->update(['pause_spot' => $validatedData['pause_spot']]);

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
        $media = DB::table('Media')->where('media_id', $id)->first();

        if (!$media) {
            return response()->json(['error' => 'Media not found'], 404);
        }

        // Fetch the last pause spot
        $watchData = DB::table('Profile_Watched_Media')->where([
            'profile_id' => $request->profile_id,
            'media_id' => $id,
        ])->first();

        if (!$watchData) {
            return response()->json(['error' => 'No watch data found for the profile and media'], 404);
        }

        return response()->json(['message' => 'Media resumed', 'resume_at' => $watchData->pause_spot]);
    }
}
