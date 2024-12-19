<?php

    namespace App\Http\Controllers;

    class SubscriptionController extends Controller
    {
        public function getSubscriptionDetails($userId)
        {
            return response()->json(['details' => []]);
        }

        public function updateSubscription(Request $request)
        {
            return response()->json(['message' => 'Subscription updated']);
        }
    }
?>