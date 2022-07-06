<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\WeekSchedule>
 */
class WeekScheduleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'restaurant_id' => 1,
            'day' => $this->faker->unique()->numberBetween(1, 7),
            'start' => $this->faker->time('H:i'),
            'end' => $this->faker->time('H:i'),
        ];
    }
}
