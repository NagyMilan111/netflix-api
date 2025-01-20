<?php

namespace App\Http\Controllers;

use App\Models\Episode;
use Illuminate\Http\Request;

class EpisodeController extends Controller
{
    // List all episodes
    public function index()
    {
        $episodes = Episode::all();
        return response()->json($episodes);
    }

    // Show a specific episode
    public function show($id)
    {
        $episode = Episode::find($id);

        if (!$episode) {
            return response()->json(['message' => 'Episode not found'], 404);
        }

        return response()->json($episode);
    }

    // Create a new episode
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'release_date' => 'required|date',
            'duration' => 'nullable',
            'series_id' => 'required|exists:series,id',
        ]);

        $episode = Episode::create($request->all());
        return response()->json($episode, 201);
    }

    // Update an existing episode
    public function update(Request $request, $id)
    {
        $episode = Episode::find($id);

        if (!$episode) {
            return response()->json(['message' => 'Episode not found'], 404);
        }

        $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'release_date' => 'sometimes|required|date',
            'duration' => 'nullable',
            'series_id' => 'sometimes|required|exists:series,id',
        ]);

        $episode->update($request->all());
        return response()->json($episode);
    }

    // Delete an episode
    public function destroy($id)
    {
        $episode = Episode::find($id);

        if (!$episode) {
            return response()->json(['message' => 'Episode not found'], 404);
        }

        $episode->delete();
        return response()->json(['message' => 'Episode deleted successfully']);
    }
}
