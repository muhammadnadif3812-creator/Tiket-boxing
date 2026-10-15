<?php

namespace Database\Seeders;


use App\Models\User;
use Illuminate\Console\Scheduling\Event;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@example.com',
            'password' => Hash::Make('password123')
        ]);
        
        $this->call([
            EnevtSeeders::class,
        ]);
    }
}
