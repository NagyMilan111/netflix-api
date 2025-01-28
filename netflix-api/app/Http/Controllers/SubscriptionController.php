<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SubscriptionController extends Controller
{
    /**
     * Get subscription details for a user.
     */
    public function getSubscriptionDetails($id, Request $request)
    {
        try {
            $result = DB::select('SELECT * FROM Get_Subscription_Details WHERE account_id = ?', [$id]);

            if ($result[0] == null) {
                return $this->respond(['error' => 'Subscription details not found.'], $request, 404);
            } else {
                return $this->respond(['details' => $result], $request, 200);
            }
        }
        catch (\Exception $e) {
            return $this->respond(['error' => $e], $request, 500);
        }
    }

    /**
     * Update a user's subscription.
     */
    public function updateSubscription(Request $request)
    {
        try {
            $account_id = $request->input('account_id');
            $subscription_id = $request->input('subscription_id');
            DB::select('CALL Update_Account_Subscription(?, ?, @message)', [$account_id, $subscription_id]);

            $result = DB::select('SELECT @message as message')[0];
            $message = $result->message;

            if ($message == 'Subscription updated successfully.') {
                return $this->respond(['message' => 'Subscription updated successfully.'], $request, 200);
            } elseif ($message = 'Failed to update subscription.') {
                return $this->respond(['error' => $message], $request, 400);
            } else {
                return $this->respond(['error' => $message], $request, 404);
            }
        } catch(\Exception $e) {
            return $this->respond(['error' => $e], $request, 500);
        }
    }
}
