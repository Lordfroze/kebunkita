<?php

namespace Database\Seeders;

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
        if (app()->environment('local', 'testing')) {
            User::factory()->create([
                'name' => 'Admin',
                'email' => 'admin@kebunkita.test',
                'password' => bcrypt('admin123'),
                'role' => 'admin',
            ]);

            User::factory()->create([
                'name' => 'User',
                'email' => 'user@kebunkita.test',
                'password' => bcrypt('user123'),
                'role' => 'user',
            ]);
        }

        if (env('ADMIN_NAME') && env('ADMIN_EMAIL') && env('ADMIN_PASSWORD')) {
            User::firstOrCreate(
                ['email' => env('ADMIN_EMAIL')],
                [
                    'name' => env('ADMIN_NAME'),
                    'password' => bcrypt(env('ADMIN_PASSWORD')),
                    'role' => 'admin',
                ]
            );
        }
    }
}
