<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Task;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        for ($i = 0; $i < 10; $i++) {
            Task::factory()->create([
                'name' => ucfirst(fake()->words(\rand(2, 5), true)),
                'description' => ucfirst(fake()->paragraph(1))
            ]);
        }
    }
}
