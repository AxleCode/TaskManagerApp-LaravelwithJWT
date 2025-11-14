<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

          // Buat user biasa
          User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'role' => 0,
            'password' => bcrypt('password'),
        ]);

        // Buat admin
        User::factory()->create([
            'name' => 'Test Admin',
            'email' => 'admin@example.com',
            'role' => 1,
            'password' => bcrypt('password'),
        ]);
    }
}
