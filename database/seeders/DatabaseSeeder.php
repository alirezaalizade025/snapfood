<?php

namespace Database\Seeders;

use App\Models\Food;
use App\Models\Address;
use App\Models\Comment;
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
        \App\Models\FoodType::factory(4)->create();
        \App\Models\User::factory()->create([
            'name' => 'Admin',
            'phone' => '091234567890',
            'email' => 'admin@admin.com',
            'password' => bcrypt('admin'),
            'role' => 'admin',
            'bank_account_number' => '1234567891234',
        ]);
        \App\Models\User::factory(15)->create();
        \App\Models\Restaurant::factory(3)->create();
        \App\Models\FoodParty::factory(5)->create();
        Food::factory(100)->create();
        Address::factory(10)->create();
        Comment::factory(1000)->create();
    }
}
