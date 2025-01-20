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
        // Fetch subscription details for the given user ID
        $subscriptionDetails = DB::table('Account as a')
            ->join('Subscription as s', 'a.subscription_id', '=', 's.subscription_id')
            ->where('a.account_id', $userId)
            ->select('s.subscription_name', 's.subscription_price', 'a.billed_from', 'a.discount_active')
            ->first();

        if (!$subscriptionDetails) {
            return response()->json(['error' => 'Subscription details not found'], 404);
        }

        return response()->json(['details' => $subscriptionDetails], 200);
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
            'billed_from' => 'required|date',
            'discount_active' => 'nullable|boolean',
        ]);

        // Check if the account exists
        $account = DB::table('Account')->where('account_id', $validatedData['user_id'])->first();

        if (!$account) {
            return response()->json(['error' => 'User not found'], 404);
        }

        // Attempt to update the subscription for the user
        try {
            $updated = DB::table('Account')
                ->where('account_id', $validatedData['user_id'])
                ->update([
                    'subscription_id' => $validatedData['subscription_id'],
                    'billed_from' => $validatedData['billed_from'],
                    'discount_active' => $validatedData['discount_active'] ?? 0,
                ]);

            if ($updated === 0) {
                return response()->json(['error' => 'No changes were made to the subscription'], 400);
            }

            return response()->json(['message' => 'Subscription updated successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update subscription', 'details' => $e->getMessage()], 500);
        }
    }
}
