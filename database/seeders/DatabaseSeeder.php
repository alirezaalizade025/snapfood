<?php

namespace Database\Seeders;

use App\Models\Food;
use App\Models\User;
use App\Models\Address;
use App\Models\Comment;
use App\Models\FoodType;
use App\Models\FoodParty;
use App\Models\Restaurant;
use App\Models\WeekSchedule;
use Illuminate\Database\Seeder;
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
        FoodType::factory(4)->create();
        User::factory()->create([
            'name' => 'Admin',
            'phone' => '091234567890',
            'email' => 'admin@admin.com',
            'password' => bcrypt('admin'),
            'role' => 'admin',
            'bank_account_number' => '1234567891234',
        ]);
        User::factory(15)->create();
        Restaurant::factory(3)->create();
        FoodParty::factory(5)->create();
        Food::factory(100)->create();
        Address::factory(10)->create();
        Comment::factory(1000)->create();
        WeekSchedule::factory(6)->create();
    }
}
