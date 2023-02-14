<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = Role::create(['name' => 'admin']);

        $createPost = Permission::create(['name' => 'create posts']);
        $editPost = Permission::create(['name' => 'edit posts']);
        $deletePost = Permission::create(['name' => 'delete posts']);

        $admin->syncPermissions([
            $createPost,
            $editPost,
            $deletePost
        ]);
    }
}
