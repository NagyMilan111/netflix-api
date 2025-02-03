<?php

namespace App\Http\Controllers;

use App\Models\Episode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EpisodeController extends Controller
{
    // List all episodes
    public function getAllEpisodes(Request $request)
    {
        try {
            $result = DB::select('SELECT * FROM List_Episodes');

            if ($result == null) {
                return $this->respond(['error' => 'No episodes found.'], $request, 404);
            } else {
                return $this->respond(['values' => $result], $request);
            }
        } catch (\Exception $e) {
            return $this->respond(['error' => $e->getMessage()], $request, 500);
        }
    }

    // Show a specific episode
    public function getEpisodeById($id, Request $request)
    {
        try {
            $result = DB::select('SELECT * FROM List_Episodes WHERE media_id = ?', [$id]);

            if ($result == null) {
                return $this->respond(['error' => 'No episode found with that id.'], $request, 404);
            } else {
                return $this->respond(['values' => $result], $request);
            }
        } catch (\Exception $e) {
            return $this->respond(['error' => $e->getMessage()], $request, 500);
        }
    }

    // Create a new episode
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
                return $this->respond(['message' => $message], $request, 201);
            } else if ($message == 'Failed to insert episode.') {
                return $this->respond(['error' => $message], $request, 500);
            }
            else{
                return $this->respond(['error' => $message], $request, 404);
            }
        } catch (\Exception $e) {
            return $this->respond(['error' => $e->getMessage()], $request, 500);
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

            if ($message == 'Episode not found.' || $message == 'Genre not found.' || $message == 'Series not found.') {
                return $this->respond(['error' => $message], $request, 404);
            } elseif ($message == 'Failed to update episode. No changes made') {
                return $this->respond(['error' => $message], $request, 500);
            } else {
                return $this->respond(['message' => $message], $request, 200);
            }
        } catch (\Exception $e) {
            return $this->respond(['error' => $e->getMessage()], $request, 500);
        }
    }

    // Delete an episode
    public function deleteEpisode($id, Request $request)
    {
        try {
            DB::select('CALL Delete_Episode(?, @message)', [$id]);
            $result = DB::select('SELECT @message as message')[0];
            $message = $result->message;

            if ($message == 'Episode not found.') {
                return $this->respond(['error' => $message], $request, 404);
            } elseif ($message == 'Failed to delete episode.') {
                return $this->respond(['error' => $message], $request, 500);
            } else {
                return $this->respond(['message' => $message], $request, 200);
            }
        } catch (\Exception $e) {
            return $this->respond(['error' => $e->getMessage()], $request, 500);
        }
    }
}
