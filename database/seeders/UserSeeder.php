<?php

namespace Database\Seeders;

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
        // add seed for superadmin 
        \App\Models\User::create([
            'name' => 'Superadmin',
            'email' => 'whykris97@gmail.com',
            'password' => bcrypt('super4dm1n'),
            'level' => 'superadmin',
        ]);
    }
}
