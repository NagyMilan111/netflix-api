<?php

namespace App\Http\Controllers;

use App\Models\Series;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SeriesController extends Controller
{
    // List all series
    public function listAllSeries()
    {
        try {
            $series = DB::select('SELECT * FROM List_Series');
            return response()->json(['values' => $series]);
        } catch (\Exception $e) {
            return response()->json(["message" => "An error occurred while listing series.", "error" => $e], 500);
        }
    }

    // Show a specific series
    public function getSeriesById($id)
    {
        try {
            $series = DB::select('SELECT * FROM List_Series WHERE series_id = ?', [$id]);

            if ($series == null) {
                return response()->json(['message' => 'Series not found'], 404);
            } else {
                return response()->json(['values' => $series]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e], 500);
        }
    }

    // Create a new series
    public function createNewSeries(Request $request)
    {
        try {
            $request->validate([
                'title' => 'required|string|max:255',
                'number_of_seasons' => 'required|integer|min:1',
            ]);

            $title = $request->input('title');
            $number_of_seasons = $request->input('number_of_seasons');
            $genre_id = $request->input('genre_id');

            DB::select('CALL Insert_Series(?, ?, ?, @message)', [$title, $genre_id, $number_of_seasons]);

            $result = DB::select('SELECT @message as message')[0];

            $message = $result->message;

            if ($message == 'Series inserted successfully.') {
                return response()->json(['message' => 'Series inserted successfully.'], 201);
            } else {
                return response()->json(['message' => $message], 500);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e], 500);
        }
    }


    //TODO: Fix the stored procedure for this, currently it will not return 'Series not found.', instead it defaults to the last error msg
    // Update an existing series
    public function updateSeries(Request $request, $id)
    {

        try {
            $request->validate([
                'title' => 'sometimes|required|string|max:255',
                'number_of_seasons' => 'sometimes|required|integer|min:1',
            ]);

            $title = $request->input('title');
            $number_of_seasons = $request->input('number_of_seasons');
            $genre_id = $request->input('genre_id');

            DB::select('CALL Update_Series(?, ?, ?, ?, @message)', [$id, $title, $genre_id, $number_of_seasons]);

            $result = DB::select('SELECT @message as message')[0];
            $message = $result->message;

            if ($message == 'Series updated successfully.') {
                return response()->json(['message' => 'Series updated successfully.'], 200);
            } elseif ($message == 'Series not found.') {
                return response()->json(['message' => 'Series not found.'], 404);
            } else {
                return response()->json(['message' => $message], 500);
            }

        } catch (\Exception $e) {
            return response()->json(['error' => $e], 500);
        }

    }


    //TODO: Same as above
    // Delete a series
    public function deleteSeries($id)
    {
        try {

            DB::select('CALL Delete_Series(?, @message)', [$id]);

            $result = DB::select('SELECT @message as message')[0];
            $message = $result->message;

            if ($message == 'Series deleted successfully.') {
                return response()->json(['message' => 'Series deleted successfully.'], 200);
            } elseif ($message == 'Series not found.') {
                return response()->json(['message' => 'Series not found.'], 404);
            } else {
                return response()->json(['message' => $message], 500);
            }

        } catch (\Exception $e) {
            return response()->json(['error' => $e], 500);
        }
    }
}
