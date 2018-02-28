<?php

use Illuminate\Database\Seeder;
use App\Role;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory('App\User')->create([
            'name' => 'Allu Admin',
            'slug' => str_slug('Allu Admin'),
            'email' => 'allu@gmail.com',
            'password' => bcrypt('secret')
        ]);

        User::first()->roles()->attach(Role::first());

        factory('App\User')->create([
            'name' => 'Mole Moderaattori',
            'slug' => str_slug('Mole Moderaattori'),
            'email' => 'mole@gmail.com',
            'password' => bcrypt('secret')
        ]);

        User::find(2)->roles()->attach(Role::find(2));

        factory('App\User', 2)->create();
    }
}
