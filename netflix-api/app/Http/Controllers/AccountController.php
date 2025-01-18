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

            // Call the stored procedure
            DB::select('CALL User_Login(?, ?, @message, @account_id)', [$email, $password]);

            // Retrieve both OUT parameters in a single query
            $outParams = DB::select('SELECT @message AS message, @account_id AS account_id')[0];

            // Access the OUT parameters
            $message = $outParams->message;
            $account_id = $outParams->account_id;


            // Use $userId as needed
            if ($message == 'User login successful.') {
                return response()->json(['success' => $message, 'account_id' => $account_id], 200);
            }
            if ($message == 'User not found.') {
                return response()->json(['error' => $message], 404);
            }

            // Verify the password
            if ($message == 'Incorrect password.') {
                return response()->json(['error' => $message], 401);
            }

            if ($message == 'User is blocked.') {
                return response()->json(['error' => $message], 401);
            }
            // Generate a token
            $token = bin2hex(random_bytes(40));
            /*
                        // Store the token in the database
                        $insertTokenResult = DB::select('CALL Insert_Token(?, ?, @message)', [$result[1], $token]);
                        if($insertTokenResult[0] == 'Token inserted successfully.') {
                            return response()->json([
                                'token' => $token,
                                'user' => [
                                    'account_id' => $result[1],
                                    'email' => $email
                                ],
                                'message' => 'Login successful.',
                            ], 200);
                        }
                        else {
                            return response()->json(['error' => 'Failed to add token.'], 500);
                        }
            */
        } catch (\Exception $e) {
            \Log::error('Login Error: ' . $e->getMessage());
            return response()->json(['error' => 'Internal Server Error.'], 500);
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
                'password' => 'required|string|min:8',
                'subscription_id' => 'required|integer|exists:Subscription,subscription_id',
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            // Hash the password
            $hashedPassword = Hash::make($request->password);
            $subscriptionId = $request->input('subscription_id');
            $email = $request->input('email');

            $result = DB::select('CALL Register_User(?, ?, ?, @a)', [$email, $hashedPassword, $subscriptionId]);
            if ($result[0] == 'User registered successfully.') {
                return response()->json([
                    'message' => 'User registered successfully.',
                ], 201);
            } elseif ($result[0] == 'Email already exists.') {
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
                return response()->json(['error' => 'No token provided.'], 400);
            }

            // Check if the token exists in the database
            $tokenExists = DB::select('SELECT * FROM Get_Token WHERE token = ?', [$token]);

            if (!$tokenExists) {
                return response()->json(['error' => 'Token not found or invalid'], 401);
            }

            // Delete the token from the database
            $deleted = DB::select('CALL Delete_Token(?)', [$token]);

            if ($deleted[0] == 'Token deleted successfully.') {
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
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            $password = $request->input('password');
            $email = $request->input('email');

            $password = Crypt::encrypt($password);
            //Make this work with tokens somehow
            $result = DB::select('CALL Update_Password(?, ?)', $email, $password);
            if ($result[0] == 'Password updated successfully.') {
                return response()->json(['message' => $result[0]], 200);
            } else {
                return response()->json(['error' => $result[0]], 404);
            }

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
            $result = DB::select('CALL Block_User(?)', $email);

            if ($result[0] == 'User successfully blocked.') {
                return response()->json(['message' => $result[0]], 200);
            } elseif ($result[0] == 'User not found.') {
                return response()->json(['error' => $result[0]], 404);
            }

        } catch (\Exception $e) {
            \Log::error('Block Account Error: ' . $e->getMessage());
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }

    /**
     * Delete a profile by its ID.
     */
    public function deleteProfile(Request $request)
    {
        $profile_id = $request->input('profile_id');

        $result = DB::select('CALL Remove_Profile(?)', [$profile_id]);

        if ($result[0] == 'Profile removed successfully.') {
            return response()->json(['message' => $result[0]], 200);
        } else {
            return response()->json(['message' => $result[0]], 404);
        }
    }

    /**
     * Add a new profile for an account.
     */
    public function addProfile(Request $request)
    {
        // Validate the request
        $validatedData = $request->validate([
            'account_id' => 'required|integer|exists:Account,account_id',
            'profile_name' => 'required|string|max:255',
            'profile_age' => 'required|integer|min:1',
            'profile_lang' => 'required|integer|exists:Language,lang_id',
        ]);

        $account_id = $validatedData['account_id'];
        $profile_name = $validatedData['profile_name'];
        $profile_age = $validatedData['profile_age'];
        $profile_lang = $validatedData['profile_lang'];
        $profile_image = $request->input('profile_image');
        $profile_movies_preferred = $request->input('profile_movies_preferred');

        $result = DB::select('CALL Add_Profile(?, ?, ?, ?, ?, ?)', [$account_id, $profile_name, $profile_image,
            $profile_age, $profile_lang, $profile_movies_preferred]);

        if ($result[6] == 'Profile_Added_Successfully') {
            return response()->json(['message' => 'Profile added successfully.'], 201);
        } else {
            return response()->json(['message' => $result[6]], 404);
        }
    }

}
