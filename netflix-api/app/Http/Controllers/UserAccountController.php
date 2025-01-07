<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserAccountController extends Controller
{
    /**
     * Add a new profile for a user.
     */
    public function addProfile(Request $request)
    {
        // Validate input
        $validatedData = $request->validate([
            'account_id' => 'required|integer|exists:Account,account_id',
            'profile_name' => 'required|string|max:255',
            'profile_age' => 'required|integer|min:1',
            'profile_lang' => 'required|integer|exists:Language,lang_id',
        ]);

        // Insert the profile into the database
        DB::insert('
            INSERT INTO Profile (account_id, profile_name, profile_image, profile_age, profile_lang, created_at, updated_at)
            VALUES (?, ?, ?, ?, ?, NOW(), NOW())
        ', [
            $validatedData['account_id'],
            $validatedData['profile_name'],
            'placeholder.jpeg', // Default image
            $validatedData['profile_age'],
            $validatedData['profile_lang'],
        ]);

        return response()->json(['message' => 'Profile added successfully']);
    }

    /**
     * Update a user's subscription.
     */
    public function updateSubscription(Request $request)
    {
        // Validate input
        $validatedData = $request->validate([
            'account_id' => 'required|integer|exists:Account,account_id',
            'subscription_id' => 'required|integer|exists:Subscription,subscription_id',
            'billed_from' => 'required|date',
        ]);

        // Update the subscription in the database
        DB::update('
            UPDATE Account
            SET subscription_id = ?, billed_from = ?, updated_at = NOW()
            WHERE account_id = ?
        ', [
            $validatedData['subscription_id'],
            $validatedData['billed_from'],
            $validatedData['account_id'],
        ]);

        return response()->json(['message' => 'Subscription updated successfully']);
    }

    /**
     * Get a user's watchlist.
     */
    public function getWatchHistory($accountId)
    {
        // Fetch watchlist for the given account
        $watchHistory = DB::select('
            SELECT mw.media_id, m.title, mw.pause_spot, mw.last_watch_date
            FROM Profile_Watched_Media mw
            INNER JOIN Media m ON mw.media_id = m.media_id
            WHERE mw.profile_id IN (
                SELECT profile_id FROM Profile WHERE account_id = ?
            )
        ', [$accountId]);

        return response()->json(['watchHistory' => $watchHistory]);
    }

    /**
     * Manage a user's watchlist (add or remove media).
     */
    public function manageWatchList($mediaId, Request $request)
    {
        // Validate input
        $validatedData = $request->validate([
            'profile_id' => 'required|integer|exists:Profile,profile_id',
            'action' => 'required|in:add,remove',
        ]);

        if ($validatedData['action'] === 'add') {
            // Add media to the watchlist
            DB::insert('
                INSERT INTO Profile_Watch_List (profile_id, media_id, created_at)
                VALUES (?, ?, NOW())
            ', [
                $validatedData['profile_id'],
                $mediaId,
            ]);

            return response()->json(['message' => 'Media added to watchlist']);
        } else {
            // Remove media from the watchlist
            $deleted = DB::delete('
                DELETE FROM Profile_Watch_List WHERE profile_id = ? AND media_id = ?
            ', [
                $validatedData['profile_id'],
                $mediaId,
            ]);

            return response()->json([
                'message' => $deleted ? 'Media removed from watchlist' : 'Media not found in watchlist',
            ]);
        }
    }
}
?>