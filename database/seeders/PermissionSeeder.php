<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
        'create_post', 
        'edit_post', 
        'show_posts', 
        'delete_post',
        'create_comment', 
        'delete_comment',
        'delete_user',
        'show_all_users',
        'view_post',
    ];
        foreach ( $permissions as $permission)
        {
            Permission::create(['name' => $permission]);
        }

        $role =Role::create(['name'=>'User']);
        $role->givePermissionTo('create_post', 'edit_post', 'show_posts', 'delete_post','create_comment','view_post');


        $role =Role::create(['name'=>'Admin']);
        $role->givePermissionTo($permissions);

    }
}
