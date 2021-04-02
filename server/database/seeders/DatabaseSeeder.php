<?php

namespace Database\Seeders;

use App\Models\Hospital;
use App\Models\User;
use App\Models\Trail;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Create 100 random users
        User::factory(100)
            ->create();

        // Create 10 random hospitals with 5 random trails
        Hospital::factory(10)
            ->has(Trail::factory()->count(5))
            ->create();
    }
}
