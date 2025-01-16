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
        $subscriptionDetails = DB::select('
            SELECT 
                s.subscription_name,
                s.subscription_price,
                a.billed_from,
                a.discount_active
            FROM Account a
            INNER JOIN Subscription s ON a.subscription_id = s.subscription_id
            WHERE a.account_id = ?
        ', [$userId]);

        if (empty($subscriptionDetails)) {
            return response()->json(['error' => 'Subscription details not found'], 404);
        }

        return response()->json(['details' => $subscriptionDetails[0]]);
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

        // Update the subscription for the given user
        $updated = DB::update('
            UPDATE Account 
            SET subscription_id = ?, billed_from = ?, discount_active = ?, updated_at = NOW()
            WHERE account_id = ?
        ', [
            $validatedData['subscription_id'],
            $validatedData['billed_from'],
            $validatedData['discount_active'] ?? 0,
            $validatedData['user_id'],
        ]);

        if (!$updated) {
            return response()->json(['error' => 'Failed to update subscription'], 500);
        }

        return response()->json(['message' => 'Subscription updated successfully']);
    }
}
?>