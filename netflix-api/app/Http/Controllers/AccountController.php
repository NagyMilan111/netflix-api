<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class AccountController extends Controller
{
    /**
     * Login a user and return a token.
     */
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        // Validate user credentials
        $user = DB::table('Account')
            ->where('email', $credentials['email'])
            ->first();

        if ($user && Hash::check($credentials['password'], $user->hashed_password)) {
            // Generate token for the user
            $token = bin2hex(random_bytes(40)); // Generate a random token

            // Store the token in the database (you may have a token table)
            DB::table('tokens')->insert([
                'account_id' => $user->account_id,
                'token' => $token,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return response()->json([
                'token' => $token,
                'user' => $user,
                'message' => 'Login successful',
            ], 200);
        }

        return response()->json(['message' => 'Invalid credentials'], 401);
    }

    /**
     * Logout a user by revoking their token.
     */
    public function logout(Request $request)
    {
        $token = $request->bearerToken();

        if ($token) {
            // Delete the token from the database
            DB::table('tokens')->where('token', $token)->delete();

            return response()->json(['message' => 'Logged out successfully'], 200);
        }

        return response()->json(['message' => 'Token not found or invalid'], 401);
    }

    /**
     * Register a new user.
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255|unique:Account,email',
            'password' => 'required|string|min:8|confirmed',
            'billed_from' => 'required|date',
            'subscription_id' => 'required|integer|exists:Subscription,subscription_id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Create a new account in the database
        $accountId = DB::table('Account')->insertGetId([
            'email' => $request->email,
            'hashed_password' => Hash::make($request->password),
            'billed_from' => $request->billed_from,
            'subscription_id' => $request->subscription_id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json([
            'message' => 'User registered successfully.',
            'account_id' => $accountId,
        ], 201);
    }

    /**
     * Reset a user's password.
     */
    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string|min:8|confirmed',
            'token' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Validate reset token (if applicable)
        $resetRequest = DB::table('password_resets')
            ->where('email', $request->email)
            ->where('token', $request->token)
            ->first();

        if (!$resetRequest) {
            return response()->json(['message' => 'Invalid token or email'], 400);
        }

        // Update the password
        DB::table('Account')
            ->where('email', $request->email)
            ->update(['hashed_password' => Hash::make($request->password)]);

        // Delete the reset token
        DB::table('password_resets')->where('email', $request->email)->delete();

        return response()->json(['message' => 'Password reset successfully'], 200);
    }

    /**
     * Block an account by its ID.
     */
    public function blockAccount($id)
    {
        // Check if the account exists
        $account = DB::table('Account')->where('account_id', $id)->first();

        if (!$account) {
            return response()->json(['message' => 'Account not found'], 404);
        }

        // Update the account to set it as blocked
        DB::table('Account')
            ->where('account_id', $id)
            ->update(['blocked' => 1]);

        return response()->json(['message' => 'Account blocked successfully'], 200);
    }
}
?>