<?php

namespace Database\Seeders;

use App\Models\Cart;
use App\Models\Food;
use App\Models\User;
use App\Models\Image;
use App\Models\Address;
use App\Models\Comment;
use App\Models\CartFood;
use App\Models\Category;
use App\Models\FoodParty;
use App\Models\Restaurant;
use App\Models\WeekSchedule;
use Illuminate\Database\Seeder;
use App\Models\CategoryRestaurant;
use App\Models\CartRestaurant;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Category::create(['name' => 'fast food']);
        Category::create(['name' => 'traditional']);
        Category::create(['name' => 'international']);
        Category::create(['name' => 'sea food']);
        Category::factory(30)->create();
        User::factory()->create([
            'name' => 'Admin',
            'phone' => '091234567890',
            'email' => 'admin@admin.com',
            'password' => bcrypt('admin'),
            'role' => 'admin',
            'bank_account_number' => '1234567891234',
        ]);
        User::factory(200)->create()->each(function($user) {
            for($i = 0; $i < rand(1,3); $i++) {
                $user->addresses()->save(Address::factory()->make());
            }
        });

        Restaurant::factory(50)->create()->each(function ($restaurant) {
            $restaurant->addressInfo()->save(Address::factory()->make());
            // $restaurant->image()->save(Image::factory()->make());
            // $restaurant->category()->saveMany(Category::inRandomOrder()->take(rand(1, 3))->get());
            // $restaurant->saveMany(WeekSchedule::factory(rand(1, 3))->make());
        });
        CategoryRestaurant::factory(75)->create();
        FoodParty::factory(5)->create();
        Food::factory(100)->create();
        // Address::factory(200)->create();
        Cart::factory(75)->create();
        Comment::factory(1000)->create();
        WeekSchedule::factory(6)->create();
        Image::factory(100)->create();
        CartFood::factory(100)->create();
    }
}
