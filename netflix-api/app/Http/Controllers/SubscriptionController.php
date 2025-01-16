<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SubscriptionController extends Controller
{
    /**
     * Get subscription details for a user.
     */
    public function getSubscriptionDetails($userId)
    {

        $result = DB::select('SELECT * FROM Get_Subscription_Details WHERE user_id = ?', [$userId]);

        if ($result == null) {
            return response()->json(['error' => 'Subscription details not found'], 404);
        }
        else {
            return response()->json(['details' => $result], 200);
        }
    }

    /**
     * Update a user's subscription.
     */
    public function updateSubscription(Request $request)
    {
        // Validate input
        $validatedData = $request->validate([
            'user_id' => 'required|integer|exists:Account,account_id',
            'subscription_id' => 'required|integer|exists:Subscription,subscription_id',
        ]);


        $userId = $validatedData['user_id'];
        $subscriptionId = $validatedData['subscription_id'];
        $result = DB::select('CALL Update_User_Subscription(?, ?)', [$userId, $subscriptionId]);

        if ($result[0] == 'Subscription updated successfully.') {
            return response()->json(['message' => 'Subscription updated successfully.'], 200);
        }
        elseif ($result[0] = 'Failed to update subscription.'){
            return response()->json(['error' => $result[0]], 400);
        }
        else {
            return response()->json(['error' => $result[0]], 404);
        }
    }
}
