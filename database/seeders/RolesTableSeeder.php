<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\UserRole;
use Illuminate\Support\Facades\Hash;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
    //     $adminRole=UserRole::create(['name' => 'admin']);
    //     $adminUser = UserRole::create([
    //         'name' => 'Admin User',
    //         'email' => 'admin@example.com',
    //     ], 
    //     [
    //         'password' => Hash::make('admin@123'),
    //     ]);

    //     // Assign the admin role to the admin user
    //     $adminUser->roles()->sync([$adminRole->id]);

    //     UserRole::create(['name' => 'user']);
    }
}
