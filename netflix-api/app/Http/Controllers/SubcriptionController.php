<?php

    namespace App\Http\Controllers;
    use Illuminate\Support\Facades\DB;

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

        public function addSubscription()
        {
            DB::insert('INSERT INTO Subscription (subscription_name, subscription_price) VALUES ( ?, ?)', [
                'test',
                5.1
            ]);

            return redirect('/')->with('success', 'Row added successfully!');
        }
    }
?>
