<?php

namespace Database\Seeders;

use App\Models\Food;
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
        // \App\Models\User::factory(10)->create();
        \App\Models\FoodType::factory(4)->create();
        \App\Models\Restaurant::factory(50)->create();
        \App\Models\FoodParty::factory(4)->create();
        \App\Models\Food::factory(100)->create();

        \App\Models\User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'phone' => '09123456789',
            'password' => bcrypt('admin'),
            'role' => 'admin',
            'bank_account_number' => '1234567891234',

        ]);
    }
}
