<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AccountController extends Controller
{
    /**
     * Login a user and return a token.
     */
    public function login(Request $request)
{
    try {
        $credentials = $request->only('email', 'password');

        // Validate input
        $validator = Validator::make($credentials, [
            'email' => 'required|email',
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Fetch user from the database
        $user = DB::table('Account')->where('email', $credentials['email'])->first();

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        // Verify the password
        if (!Hash::check($credentials['password'], $user->hashed_password)) {
            return response()->json(['error' => 'Invalid password'], 401);
        }

        // Generate a token
        $token = bin2hex(random_bytes(40));

        // Store the token in the database
        DB::table('tokens')->insert([
            'account_id' => $user->account_id,
            'token' => $token,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json([
            'token' => $token,
            'user' => [
                'account_id' => $user->account_id,
                'email' => $user->email,
                'subscription_id' => $user->subscription_id,
                'billed_from' => $user->billed_from,
            ],
            'message' => 'Login successful',
        ], 200);
    } catch (\Exception $e) {
        \Log::error('Login Error: ' . $e->getMessage());
        return response()->json(['error' => 'Internal Server Error'], 500);
    }
}

    /**
     * Register a new user.
     */
    public function register(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required|string|email|max:255|unique:Account,email',
                'password' => 'required|string|min:8|confirmed',
                'billed_from' => 'required|date',
                'subscription_id' => 'required|integer|exists:Subscription,subscription_id',
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            // Hash the password
            $hashedPassword = Hash::make($request->password);

            // Create the user in the database
            $accountId = DB::table('Account')->insertGetId([
                'email' => $request->email,
                'hashed_password' => $hashedPassword,
                'billed_from' => $request->billed_from,
                'subscription_id' => $request->subscription_id,
                'blocked' => 0,
                'discount_active' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return response()->json([
                'message' => 'User registered successfully.',
                'account_id' => $accountId,
            ], 201);
        } catch (\Exception $e) {
            \Log::error('Register Error: ' . $e->getMessage());
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }

    /**
     * Logout a user by revoking their token.
     */
    public function logout(Request $request)
    {
        try {
            // Retrieve the bearer token from the request
            $token = $request->bearerToken();

            // If no token is provided, return a 400 response
            if (!$token) {
                return response()->json(['error' => 'No token provided'], 400);
            }

            // Check if the token exists in the database
            $tokenExists = DB::table('tokens')->where('token', $token)->exists();

            if (!$tokenExists) {
                return response()->json(['error' => 'Token not found or invalid'], 401);
            }

            // Delete the token from the database
            $deleted = DB::table('tokens')->where('token', $token)->delete();

            if ($deleted) {
                return response()->json(['message' => 'Logged out successfully'], 200);
            } else {
                return response()->json(['error' => 'Failed to log out'], 500);
            }
        } catch (\Exception $e) {
            \Log::error('Logout Error: ' . $e->getMessage());
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }


    /**
     * Reset a user's password.
     */
    public function resetPassword(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required|string|email',
                'password' => 'required|string|min:8|confirmed',
                'token' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            // Validate the reset token
            $resetRequest = DB::table('password_resets')->where([
                'email' => $request->email,
                'token' => $request->token,
            ])->first();

            if (!$resetRequest) {
                return response()->json(['error' => 'Invalid token or email'], 400);
            }

            // Update the password
            DB::table('Account')->where('email', $request->email)->update([
                'hashed_password' => Hash::make($request->password),
            ]);

            // Delete the reset token
            DB::table('password_resets')->where('email', $request->email)->delete();

            return response()->json(['message' => 'Password reset successfully'], 200);
        } catch (\Exception $e) {
            \Log::error('Reset Password Error: ' . $e->getMessage());
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }

    /**
     * Block an account by its ID.
     */
    public function blockAccount($id)
{
    try {
        // Check if the account exists
        $account = DB::table('Account')->where('account_id', $id)->first();

        if (!$account) {
            return response()->json(['message' => 'Account not found'], 404);
        }

        // Check if the account is already blocked
        if ($account->blocked == 1) {
            return response()->json(['message' => 'Account is already blocked'], 200);
        }

        // Update the account to set it as blocked
        $updated = DB::table('Account')->where('account_id', $id)->update(['blocked' => 1]);

        if ($updated) {
            return response()->json(['message' => 'Account blocked successfully'], 200);
        }

        return response()->json(['error' => 'Failed to block the account'], 500);
    } catch (\Exception $e) {
        \Log::error('Block Account Error: ' . $e->getMessage());
        return response()->json(['error' => 'Internal Server Error'], 500);
    }
}



}
