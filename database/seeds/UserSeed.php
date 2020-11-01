<?php

use Illuminate\Database\Seeder;
use App\User;

class UserSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('123456')
        ]);
        $user->assignRole('administrator');

        $user = User::create([
            'name' => 'Employee One',
            'email' => 'employee@one.com',
            'password' => bcrypt('123456')
        ]);
        $user->assignRole('employee');

        $user = User::create([
            'name' => 'Employee Two',
            'email' => 'employee@two.com',
            'password' => bcrypt('123456')
        ]);
        $user->assignRole('employee');

    }
}
