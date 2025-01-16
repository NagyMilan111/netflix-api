<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TokenController extends Controller
{
    /**
     * Generate a token for a user.
     */
    public function generateToken(Request $request)
    {
        $userId = $request->get('userId');
        // Check if the user exists
        $user = DB::select('SELECT * FROM Get_Account_Id WHERE account_id = ?', [$userId]);

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        } else {

            // Generate a unique token
            $token = bin2hex(random_bytes(40));

            // Insert the token into the database
            $result = DB::select('CALL Insert_Token(?, ?)', [$userId, $token]);

            if ($result[0] == 'Token inserted successfully.') {
                return response()->json(['token' => $token], 200);
            }
            else{
                return response()->json(['error' => 'Something went wrong.'], 500);
            }
        }
    }

    /**
     * Refresh a user's token.
     */
    public function refreshToken(Request $request)
    {
        $currentToken = $request->bearerToken();

        if (!$currentToken) {
            return response()->json(['error' => 'No token provided.'], 400);
        }

        // Fetch the current token from the database
        $tokenRecord = DB::select('SELECT * FROM Get_Token WHERE token = ?', [$currentToken]);

        if ($tokenRecord[1] != null) {
            return response()->json(['error' => 'Invalid token.'], 401);
        }

        // Generate a new token
        $newToken = bin2hex(random_bytes(40));

        // Update the token in the database
        $result = DB::select('CALL Update_Token(?, ?)', [$currentToken, $newToken]);
        if($result[0] == 'Token updated successfully.') {
            return response()->json(['token' => $newToken], 200);
        }
        else{
            return response()->json(['error' => 'Something went wrong.'], 500);
        }
    }

    /**
     * Revoke a user's token.
     */
    public function revokeToken(Request $request)
    {
        $currentToken = $request->bearerToken();

        if (!$currentToken) {
            return response()->json(['error' => 'No token provided'], 400);
        }

        // Delete the token from the database
        $result = DB::select('CALL Delete_Token(?)', [$currentToken]);

        if ($result[0] == 'Token deleted successfully.') {
            return response()->json(['message' => 'Token deleted successfully.'], 200);
        }
        else {
            return response()->json(['error' => 'Token not found'], 404);
        }

    }

    /**
     * Validate a token.
     */
    public function validateToken(Request $request)
    {
        $currentToken = $request->bearerToken();

        if (!$currentToken) {
            return response()->json(['error' => 'No token provided'], 400);
        }

        // Check if the token exists in the database
        $isValid = DB::select('SELECT * FROM Get_Token WHERE token = ?', [$currentToken]);
        if($isValid[0] != null) {
            return response()->json(['valid' => $isValid], 200);
        }
        else{
            return response()->json(['error' => 'Token not found.'], 404);
        }
    }
}
