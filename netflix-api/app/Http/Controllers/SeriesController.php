<?php

namespace App\Http\Controllers;

use App\Models\Series;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SeriesController extends Controller
{
    // List all series
    public function listAllSeries(Request $request)
    {
        try {
            $series = DB::select('SELECT * FROM List_Series');
            if($series != null) {
                return $this->respond(['values' => $series], $request, 200);
            }
            else{
                return $this->respond(['error' => 'No series found.'], $request, 404);
            }
        } catch (\Exception $e) {
            return $this->respond(["message" => "An error occurred while listing series.", "error" => $e], $request, 500);
        }
    }

    // Show a specific series
    public function getSeriesById($id, Request $request)
    {
        try {
            $series = DB::select('SELECT * FROM List_Series WHERE series_id = ?', [$id]);

            if ($series == null) {
                return $this->respond(['message' => 'Series not found'], $request, 404);
            } else {
                return $this->respond(['values' => $series], $request, 200);
            }
        } catch (\Exception $e) {
            return $this->respond(['error' => $e], $request, 500);
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
                return $this->respond(['message' => 'Series inserted successfully.'], $request, 201);
            } else {
                return $this->respond(['message' => $message], $request, 500);
            }
        } catch (\Exception $e) {
            return $this->respond(['error' => $e], $request, 500);
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
                return $this->respond(['message' => 'Series updated successfully.'], $request, 200);
            } elseif ($message == 'Series not found.') {
                return $this->respond(['message' => 'Series not found.'], $request, 404);
            } else {
                return $this->respond(['message' => $message], $request, 500);
            }

        } catch (\Exception $e) {
            return $this->respond(['error' => $e], $request, 500);
        }

    }


    //TODO: Same as above
    // Delete a series
    public function deleteSeries($id, Request $request)
    {
        try {

            DB::select('CALL Delete_Series(?, @message)', [$id]);

            $result = DB::select('SELECT @message as message')[0];
            $message = $result->message;

            if ($message == 'Series deleted successfully.') {
                return $this->respond(['message' => 'Series deleted successfully.'], $request, 200);
            } elseif ($message == 'Series not found.') {
                return $this->respond(['message' => 'Series not found.'], $request, 404);
            } else {
                return $this->respond(['message' => $message], $request, 500);
            }

        } catch (\Exception $e) {
            return $this->respond(['error' => $e], $request, 500);
        }
    }
}
