<?php

namespace App\Http\Controllers;

use App\Models\Episode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class EpisodeController extends Controller
{
    // List all episodes
    public function getAllEpisodes()
    {
        try {
            $result = DB::select('SELECT * FROM List_Episodes');

            if ($result == null) {
                return response()->json(['error' => 'No episodes found.'], 404);
            } else {
                return response()->json(['values' => $result], 200);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e], 500);
        }
    }

    // Show a specific episode
    public function getEpisodeById($id)
    {
        try {
            $result = DB::select('SELECT * FROM List_Episodes WHERE media_id = ?', [$id]);
            if ($result == null) {
                return response()->json(['error' => 'No episode found with that id.'], 404);
            } else {
                return response()->json(['values' => $result], 200);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e], 500);
        }
    }

    // Create a new episode
    //TODO: Fix the procedure so that it will exit if an episode is not found
    public function addNewEpisode(Request $request)
    {
        try {
            $request->validate([
                'title' => 'required|string|max:255',
                'season' => 'required|integer',
            ]);
            $title = $request->input('title');
            $duration = $request->input('duration');
            $season = $request->input('season');
            $series_id = $request->input('series_id');
            $genre_id = $request->input('genre_id');

            DB::select('CALL Insert_Episode(?, ?, ?, ?, ?, @message)', [$title, $duration, $series_id, $season, $genre_id]);

            $result = DB::select('SELECT @message as message')[0];

            $message = $result->message;

            if ($message == 'Episode inserted successfully.') {
                return response()->json(['message' => $message], 201);
            } else {
                return response()->json(['error' => $message], 500);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e], 500);
        }
    }

    // Update an existing episode
    public function updateEpisode(Request $request, $id)
    {
        try {
            $title = $request->input('title');
            $duration = $request->input('duration');
            $season = $request->input('season');
            $series_id = $request->input('series_id');
            $genre_id = $request->input('genre_id');

            DB::select('CALL Update_Episode(?, ?, ?, ?, ?, ?, @message)', [$id, $title, $duration, $series_id, $season, $genre_id]);
            $result = DB::select('SELECT @message as message')[0];
            $message = $result->message;

            if ($message == 'Episode not found.') {
                return response()->json(['error' => 'Episode not found.'], 404);
            } elseif ($message == 'Failed to update episode.') {
                return response()->json(['error' => 'Failed to update episode.'], 500);
            } else {
                return response()->json(['message' => $message], 200);
            }

        } catch (\Exception $e) {
            return response()->json(['error' => $e], 500);
        }
    }

    // Delete an episode
    public function deleteEpisode($id)
    {
        try {
            DB::select('CALL Delete_Episode(?, @message)', [$id]);
            $result = DB::select('SELECT @message as message')[0];
            $message = $result->message;

            if ($message == 'Episode not found.') {
                return response()->json(['error' => 'Episode not found.'], 404);
            } elseif ($message == 'Failed to delete episode.') {
                return response()->json(['error' => 'Failed to delete episode.'], 500);
            } else {
                return response()->json(['message' => $message], 200);
            }

        } catch (\Exception $e) {
            return response()->json(['error' => $e], 500);
        }
    }
}
