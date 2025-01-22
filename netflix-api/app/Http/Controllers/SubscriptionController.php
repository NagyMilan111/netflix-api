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

        if ($result[0] == null) {
            return response()->json(['error' => 'Subscription details not found.'], 404);
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


        $user_id = $request->input('user_id');
        $subscription_id = $request->input('subscription_id');
        DB::select('CALL Update_User_Subscription(?, ?)', [$user_id, $subscription_id]);

        $result = DB::select('SELECT @message as message')[0];
        $message = $result->message;

        if ($message == 'Subscription updated successfully.') {
            return response()->json(['message' => 'Subscription updated successfully.'], 200);
        }
        elseif ($result[0] = 'Failed to update subscription.'){
            return response()->json(['error' => $message], 400);
        }
        else {
            return response()->json(['error' => $message], 404);
        }
    }
}
