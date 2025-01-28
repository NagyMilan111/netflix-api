<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TokenController extends Controller
{
    /**
     * Generate a token for a user.
     */
    public function generateToken($id)
    {
        try {
            // Check if the user exists
            $user = DB::select('SELECT * FROM Get_Account_Id WHERE account_id = ?', [$id]);

            if ($user == null) {
                return response()->json(['error' => 'User not found'], 404);
            } else {

                // Generate a unique token
                $token = bin2hex(random_bytes(40));

                // Insert the token into the database
                DB::select('CALL Insert_Token(?, ?, @message)', [$id, $token]);

                $result = DB::select('Select @message as message')[0];
                $message = $result->message;

                if ($message == 'Token inserted successfully.') {
                    return response()->json(['token' => $token], 200);
                } else {
                    return response()->json(['error' => 'Something went wrong.'], 500);
                }
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e], 500);
        }
    }

    /**
     * Refresh a user's token.
     */
    //TODO: Find out how to put tokens in the headers in postman requests to test this correctly
    public function refreshToken(Request $request)
    {
        try {
            $currentToken = $request->bearerToken();

            if (!$currentToken) {
                return response()->json(['error' => 'No token provided.'], 400);
            }

            // Fetch the current token from the database
            $tokenRecord = DB::select('SELECT * FROM Get_Token WHERE token = ?', [$currentToken]);

            if ($tokenRecord[0] == null) {
                return response()->json(['error' => 'Invalid token.'], 401);
            }

            // Generate a new token
            $newToken = bin2hex(random_bytes(40));

            // Update the token in the database
            DB::select('CALL Update_Token(?, ?, @message)', [$currentToken, $newToken]);
            $result = DB::select('Select @message as message')[0];
            $message = $result->message;

            if ($message == 'Token updated successfully.') {
                return response()->json(['token' => $newToken], 200);
            } else {
                return response()->json(['error' => 'Something went wrong.'], 500);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e], 500);
        }
    }

    /**
     * Revoke a user's token.
     */


    public function revokeToken(Request $request)
    {
        try {
            $currentToken = $request->bearerToken();

            if (!$currentToken) {
                return response()->json(['error' => 'No token provided.'], 400);
            }

            // Delete the token from the database
            DB::select('CALL Delete_Token(?, @message)', [$currentToken]);

            $result = DB::select('Select @message as message')[0];
            $message = $result->message;

            if ($message == 'Token deleted successfully.') {
                return response()->json(['message' => 'Token deleted successfully.'], 200);
            } else {
                return response()->json(['error' => 'Token not found.'], 404);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e], 500);
        }
    }

    /**
     * Validate a token.
     */
    public function validateToken(Request $request)
    {
        try {
            $currentToken = $request->bearerToken();

            if (!$currentToken) {
                return response()->json(['error' => 'No token provided'], 400);
            }

            // Check if the token exists in the database
            $isValid = DB::select('SELECT * FROM Get_Token WHERE token = ?', [$currentToken]);
            if ($isValid[0] != null) {
                return response()->json(['valid' => $isValid], 200);
            } else {
                return response()->json(['error' => 'Token not found.'], 404);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e], 500);
        }
    }
}
