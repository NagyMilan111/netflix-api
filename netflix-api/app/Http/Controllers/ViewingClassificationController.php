<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ViewingClassificationController extends Controller
{
    // List all classifications
    public function getAllClassifications(Request $request)
    {
        try {
            $result = DB::select('SELECT * FROM List_Classifications');

            if ($result == null) {
                return $this->respond(['error' => 'No classifications found.'], $request, 404);
            } else {
                return $this->respond(['values' => $result], $request);
            }
        } catch (\Exception $e) {
            return $this->respond(['error' => $e->getMessage()], $request, 500);
        }
    }

    // Show a specific classification
    public function getClassificationById($id, Request $request)
    {
        try {
            $result = DB::select('SELECT * FROM List_Classifications WHERE classification_id = ?', [$id]);

            if ($result == null) {
                return $this->respond(['error' => 'No classification found with that id.'], $request, 404);
            } else {
                return $this->respond(['values' => $result], $request);
            }
        } catch (\Exception $e) {
            return $this->respond(['error' => $e->getMessage()], $request, 500);
        }
    }

    // Create a new classification
    public function addNewClassification(Request $request)
    {
        try {
            $request->validate([
                'classification' => 'required|string|max:255',
            ]);

            $classification = $request->input('classification');

            DB::select('CALL Insert_Classification(?, @message)', [$classification]);
            $result = DB::select('SELECT @message as message')[0];
            $message = $result->message;

            if ($message == 'Classification inserted successfully.') {
                return $this->respond(['message' => $message], $request, 201);
            } else {
                return $this->respond(['error' => $message], $request, 500);
            }
        } catch (\Exception $e) {
            return $this->respond(['error' => $e->getMessage()], $request, 500);
        }
    }

    // Update an existing classification
    public function updateClassification(Request $request, $id)
{
    try {
        $classification = $request->input('classification');

        // Ensure the value is properly quoted for SQL
        DB::select('CALL Update_Classification(?, ?, @message)', [$id, (string) $classification]);
        
        $result = DB::select('SELECT @message as message')[0];
        $message = $result->message;

        if ($message == 'Classification not found.') {
            return $this->respond(['error' => $message], $request, 404);
        } elseif ($message == 'Failed to update classification. No changes made.') {
            return $this->respond(['error' => $message], $request, 500);
        } else {
            return $this->respond(['message' => $message], $request, 200);
        }
    } catch (\Exception $e) {
        return $this->respond(['error' => $e->getMessage()], $request, 500);
    }
}


    // Delete an episode
    public function deleteClassification($id, Request $request)
    {
        try {
            DB::select('CALL Delete_Classification(?, @message)', [$id]);
            $result = DB::select('SELECT @message as message')[0];
            $message = $result->message;

            if ($message == 'Classification not found.') {
                return $this->respond(['error' => $message], $request, 404);
            } elseif ($message == 'Failed to delete classification.') {
                return $this->respond(['error' => $message], $request, 500);
            } else {
                return $this->respond(['message' => $message], $request, 200);
            }
        } catch (\Exception $e) {
            return $this->respond(['error' => $e->getMessage()], $request, 500);
        }
    }
}
