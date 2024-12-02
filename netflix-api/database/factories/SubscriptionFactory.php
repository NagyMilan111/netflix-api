<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Subscription>
 */
class SubscriptionFactory extends Factory
{
    public function definition()
    {
        return [
            'subscription_name' => $this->faker->unique()->randomElement(['Basic', 'Standard', 'Premium']),
            'subscription_price' => $this->faker->randomFloat(2, 5, 20), // Price between 5 and 20
        ];
    }
}
