<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\RateLimiter;

class AccountController extends Controller
{
    /**
     * Login a user and return a token.
     */

    //TODO: Block account after 3 unsuccessful login attempts
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
                return $this->respond(['error' => $validator->errors()], $request, 400);
            }

            $email = $request->input('email');
            $password = $request->input('password');
            $key = 'login_attempts_' . $email;

            if (RateLimiter::tooManyAttempts($key, 3)) {
                DB::select('CALL Block_User(?, @message)', [$email]);
                $result = DB::select('SELECT @message AS message')[0];
                $message = $result->message;

                if ($message == 'User successfully blocked.') {
                    return $this->respond(['error' => 'Too many login attempts. Please reset your password.'], $request, 429);
                }
                else if ($message == 'User not found.') {
                    return $this->respond(['error' => 'User not found.'], $request, 404);
                }
                else{
                    return $this->respond(['error' => $message], $request, 500);
                }
            }

            DB::select('CALL User_Login(?, @message, @account_id, @hashed_password)', [$email]);

            $outParams = DB::select('SELECT @message AS message, @account_id AS account_id, @hashed_password AS hashed_password')[0];

            $message = $outParams->message;
            $account_id = $outParams->account_id;
            $hashed_password = $outParams->hashed_password;

            if ($message == 'User not found.') {
                return $this->respond(['error' => $message], $request, 404);
            } else if ($message == 'User is blocked.') {
                return $this->respond(['error' => $message], $request, 401);
            } else if ($message == 'Authentication required.') {
                if (!Hash::check($password, $hashed_password)) {
                    RateLimiter::hit($key, 300);
                    return $this->respond(['error' => 'Incorrect password.'], $request, 401);
                } else {

                    // Generate a token
                    $token = bin2hex(random_bytes(40));

                    // Store the token in the database
                    DB::select('CALL Insert_Token(?, ?, @message)', [$account_id, $token]);
                    $insertTokenResult = DB::select('SELECT @message AS message')[0];
                    $insertTokenMessage = $insertTokenResult->message;
                    if ($insertTokenMessage == 'Token inserted successfully.') {
                        return $this->respond([
                            'token' => $token,
                            'user' => [
                                'account_id' => $account_id,
                                'email' => $email
                            ],
                            'message' => 'Login successful.',
                        ], $request, 200);
                    } else {
                        return $this->respond(['error' => 'Failed to add token.'], $request, 500);
                    }
                }

            }

        } catch (\Exception $e) {
            \Log::error('Login Error: ' . $e->getMessage());
            return $this->respond(['error' => $e], $request, 500);
        }
    }

    /**
     * Register a new user.
     */
    public function register(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required|string|email|max:255',
                'password' => 'required|string|min:8',]);

            if ($validator->fails()) {
                return $this->respond(['errors' => $validator->errors()], $request, 422);
            }

            // Hash the password
            $hashedPassword = Hash::make($request->password);
            $subscriptionId = $request->input('subscription_id');
            $email = $request->input('email');

            DB::select('CALL Register_User(?, ?, ?, @result_message)', [$email, $hashedPassword, $subscriptionId]);

            $result = DB::select('SELECT @result_message AS message')[0];

            $message = $result->message;

            if ($message == 'User registered successfully.') {
                return $this->respond([
                    'message' => 'User registered successfully.',
                ], $request, 201);
            } elseif ($message == 'Email already exists.') {
                return $this->respond([
                    'error' => 'Email already exists.',
                ], $request, 400);
            }
        } catch (\Exception $e) {
            \Log::error('Register Error: ' . $e->getMessage());
            return $this->respond(['error' => $e], $request, 500);
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
                return $this->respond(['error' => 'No token provided.'], $request, 400);
            }

            // Check if the token exists in the database
            $tokenExists = DB::select('SELECT * FROM Get_Token WHERE token = ?', [$token]);

            if (!$tokenExists) {
                return $this->respond(['error' => 'Token not found or invalid.'], $request, 404);
            }

            // Delete the token from the database
            DB::select('CALL Delete_Token(?, @message)', [$token]);

            $result = DB::select('SELECT @message AS message')[0];
            $message = $result->message;

            if ($message == 'Token deleted successfully.') {
                return $this->respond(['message' => 'Logged out successfully.'], $request, 200);
            } else {
                return $this->respond(['error' => 'Failed to log out.'], $request, 500);
            }
        } catch (\Exception $e) {
            \Log::error('Logout Error: ' . $e->getMessage());
            return $this->respond(['error' => $e], $request, 500);
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
                return $this->respond(['errors' => $validator->errors()], $request, 422);
            }

            $password = $request->input('password');
            $email = $request->input('email');

            $password = Hash::make($password);
            //Make this work with tokens somehow
            DB::select('CALL Update_Password(?, ?, @result_message)', [$email, $password]);
            $result = DB::select('SELECT @result_message AS result_message')[0];
            $message = $result->result_message;

            if ($message == 'Password updated successfully.') {
                return $this->respond(['message' => $message], $request, 200);
            } else {
                return $this->respond(['error' => $message], $request, 404);
            }

        } catch (\Exception $e) {
            \Log::error('Reset Password Error: ' . $e->getMessage());
            return $this->respond(['error' => $e], $request, 500);
        }
    }

    /**
     * Block an account by its ID.
     */
    public function blockAccount(Request $request)
    {
        try {
            $email = $request->input('email');
            DB::select('CALL Block_User(?, @message)', [$email]);

            $result = DB::select('SELECT @message AS message')[0];
            $message = $result->message;

            if ($message == 'User successfully blocked.') {
                return $this->respond(['message' => $message], $request, 200);
            } else if ($message == 'User not found.') {
                return $this->respond(['error' => $message], $request, 404);
            } else {
                return $this->respond(['error' => $message], $request, 400);
            }

        } catch (\Exception $e) {
            \Log::error('Block Account Error: ' . $e->getMessage());
            return $this->respond(['error' => $e], $request, 500);
        }
    }

    /**
     * Delete a profile by its ID.
     */
    public function deleteProfile($id, Request $request)
    {
        try {
            DB::select('CALL Remove_Profile(?, @message)', [$id]);

            $result = DB::select('SELECT @message AS message')[0];

            $message = $result->message;

            if ($message == 'Profile removed successfully.') {
                return $this->respond(['message' => $message], $request, 200);
            } else {
                return $this->respond(['message' => $message], $request, 404);
            }
        } catch (\Exception $e) {
            return $this->respond(['error' => $e], $request, 500);
        }
    }

    /**
     * Add a new profile for an account.
     */
    public function addProfile(Request $request)
    {
        try {
            // Validate the request
            $validatedData = $request->validate([
                'account_id' => 'required|integer',
                'profile_name' => 'required|string|max:255',
                'profile_age' => 'required|integer|min:1',
                'profile_lang' => 'required|integer',
            ]);

            $account_id = $validatedData['account_id'];
            $profile_name = $validatedData['profile_name'];
            $profile_age = $validatedData['profile_age'];
            $profile_lang = $validatedData['profile_lang'];
            $profile_image = $request->input('profile_image');
            $profile_movies_preferred = $request->input('profile_movies_preferred');

            DB::select('CALL Add_Profile(?, ?, ?, ?, ?, ?, @result_message)', [$account_id, $profile_name, $profile_image,
                $profile_age, $profile_lang, $profile_movies_preferred]);

            $result = DB::select('SELECT @result_message AS result_message')[0];
            $message = $result->result_message;

            if ($message == 'Profile added successfully.') {
                return $this->respond(['message' => 'Profile added successfully.'], $request, 201);
            } else if ($message == 'Account not found.') {
                return $this->respond(['message' => $message], $request, 404);
            } else {
                return $this->respond(['error' => $message], $request, 400);
            }
        } catch (\Exception $e) {
            return $this->respond(['error' => $e], $request, 500);
        }
    }

    public function deleteAccount(Request $request, $id)
    {
        try {

            DB::select('CALL Remove_Account(?, @message)', [$id]);

            $result = DB::select('SELECT @message AS message')[0];
            $message = $result->message;

            if ($message == 'Account removed successfully.') {
                return $this->respond(['message' => $message], $request, 200);
            } else {
                return $this->respond(['message' => $message], $request, 404);
            }

        } catch (\Exception $e) {
            return $this->respond(['error' => $e], $request, 500);
        }
    }

}
