<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Restaurant;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Contact>
 */
class ContactFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $contact = [
            'title' => $this->faker->randomElement(['job', 'home', 'office', 'other']),
            'contactable_type' => $this->faker->randomElement([
                User::class ,
                Restaurant::class ,
            ]),
            'phone' => $this->faker->regexify('09\\d{9}$'),
            'address' => $this->faker->address,
            'latitude' => $this->faker->latitude,
            'longitude' => $this->faker->longitude,
        ];

        if ($contact['contactable_type'] == 'App\Models\User') {
            $contact['contactable_id'] = User::where('role', 'customer')->get()->random()->id;
        }
        else {
            $contact['contactable_id'] = Restaurant::all()->random()->id;
        }
        return $contact;
    }
}
