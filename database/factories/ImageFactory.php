<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Restaurant;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\image>
 */
class ImageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $image = [
            'imageable_type' => $this->faker->randomElement([
                User::class ,
                Restaurant::class ,
                Food::class ,
            ]),
            'path' => 'https://picsum.photos/200/300',
        ];

        if ($image['imageable_type'] == 'App\Models\User') {
            $image['imageable_id'] = User::all()->unique()->random()->id;
        }
        elseif ($image['imageable_type'] == 'App\Models\Restaurant') {
            $image['imageable_id'] = Restaurant::all()->unique()->random()->id;
        }
        else {
            $image['imageable_id'] = Restaurant::all()->random()->id;
        }

        return $image;
    }
}
