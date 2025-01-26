<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SubscriptionController extends Controller
{
    /**
     * Get subscription details for a user.
     */
    public function getSubscriptionDetails(Request $request)
    {

        $account_id = $request->input('account_id');

        $result = DB::select('SELECT * FROM Get_Subscription_Details WHERE account_id = ?', [$account_id]);

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

        $account_id = $request->input('account_id');
        $subscription_id = $request->input('subscription_id');
        DB::select('CALL Update_Account_Subscription(?, ?, @message)', [$account_id, $subscription_id]);

        $result = DB::select('SELECT @message as message')[0];
        $message = $result->message;

        if ($message == 'Subscription updated successfully.') {
            return response()->json(['message' => 'Subscription updated successfully.'], 200);
        }
        elseif ($message = 'Failed to update subscription.'){
            return response()->json(['error' => $message], 400);
        }
        else {
            return response()->json(['error' => $message], 404);
        }
    }
}
