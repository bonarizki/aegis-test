<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create 50 random orders using the factory
        User::factory(50)->create();

        // Create 750 random orders using the factory
        Order::factory(750)->create(); // Create 750 orders with random data
    }
}
