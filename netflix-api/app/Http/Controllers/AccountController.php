<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Crypt;

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
            $email = $request->input('email');
            $password = $request->input('password');
            $password = Crypt::encrypt($password);

            // Fetch user from the database
            $result = DB::statement('CALL User_Login(?, ?)', $email, $password);
            if ($result == 'User Login Successful') {
                return response()->json(['success' => $request], 200);
            }
            if ($result == 'User not found.') {
                return response()->json(['error' => $request], 404);
            }

            // Verify the password
            if ($result == 'Incorrect password.') {
                return response()->json(['error' => $request], 401);
            }

            if ($result == 'User is blocked.') {
                return response()->json(['error' => $request], 401);
            }
            /*  this should be made into a stored procedure
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
            ], 200); */
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
                'subscription_id' => 'required|integer|exists:Subscription,subscription_id',
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            // Hash the password
            $hashedPassword = Hash::make($request->password);
            $subscriptionId = $request->input('subscription_id');
            $email = $request->input('email');

            $result = DB::statement('CALL Register_User(?, ?, ?)', $email, $hashedPassword, $subscriptionId);
            if ($result == 'User registered successfully.') {
                return response()->json([
                    'message' => 'User registered successfully.',
                ], 201);
            } elseif ($result == 'Email already exists.') {
                return response()->json([
                    'message' => 'Email already exists.',
                ], 401);
            }
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

            $password = $request->input('password');
            $email = $request->input('email');

            $password = Crypt::encrypt($password);
            //Make this work with tokens somehow
            $result = DB::statement('CALL Update_Password(?, ?)', $email, $password);
            if ($result == 'Password updated successfully.') {
                return response()->json(['message' => $result], 200);
            }

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
    public function blockAccount($email)
    {
        try {
            $result = DB::statement('CALL Block_User(?)', $email);

            if ($result == 'User successfully blocked.') {
                return response()->json(['message' => $result], 200);
            } elseif ($result == 'User not found.') {
                return response()->json(['error' => $result], 500);
            }

        } catch (\Exception $e) {
            \Log::error('Block Account Error: ' . $e->getMessage());
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }


}
