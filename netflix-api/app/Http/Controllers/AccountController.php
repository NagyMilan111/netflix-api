<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Account;
use App\Models\Token;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

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
            $user = Account::where('email', $credentials['email'])->first();

            if (!$user) {
                return response()->json(['error' => 'User not found'], 404);
            }

            // Check if the password is hashed using Bcrypt
            if (!Hash::check($credentials['password'], $user->hashed_password)) {
                // If password is not hashed correctly, rehash and update it
                if (!Hash::check($credentials['password'], $user->hashed_password)) {
                    $user->update([
                        'hashed_password' => Hash::make($credentials['password']),
                    ]);
                }
                return response()->json(['error' => 'Invalid password'], 401);
            }

            // Generate a token
            $token = bin2hex(random_bytes(40));

            // Store the token in the database
            Token::create([
                'account_id' => $user->account_id,
                'token' => $token,
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
            Log::error('Login Error: ' . $e->getMessage());
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
                'email' => 'required|string|email|max:255|unique:accounts,email',
                'password' => 'required|string|min:8|confirmed',
                'billed_from' => 'required|date',
                'subscription_id' => 'required|integer|exists:subscriptions,subscription_id',
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            // Hash the password
            $hashedPassword = Hash::make($request->password);

            // Create the user in the database
            $user = Account::create([
                'email' => $request->email,
                'hashed_password' => $hashedPassword,
                'billed_from' => $request->billed_from,
                'subscription_id' => $request->subscription_id,
                'is_blocked' => 0,
            ]);

            return response()->json([
                'message' => 'User registered successfully.',
                'account_id' => $user->account_id,
            ], 201);
        } catch (\Exception $e) {
            Log::error('Register Error: ' . $e->getMessage());
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }

    /**
     * Logout a user by revoking their token.
     */
    public function logout(Request $request)
    {
        try {
            $currentToken = $request->bearerToken();

            if (!$currentToken) {
                return response()->json(['error' => 'No token provided'], 400);
            }

            // Delete the token from the database
            $deleted = Token::where('token', $currentToken)->delete();

            if ($deleted) {
                return response()->json(['message' => 'Logged out successfully'], 200);
            } else {
                return response()->json(['error' => 'Failed to log out'], 500);
            }
        } catch (\Exception $e) {
            Log::error('Logout Error: ' . $e->getMessage());
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
            Account::where('email', $request->email)->update([
                'hashed_password' => Hash::make($request->password),
            ]);

            // Delete the reset token
            DB::table('password_resets')->where('email', $request->email)->delete();

            return response()->json(['message' => 'Password reset successfully'], 200);
        } catch (\Exception $e) {
            Log::error('Reset Password Error: ' . $e->getMessage());
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }

    /**
     * Block an account by its ID.
     */
    public function blockAccount($id)
    {
        try {
            $account = Account::find($id);

            if (!$account) {
                return response()->json(['message' => 'Account not found'], 404);
            }

            if ($account->is_blocked) {
                return response()->json(['message' => 'Account is already blocked'], 200);
            }

            $account->update(['is_blocked' => 1]);

            return response()->json(['message' => 'Account blocked successfully'], 200);
        } catch (\Exception $e) {
            Log::error('Block Account Error: ' . $e->getMessage());
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }
}
