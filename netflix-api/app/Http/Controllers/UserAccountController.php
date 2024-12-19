<?php

    namespace App\Http\Controllers;

    use Illuminate\Http\Request;

    class UserAccountController extends Controller
    {
        public function addProfile(Request $request)
        {
            return response()->json(['message' => 'Profile added successfully']);
        }

        public function updateSubscription(Request $request)
        {
            return response()->json(['message' => 'Subscription updated']);
        }

        public function getWatchHistory($userId)
        {
            return response()->json(['watchHistory' => []]);
        }

        public function manageWatchList($mediaId, Request $request)
        {
            return response()->json(['message' => 'Watchlist updated']);
        }
    }
?>