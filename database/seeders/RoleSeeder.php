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
        $user  = Role::create(['name' => 'user']);

        $createPost = Permission::create(['name' => 'create.posts'])->syncRoles([$admin, $user]);
        $editPost   = Permission::create(['name' => 'edit.posts'])->syncRoles([$admin]);
        $deletePost = Permission::create(['name' => 'delete.posts'])->syncRoles([$admin]);

        // $admin->syncPermissions([$createPost, $editPost, $deletePost]);
        // $user->syncPermissions([$createPost, $editPost, $deletePost]);
    }
}
