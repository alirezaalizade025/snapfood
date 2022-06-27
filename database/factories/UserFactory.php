<?php

namespace Database\Factories;

use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Laravel\Jetstream\Features;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'password' => bcrypt('admin'),
            'phone' => $this->faker->regexify('09\\d{9}$'),
            'role' => $this->faker->randomElement(['restaurant', 'customer']),
            'bank_account_number' => $this->faker->unique()->regexify('\\d{16}$'),
        ];
    }
}
