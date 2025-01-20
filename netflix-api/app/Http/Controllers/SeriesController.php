<?php

namespace App\Http\Controllers;

use App\Models\Series;
use Illuminate\Http\Request;

class SeriesController extends Controller
{
    // List all series
    public function index()
    {
        $series = Series::all();
        return response()->json($series);
    }

    // Show a specific series
    public function show($id)
    {
        $series = Series::find($id);

        if (!$series) {
            return response()->json(['message' => 'Series not found'], 404);
        }

        return response()->json($series);
    }

    // Create a new series
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'genre_id' => 'required|exists:genres,genre_id', // Updated to match the genres table's column
            'number_of_seasons' => 'required|integer|min:1',
        ]);

        $series = Series::create($request->all());
        return response()->json($series, 201);
    }

    // Update an existing series
    public function update(Request $request, $id)
    {
        $series = Series::find($id);

        if (!$series) {
            return response()->json(['message' => 'Series not found'], 404);
        }

        $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'genre_id' => 'sometimes|required|exists:genres,genre_id', // Updated validation
            'number_of_seasons' => 'sometimes|required|integer|min:1',
        ]);

        $series->update($request->all());
        return response()->json($series);
    }

    // Delete a series
    public function destroy($id)
    {
        $series = Series::find($id);

        if (!$series) {
            return response()->json(['message' => 'Series not found'], 404);
        }

        $series->delete();
        return response()->json(['message' => 'Series deleted successfully']);
    }
}
