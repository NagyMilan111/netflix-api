<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class SubscriptionFactory extends Factory
{
    public function definition()
    {
        return [
            'subscription_name' => $this->faker->word, // Random word for subscription name
            'subscription_price' => $this->faker->randomFloat(2, 5, 20), // Price between 5 and 20
        ];
    }
}