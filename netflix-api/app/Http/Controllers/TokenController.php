<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TokenController extends Controller
{
    /**
     * Generate a token for a user.
     */
    public function generateToken($id, Request $request)
    {
        try {
            // Check if the user exists
            $user = DB::select('SELECT * FROM Get_Account_Id WHERE account_id = ?', [$id]);

            if ($user == null) {
                return $this->respond(['error' => 'User not found.'], $request, 404);
            } else {

                // Generate a unique token
                $token = bin2hex(random_bytes(40));

                // Insert the token into the database
                DB::select('CALL Insert_Token(?, ?, @message)', [$id, $token]);

                $result = DB::select('Select @message as message')[0];
                $message = $result->message;

                if ($message == 'Token inserted successfully.') {
                    return $this->respond(['message' => $message, 'token' => $token], $request, 201);
                } else {
                    return $this->respond(['error' => 'Something went wrong.'], $request, 500);
                }
            }
        } catch (\Exception $e) {
            return $this->respond(['error' => $e], $request, 500);
        }
    }

    /**
     * Refresh a user's token.
     */
    public function refreshToken(Request $request)
    {
        try {
            $currentToken = $request->bearerToken();

            if (!$currentToken) {
                return $this->respond(['error' => 'No token provided.'], $request, 400);
            }

            // Fetch the current token from the database
            $tokenRecord = DB::select('SELECT * FROM Get_Token WHERE token = ?', [$currentToken]);

            if ($tokenRecord[0] == null) {
                return $this->respond(['error' => 'Invalid token.'], $request, 401);
            }

            // Generate a new token
            $newToken = bin2hex(random_bytes(40));

            // Update the token in the database
            DB::select('CALL Update_Token(?, ?, @message)', [$currentToken, $newToken]);
            $result = DB::select('Select @message as message')[0];
            $message = $result->message;

            if ($message == 'Token updated successfully.') {
                return $this->respond(['message' => $message,'token' => $newToken], $request, 200);
            } else {
                return $this->respond(['error' => 'Something went wrong.'], $request, 500);
            }
        } catch (\Exception $e) {
            return $this->respond(['error' => $e], $request, 500);
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
                return $this->respond(['error' => 'No token provided.'], $request, 400);
            }

            // Delete the token from the database
            DB::select('CALL Delete_Token(?, @message)', [$currentToken]);

            $result = DB::select('Select @message as message')[0];
            $message = $result->message;

            if ($message == 'Token deleted successfully.') {
                return $this->respond(['message' => 'Token deleted successfully.'], $request, 200);
            } else {
                return $this->respond(['error' => 'Token not found.'], $request, 404);
            }
        } catch (\Exception $e) {
            return $this->respond(['error' => $e], $request, 500);
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
                return $this->respond(['error' => 'No token provided'], $request, 400);
            }

            // Check if the token exists in the database
            $isValid = DB::select('SELECT * FROM Get_Token WHERE token = ?', [$currentToken]);
            if ($isValid[1] != null) {
                return $this->respond(['message' => 'Token is valid.', 'token' => $isValid[1]], $request, 200);
            } else {
                return $this->respond(['error' => 'Token not found.'], $request, 404);
            }
        } catch (\Exception $e) {
            return $this->respond(['error' => $e], $request, 500);
        }
    }
}
