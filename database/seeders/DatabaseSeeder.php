<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name'      => 'Administrator',
            'email'     => 'admin@gmail.com',
            'birthday'  => '',
            'gender'    => 'male',
            'number'    => '',
            'image'    => '',
            'address'   => 'Bulua, Cagayan de Oro City',
            'username'  => 'admin',
            'password'  => bcrypt('admin'),
            'role'      => 0,
        ]);
    }
}

