<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Reservation>
 */
class ReservationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $dateTime = $this->faker->dateTimeBetween('now', '+1 month');
        return [
            'table_id' => $this->faker->numberBetween(1, 20),
            'customer_id' => $this->faker->numberBetween(2, 30),
            'from' => $dateTime,
            'to' => $dateTime->modify('+2 hours'),
        ];
    }
}
