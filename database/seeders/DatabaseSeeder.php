<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory(10)->create();

        $user=\App\Models\User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@gmai.com',
            'password'=> 'admin@123',
        ]);

        $guest = \App\Models\User::factory()->create([
            'id' => 0,
            'name' => 'guest',
            'email' => 'guest@gmail.com',
            'password'=> 'guest@123',
        ]);

        $guest->assignRole('User');
        
        $user->assignRole('Admin');

        
    }
}
