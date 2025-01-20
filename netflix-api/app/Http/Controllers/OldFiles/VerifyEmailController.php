<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class VerifyEmailController extends Controller
{
    /**
     * Handle email verification.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function verify(Request $request)
    {
        // Find the user by ID from the URL
        $user = User::findOrFail($request->route('id'));

        // Check if the hash matches the user's email hash
        if (!hash_equals((string) $request->route('hash'), sha1($user->getEmailForVerification()))) {
            return response()->json(['message' => 'Invalid or expired verification link'], 400);
        }

        // If the email is already verified
        if ($user->hasVerifiedEmail()) {
            return response()->json(['message' => 'Email already verified'], 200);
        }

        // Mark the email as verified
        $user->markEmailAsVerified();

        return response()->json(['message' => 'Email verified successfully'], 200);
    }
}
?>
