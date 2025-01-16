<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TokenController extends Controller
{
    /**
     * Generate a token for a user.
     */
    public function generateToken($userId)
    {
        // Check if the user exists
        $user = DB::table('Account')->where('account_id', $userId)->first();

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        // Generate a unique token
        $token = bin2hex(random_bytes(40));

        // Insert the token into the database
        DB::table('tokens')->insert([
            'account_id' => $userId,
            'token' => $token,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json(['token' => $token], 200);
    }

    /**
     * Refresh a user's token.
     */
    public function refreshToken(Request $request)
    {
        $currentToken = $request->bearerToken();

        if (!$currentToken) {
            return response()->json(['error' => 'No token provided'], 400);
        }

        // Fetch the current token from the database
        $tokenRecord = DB::table('tokens')->where('token', $currentToken)->first();

        if (!$tokenRecord) {
            return response()->json(['error' => 'Invalid token'], 401);
        }

        // Generate a new token
        $newToken = bin2hex(random_bytes(40));

        // Update the token in the database
        DB::table('tokens')->where('token', $currentToken)->update([
            'token' => $newToken,
            'updated_at' => now(),
        ]);

        return response()->json(['token' => $newToken], 200);
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
        $deleted = DB::table('tokens')->where('token', $currentToken)->delete();

        if (!$deleted) {
            return response()->json(['error' => 'Token not found'], 404);
        }

        return response()->json(['message' => 'Token revoked successfully'], 200);
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
        $isValid = DB::table('tokens')->where('token', $currentToken)->exists();

        return response()->json(['valid' => $isValid], 200);
    }
}
?>