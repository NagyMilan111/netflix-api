<?php

    namespace App\Http\Controllers;

    use Illuminate\Http\Request;

    class AccountController extends Controller
    {
        public function login(Request $request)
        {
            return response()->json(['token' => 'dummy_token']);
        }

        public function register(Request $request)
        {
            return response()->json(['message' => 'User registered successfully']);
        }

        public function resetPassword(Request $request)
        {
            return response()->json(['message' => 'Password reset']);
        }

        public function blockAccount($id)
        {
            return response()->json(['message' => 'Account blocked']);
        }
    }
?>