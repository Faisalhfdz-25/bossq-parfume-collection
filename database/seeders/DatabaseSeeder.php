<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory(1)->create();
        // Create an admin user
        \App\Models\User::factory()->admin()->create();

        \App\Models\User::factory()->create([
            'name' => 'Sherly Mardian',
            'email' => 'sherlymrdn12@gmail.com',
            'password' =>  Hash::make('Mardian432'),
            'role' => 'admin'
        ]);
    }
}
