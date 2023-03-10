<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name' => 'Manuel Echavarria',
            'email' => 'echavarria_007@hotmail.com',
            'password' => bcrypt('Maet@123'),
        ])->assignRole('admin');

        User::factory(99)->create();
    }
}
